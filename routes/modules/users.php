<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'users'], function () {
    Route::get("/",[UserController::class,"index"])->name("users.index")->can("viewAny", App\Models\User::class);
    Route::get("/create",[UserController::class,"create"])->name("users.create")->can("viewAny", App\Models\User::class);
    Route::post("/store",[UserController::class,"store"])->name("users.store")->can("viewAny", App\Models\User::class);
    Route::get("/{user}/show",[UserController::class,"show"])->name("users.show")->can("viewAny", App\Models\User::class);
    Route::get('/{user}/edit',[UserController::class,"edit"])->name('users.edit')->can("viewAny", App\Models\User::class);
    Route::put('/{user}/update',[UserController::class,"update"])->name('users.update')->can("viewAny", App\Models\User::class);
    Route::delete('/delete/{user}',[UserController::class,"delete"])->name('users.delete')->can("viewAny", App\Models\User::class);
});