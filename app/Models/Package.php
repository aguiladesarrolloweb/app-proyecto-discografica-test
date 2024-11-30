<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    /** @use HasFactory<\Database\Factories\PackageFactory> */
    use HasFactory;

    protected $fillable = [
        'package_name',
        'format',
        'songs_limit',
        'price',
        'points',
    ];

    protected $guarded = [
        'id', 
        'created_at', 
        'updated_at', 
    ];

    public function formDistributions() : HasMany
    {
        return $this->hasMany(FormDistribution::class,"package_id","id");
    }

    public function packageables()
    {
        return $this->morphToMany(Packageable::class, 'packageable');
    }

    public function paymentTransactions() : HasMany
    {
        return $this->hasMany(PaymentTransaction::class,"payment_transactions","package_id","id");
    }

    public function tracks() : HasMany
    {
        return $this->hasMany(Track::class,"package_id","id");
    }

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class,"packages_users","package_id","user_id");
    }


}
