<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageUser extends Model
{
    /** @use HasFactory<\Database\Factories\PackageUserFactory> */
    use HasFactory;

    protected $fillable = [
        'package_id',
        'user_id',
        'purchase_date',
        'points_earned',
    ];
}
