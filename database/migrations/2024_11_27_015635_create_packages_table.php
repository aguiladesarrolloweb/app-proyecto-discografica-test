<?php

use App\Enums\FormatEnum;
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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string("package_name");
            $table->enum('format', FormatEnum::options());
            $table->integer('songs_limit');
            $table->decimal('price', 10, 2);
            $table->integer('points')->default(0);
            $table->string('package_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
