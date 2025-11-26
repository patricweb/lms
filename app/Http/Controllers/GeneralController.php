<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function landing()
    {
        return view("landing");
    }

    public function contacts()
    {
        return view("general.contacts");
    }

    public function features()
    {
        return view("general.features");
    }
}
