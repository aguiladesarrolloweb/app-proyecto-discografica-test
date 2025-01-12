<?php

use App\Http\Controllers\ConversationController;
use Illuminate\Support\Facades\Route;

//FALTA HACER LAS POLICIES
Route::controller(ConversationController::class)->prefix('conversations')->group(function () {
    Route::get('/', 'index')->name('conversations.index'); 
    Route::get('/create', 'create')->name('conversations.create'); 
    Route::post('/store', 'store')->name('conversations.store'); 
    Route::get('/{conversation}', 'show')->name('conversations.show')->can("view",[App\Models\Conversation::class, "conversation"]); 
    Route::get('/{conversation}/edit', 'edit')->name('conversations.edit')->can("viewAny", App\Models\Conversation::class);
    Route::post('/{conversation}/update', 'update')->name('conversations.update')->can("viewAny", App\Models\Conversation::class);
    Route::post('/{conversation}/send', 'send')->name('conversations.send')->can("send",[App\Models\Conversation::class, "conversation"]);
    Route::delete('/{conversation}/participants/{user}', "removeParticipant")->name('conversations.removeParticipant')->can("viewAny", App\Models\Conversation::class);
    Route::post('/{conversation}/participants', "addParticipant")->name('conversations.addParticipant')->can("viewAny", App\Models\Conversation::class);
});