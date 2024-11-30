<?php

use App\Enums\FormStatusEnum;
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
        Schema::create('form_distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('package_id')->references('id')->on('packages');
            $table->string('full_name', 255);
            $table->string('email', 255);
            $table->string('phone', 255);
            $table->string('country', 255);
            $table->text('social_media');
            $table->string('genre', 255);
            $table->enum('form_status', FormStatusEnum::options())->default('pending');
            $table->string('song_file', 255);
            $table->string('cover_file', 255);
            $table->text('comments', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_distributions');
    }
};
