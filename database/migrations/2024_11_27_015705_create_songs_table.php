<?php

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
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');    
            $table->foreignId('package_id')->references('id')->on('packages');    
            $table->string("title");
            $table->string("file_path");
            $table->enum('status', StatusEnum::options());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};
