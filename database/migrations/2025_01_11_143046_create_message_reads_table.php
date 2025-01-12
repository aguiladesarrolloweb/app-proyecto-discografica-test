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
        Schema::create('messages_reads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')->references('id')->on('messages');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->timestamp('read_at')->useCurrent();
            $table->unique(['message_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages_reads');
    }
};
