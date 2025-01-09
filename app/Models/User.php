<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\ResetPasswordCustom as ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /* use HasApiTokens; */

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'current_team_id',
        'profile_photo_path',
        'address',
        'country',
        'post_code',
        'category',
        'record_label',
        'is_independent_artist',
        'producer_name',
        'manager_name',
        'ar_name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }


    public function formDistributions() : HasMany
    {
        return $this->hasMany(FormDistribution::class,"user_id","id");
    }

    public function packages() : BelongsToMany
    {
        return $this->belongsToMany(Package::class,"packages_users","user_id","package_id")
        ->withPivot('purchase_date', 'points_earned');
    }
    
    public function paymentTransactions() : HasMany
    {
        return $this->hasMany(PaymentTransaction::class,"payment_transactions","user_id","id");
    }

    
    public function roles() : BelongsToMany
    {
        return $this->belongsToMany(Role::class,"roles_users","user_id","role_id");
    }

    public function tracks() : HasMany
    {
        return $this->hasMany(Track::class,"user_id","id");
    }
}
