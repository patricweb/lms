<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function profile()
    {
        $user = Auth::user();

        if(!$user)
        {
            return redirect('/register');
        }

        return view('profile', ['user' => $user]);
    }

    public function showUser($id)
    {
        $user = User::findOrFail($id);

        return view('users.show');
    }
}
