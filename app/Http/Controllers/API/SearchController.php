<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SearchController extends Controller
{
    public function index(Request $req)
    {
        $query = $req->input("q");

        $courses = Course::where('is_published', true)
            ->where(function($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")->orWhere('description', 'LIKE', "%{$query}%")->orWhereHas('teacher', function($teacherQuery) use ($query) 
                {
                    $teacherQuery->where('name', 'LIKE', "%{$query}%");
                });
            })
            ->with(['category', 'teacher'])
            ->limit(10)
            ->get()
            ->map(function($course) {
                return [
                    'id' => $course->id,
                    'title' => $course->title,
                    'description' => \Illuminate\Support\Str::limit($course->description, 100),
                    'price' => $course->price,
                    'thumbnail' => $course->thumbnail ? Storage::url($course->thumbnail) : null,
                    'category' => $course->category->name ?? null,
                    'teacher' => $course->teacher->name ?? null,
                    'url' => route('showCourse', $course),
                ];
            });

        $categories = Category::where('name', 'LIKE', "%{$query}%")
            ->limit(5)
            ->get()
            ->map(function($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'url' => route('courses', ['category_id' => $category->id]),
                ];
            });

        return response()->json([ "courses" => $courses, "categories" => $categories ]);
    }
}
