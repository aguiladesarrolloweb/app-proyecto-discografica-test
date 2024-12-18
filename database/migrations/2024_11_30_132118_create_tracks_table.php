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
        Schema::create('tracks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');    
            $table->foreignId('package_id')->references('id')->on('packages');    
            $table->string("title");
            $table->string('genre');
            $table->time('duration');
            $table->dateTime('completion_date')->nullable();
            $table->string('original_file');
            $table->string('final_file');
            $table->text('comments')->nullable();
            $table->enum('status', FileStatusEnum::options());
            $table->enum('file_format', FileFormatEnum::options());
            $table->tinyInteger('current_version'); // show the current version of the track
            $table->tinyInteger('limit_version'); // how many versions can change the user
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracks');
    }
};
