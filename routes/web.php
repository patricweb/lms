<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ModuleController;

Route::get("/", [GeneralController::class, "landing"])->name("landing");

Route::get("/home", [GeneralController::class, "home_page"])->name("home");

Route::get("/about", [GeneralController::class, "about"])->name('about');

Route::get("/contacts", [GeneralController::class, "contacts"])->name("contacts");

Route::get("/features", [GeneralController::class, "features"])->name("features");

Route::get("/pricing", [GeneralController::class, "pricing"])->name("pricing");

Route::get("/profile", [UserController::class, "profile"])->name("profile");

Route::get("/register", [AuthController::class, 'register'])->name('register');

Route::post("/register", [AuthController::class, "registerPost"])->name("registerPost");

Route::get("/login", [AuthController::class, 'login'])->name('login');

Route::post("/login", [AuthController::class, "loginPost"])->name("loginPost");

Route::get("/logout", [AuthController::class, "logout"])->name("logout");

Route::get("/show-user/{id}", [UserController::class, "showUser"])->name("userShow");

Route::get("/admin", [AdminController::class, 'admin'])->name("admin");

Route::get("/courses", [CourseController::class, 'courses'])->name("courses");

Route::get("/courses/create", [CourseController::class, "create"])->name('createCourse');

Route::post("/courses/save", [CourseController::class, "save"])->name("saveCourse");

Route::get("/courses/edit/{course}", [CourseController::class, "edit"])->name("editCourse");

Route::put('/courses/edit/{course}', [CourseController::class, 'update'])->name('updateCourse');

Route::get("/courses/{course}", [CourseController::class, 'show'])->name('showCourse');

Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('destroyCourse');

Route::post('courses/{course}/lessons/{lesson}/complete', [LessonController::class, 'complete'])->name('completeLesson');

Route::get("/courses/{course}/modules/create", [ModuleController::class, "create"])->name("createModule");

Route::post('/courses/{course}/modules/save', [ModuleController::class, 'save'])->name('saveModule');

Route::get('courses/{course}/modules/{module}', [ModuleController::class, 'show'])->name('showModule');

Route::fallback(function () { return response()->view('errors.404', [], 404); });