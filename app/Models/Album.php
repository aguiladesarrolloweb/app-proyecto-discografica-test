<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Album extends Model
{
    /** @use HasFactory<\Database\Factories\AlbumFactory> */
    use HasFactory;

    protected $fillable = [
        'album_title',
        'album_description',
        'release_date',
        'album_cover_image',
        'genre',
    ];

    public function packages()
    {
        return $this->morphToMany(Package::class, 'packageable');
    }

    public function tracks() : BelongsToMany
    {
        return $this->belongsToMany(Track::class,"albums_tracks","album_id","track_id");
    }
}
