<?php

use App\Enums\DiscountTypeEnum;
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
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('code'); 
            $table->enum('discount_type', DiscountTypeEnum::options()); 
            $table->decimal('discount_value', 10, 2); 
            $table->date('valid_from'); 
            $table->date('valid_until'); 
            $table->integer('max_uses'); 
            $table->integer('uses')->default(0); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};
