<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function admin() 
    {
        $user = Auth::user();

        if(!$user)
        {
            return redirect('/register');
        }

        if (auth()->user()->role !== 'admin') {
            return view('errors.403');
        }

        return view('admin.admin');
    }
}
