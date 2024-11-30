<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormDistribution extends Model
{
    /** @use HasFactory<\Database\Factories\FormDistributionFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'full_name',
        'email',
        'phone',
        'country',
        'social_media',
        'genre',
        'form_status',
        'song_file',
        'cover_file',
        'comments',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class,"package_id","id");
    }

    public function user()
    {
        return $this->belongsTo(User::class,"user_id","id");
    }

}
