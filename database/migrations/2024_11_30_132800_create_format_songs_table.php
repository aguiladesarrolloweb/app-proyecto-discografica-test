<?php

use App\Enums\FileFormatEnum;
use App\Enums\FileStatusEnum;
use App\Enums\StatusEnum;
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
        Schema::create('format_songs', function (Blueprint $table) {
            $table->id();
            $table->string('file_name'); 
            $table->enum('file_format', FileFormatEnum::options()); 
            $table->string('file_path'); 
            $table->bigInteger('file_size'); 
            $table->foreignId('track_id')->references('id')->on('tracks'); 
            $table->enum('file_status', FileStatusEnum::options()); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('format_songs');
    }
};
