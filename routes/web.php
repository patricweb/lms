<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeneralController;

Route::get("/", [GeneralController::class, "landing"])->name("landing");

Route::get("/home", [GeneralController::class, "home_page"])->name("home-page");

Route::get("/profile", [GeneralController::class, "profile"])->name("profile");