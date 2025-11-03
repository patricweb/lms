<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function landing()
    {
        return view("landing");
    }

    public function home_page()
    {
        return view("home-page");
    }

    public function profile()
    {
        return view("profile");
    }
}
