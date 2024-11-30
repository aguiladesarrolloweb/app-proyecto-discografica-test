<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    /** @use HasFactory<\Database\Factories\PromoFactory> */
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'valid_from',
        'valid_until',
        'max_uses',
        'uses',
    ];

    /**
     * Los atributos que están protegidos contra asignación masiva.
     *
     * @var array
     */
    protected $guarded = [
        'id', 
        'created_at', 
        'updated_at', 
    ];
}
