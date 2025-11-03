<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GeneralController;

Route::get("/", [GeneralController::class, "landing"])->name("landing");
