<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
        $user = Auth::user();

        if($user)
        {
            return redirect()->route("profile");
        }

        return view('auth.login');
    }

    public function register()
    {
        $user = Auth::user();

        if($user)
        {
            return redirect()->route("profile");
        }

        return view('auth.register');
    }

    public function registerPost(Request $req)
    {
        $data = $req->validate([
            "name" => ["required", "string"],
            "email" => ["required", "email", "unique:users,email"],
            "password" => ["required", "min:8", "confirmed"]
        ]);

        $data["password"] = Hash::make($data["password"]);

        User::create($data);

        return redirect()->route("login");
    }

    public function loginPost(Request $req)
    {
        $data = $req->validate([
            "email" => ["required", "email", ],
            "password" => ["required"]
        ]);

        $remember = $req->has('remember');

        if (Auth::attempt($data, $remember)) 
        {
            $req->session()->regenerate();

            return redirect()->route("profile");
        }
        else
        {
            return back()->withErrors([
                "email" => "Email/Paasword invalid"
            ]);
        }
    }

    public function logout(Request $req)
    {
        Auth::logout();

        $req->session()->invalidate();
        $req->session()->regenerateToken();

        return redirect()->route("landing");
    }
}
