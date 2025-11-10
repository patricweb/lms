<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

Route::get("/", [GeneralController::class, "landing"])->name("landing");

Route::get("/home", [GeneralController::class, "home_page"])->name("home");

Route::get("/about", [GeneralController::class, "about"])->name('about');

Route::get("/contacts", [GeneralController::class, "contacts"])->name("contacts");

Route::get("/profile", [UserController::class, "profile"])->name("profile");

Route::get("/register", [AuthController::class, 'register'])->name('register');

Route::post("/register", [AuthController::class, "registerPost"])->name("registerPost");

Route::get("/login", [AuthController::class, 'login'])->name('login');

Route::post("/login", [AuthController::class, "loginPost"])->name("loginPost");

Route::get("/logout", [AuthController::class, "logout"])->name("logout");

Route::get("/show-user/{id}", [UserController::class, "showUser"])->name("userShow");

Route::get("/admin", [AdminController::class, 'admin'])->name("admin");

Route::fallback(function () { return response()->view('errors.404', [], 404); });