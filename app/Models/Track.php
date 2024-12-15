<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Track extends Model
{
    /** @use HasFactory<\Database\Factories\TrackFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'title',
        'genre',
        'duration',
        'completion_date',
        'original_file',
        'final_file',
        'comments',
        'status',
        'file_format',
        'current_version',
        'limit_version',
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

    public function albums() : BelongsToMany
    {
        return $this->belongsToMany(Album::class,"albums_tracks","track_id","album_id");
    }

    public function formatSongs() : HasMany
    {
        return $this->hasMany(FormatSong::class,"track_id","id");
    }

    public function formatSongsVersions() : BelongsToMany
    {
        return $this->belongsToMany(FormatSong::class,"format_songs_tracks","track_id","format_song_id");
    }

    public function packages() : MorphToMany
    {
        return $this->morphToMany(Package::class, 'packageable');
    }
}
