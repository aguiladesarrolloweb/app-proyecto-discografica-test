<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('format_songs_tracks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('format_song_id')->references('id')->on('format_songs'); 
            $table->foreignId('track_id')->references('id')->on('tracks'); 
            $table->tinyInteger('version');
            $table->timestamp("created_at");
            $table->timestamp("deleted_at")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('format_songs_tracks');
    }
};
