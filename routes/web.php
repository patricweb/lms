<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\AuthController;

Route::get("/", [GeneralController::class, "landing"])->name("landing");

Route::get("/home", [GeneralController::class, "home_page"])->name("home-page");

Route::get("/profile", [GeneralController::class, "profile"])->name("profile");

Route::get("/register", [AuthController::class, 'register'])->name('register');

Route::get("/login", [AuthController::class, 'login'])->name('login');