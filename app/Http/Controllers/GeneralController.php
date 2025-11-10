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
        return view("general.home-page");
    }

    public function about()
    {
        return view("general.about");
    }

    public function contacts()
    {
        return view("general.contacts");
    }
}
