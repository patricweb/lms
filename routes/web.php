<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\LessonCommentsController;
use App\Http\Controllers\CourseCommentsController;

Route::get("/", [GeneralController::class, "landing"])->name("landing");
Route::get("/contacts", [GeneralController::class, "contacts"])->name("contacts");
Route::get("/features", [GeneralController::class, "features"])->name("features");
Route::get("/profile", [UserController::class, "profile"])->name("profile");
Route::post("/profile/update", [UserController::class, "update"])->name("profileUpdate");
Route::get("/register", [AuthController::class, 'register'])->name('register');
Route::post("/register", [AuthController::class, "registerPost"])->name("registerPost");
Route::get("/login", [AuthController::class, 'login'])->name('login');
Route::post("/login", [AuthController::class, "loginPost"])->name("loginPost");
Route::get("/logout", [AuthController::class, "logout"])->name("logout");

Route::get("/admin", [AdminController::class, 'admin'])->name("admin");
Route::get("/admin/users", [AdminController::class, 'usersIndex'])->name("usersIndex");
Route::get("/admin/users/{user}", [AdminController::class, 'usersShow'])->name("usersShow");
Route::patch("/admin/users/{user}/role", [AdminController::class, 'usersUpdateRole'])->name("usersUpdateRole");
Route::delete("/admin/users/{user}", [AdminController::class, 'usersDestroy'])->name("usersDestroy");
Route::get("/admin/categories", [AdminController::class, 'categoriesIndex'])->name("categoriesIndex");
Route::get("/admin/categories/create", [AdminController::class, 'categoriesCreate'])->name("categoriesCreate");
Route::post("/admin/categories", [AdminController::class, 'categoriesStore'])->name("categoriesStore");
Route::delete("/admin/categories/{category}", [AdminController::class, 'categoriesDestroy'])->name("categoriesDestroy");

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
Route::get('courses/{course}/modules/{module}/edit', [ModuleController::class, 'edit'])->name('editModule');
Route::put('courses/{course}/modules/{module}', [ModuleController::class, 'update'])->name('updateModule');
Route::delete('courses/{course}/modules/{module}', [ModuleController::class, 'delete'])->name('deleteModule');
Route::get('courses/{course}/modules/{module}/lessons/create', [LessonController::class, 'create'])->name('createLesson');
Route::post('courses/{course}/modules/{module}/lessons', [LessonController::class, 'store'])->name('storeLesson');
Route::get('courses/{course}/modules/{module}/lessons/{lesson}', [LessonController::class, 'show'])->name('showLesson');
Route::get('courses/{course}/modules/{module}/lessons/{lesson}/edit', [LessonController::class, 'edit'])->name('editLesson');
Route::put('courses/{course}/modules/{module}/lessons/{lesson}', [LessonController::class, 'update'])->name('updateLesson');
Route::delete('courses/{course}/modules/{module}/lessons/{lesson}', [LessonController::class, 'destroy'])->name('deleteLesson');
Route::get('courses/{course}/modules/{module}/lessons/{lesson}/comments', [LessonCommentsController::class, 'index'])->name('lessonComments.index');
Route::get('courses/{course}/modules/{module}/lessons/{lesson}/comments/create', [LessonCommentsController::class, 'create'])->name('createLessonComment');
Route::post('courses/{course}/modules/{module}/lessons/{lesson}/comments', [LessonCommentsController::class, 'store'])->name('storeLessonComment');
Route::get('courses/{course}/modules/{module}/lessons/{lesson}/comments/{comment}/reply', [LessonCommentsController::class, 'reply'])->name('replyLessonComment');
Route::delete('courses/{course}/modules/{module}/lessons/{lesson}/comments/{comment}', [LessonCommentsController::class, 'destroy'])->name('deleteLessonComment');
Route::get('courses/{course}/comments', [CourseCommentsController::class, 'index'])->name('courseComments.index');
Route::post('courses/{course}/comments', [CourseCommentsController::class, 'store'])->name('storeCourseComment');
Route::delete('courses/{course}/comments/{comment}', [CourseCommentsController::class, 'destroy'])->name('deleteCourseComment');

Route::fallback(function () { return response()->view('errors.404', [], 404); });