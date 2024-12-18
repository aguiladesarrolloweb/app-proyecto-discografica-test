<?php

use App\Http\Controllers\TrackController;
use Illuminate\Support\Facades\Route;

Route::controller(TrackController::class)->prefix('tracks')->group( function () {
    Route::get("/create","create")->name("tracks.create");
    Route::get("/{track}/show","show")->name("tracks.show");
    Route::post("/store","store")->name("tracks.store");
    Route::get('/download/{filePath}, download')->name('tracks.download');
    Route::get('/{track}/edit','edit')->name('tracks.edit');
    Route::put('/update','update')->name('tracks.update');
    Route::delete('/delete/{filePath}','delete')->name('tracks.delete');
});