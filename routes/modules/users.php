<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'users'], function () {
    Route::get("/",[UserController::class,"index"])->name("users.index");
    Route::get("/create",[UserController::class,"create"])->name("users.create");
    Route::post("/store",[UserController::class,"store"])->name("users.store");
    Route::get("/{user}/show",[UserController::class,"show"])->name("users.show");
    Route::get('/{user}/edit',[UserController::class,"edit"])->name('users.edit');
    Route::put('/update',[UserController::class,"update"])->name('users.update');
    Route::delete('/delete/{user}',[UserController::class,"delete"])->name('users.delete');
});