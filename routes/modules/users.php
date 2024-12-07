<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'users'], function () {
    Route::get("/",[UserController::class,"index"])->name("users.index");
    Route::get("/create",[UserController::class,"create"])->name("users.create");
});