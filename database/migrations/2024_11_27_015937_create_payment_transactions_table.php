<?php

use App\Enums\CurrencyEnum;
use App\Enums\PaymentMethodEnum;
use App\Enums\PaymentStatusEnum;
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
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('package_id')->references('id')->on('packages'); 
            $table->decimal('total_amount', 10, 2); 
            $table->enum('payment_method', PaymentMethodEnum::options()); 
            $table->enum('payment_status', PaymentStatusEnum::options()); 
            $table->timestamp('payment_date'); 
            $table->string('reference_number', 255); 
            $table->enum('currency', CurrencyEnum::options()); 
            $table->timestamp('confirmation_date')->nullable(); 
            $table->text('comments')->nullable(); 
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
