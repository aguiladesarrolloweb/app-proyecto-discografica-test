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
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique(); // Role name (e.g., Admin, User, Manager)
            $table->string('slug', 100)->unique(); // Slug for the role (e.g., admin, user, manager)
            $table->text('description')->nullable(); // Description of the role
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
