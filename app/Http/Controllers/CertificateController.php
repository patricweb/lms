<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Certificate;
use App\Models\Course;

class CertificateController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) 
        {
            return redirect('/login');
        }

        $certificates = $user->certificates()
            ->with('course.category', 'course.teacher')
            ->orderBy('issued_at', 'desc')
            ->get();

        return view('certificates.index', compact('certificates', 'user'));
    }

    public function show(Certificate $certificate)
    {
        $user = Auth::user();

        if (!$user) 
        {
            return redirect('/login');
        }

        if ($certificate->user_id !== $user->id) 
        {
            return response()->view('errors.403', [], 403);
        }

        $certificate->load('course.category', 'course.teacher', 'user');

        return view('certificates.show', compact('certificate', 'user'));
    }

    public function generate(Course $course)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login');
        }

        if (!$course->isCompletedByUser($user)) 
        {
            return redirect()->route('showCourse', $course);
        }

        if ($course->hasCertificateForUser($user)) 
        {
            $certificate = $course->certificates()->where('user_id', $user->id)->first();

            return redirect()->route('certificates.show', $certificate);
        }

        $certificate = Certificate::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'certificate_number' => Certificate::generateCertificateNumber(),
            'issued_at' => now(),
        ]);

        return redirect()->route('certificates.show', $certificate);
    }
}
