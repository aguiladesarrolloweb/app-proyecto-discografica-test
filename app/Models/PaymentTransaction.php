<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentTransactionFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'total_amount',
        'payment_method',
        'payment_status',
        'payment_date',
        'reference_number',
        'currency',
        'confirmation_date',
        'comments',
    ];
}
