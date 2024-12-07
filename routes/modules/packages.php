<?php

use App\Http\Controllers\PackageController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'packages'], function () {
    Route::get("/",[PackageController::class,"index"])->name("packages.index");
    Route::get("/create",[PackageController::class,"create"])->name("packages.create");
    Route::post("/store",[PackageController::class,"store"])->name("packages.store");
    Route::get('/{package}', [PackageController::class, 'show'])->name('packages.show');
    Route::get('/{package}/edit', [PackageController::class, 'edit'])->name('packages.edit');
    Route::put('/{package}', [PackageController::class, 'update'])->name('packages.update');
    Route::delete('/{package}', [PackageController::class, 'destroy'])->name('packages.destroy');
});