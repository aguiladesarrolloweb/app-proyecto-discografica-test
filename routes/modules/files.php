<?php

use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

Route::controller(FileController::class)->prefix('files')->group( function () {
    Route::get("/create","create")->name("files.create");
    Route::post("/store","upload")->name("files.upload");
    Route::get('/download/{filePath}, download')->name('files.download');
    Route::get('/{package}/edit','edit')->name('files.edit');
    Route::put('/update/{oldFilePath}','update')->name('files.update');
    Route::delete('/delete/{filePath}','delete')->name('files.delete');
});