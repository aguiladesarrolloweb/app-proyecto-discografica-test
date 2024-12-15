<?php

use App\Http\Controllers\TrackController;
use Illuminate\Support\Facades\Route;

Route::controller(TrackController::class)->prefix('tracks')->group( function () {
    Route::get("/create","create")->name("tracks.create");
    Route::post("/store","store")->name("tracks.store");
    Route::get('/download/{filePath}, download')->name('tracks.download');
    Route::get('/{package}/edit','edit')->name('tracks.edit');
    Route::put('/update/{oldFilePath}','update')->name('tracks.update');
    Route::delete('/delete/{filePath}','delete')->name('tracks.delete');
});