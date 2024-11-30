<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FormatSong extends Model
{
    /** @use HasFactory<\Database\Factories\FormatSongFactory> */
    use HasFactory;

    protected $fillable = [
        'file_name',
        'file_format',
        'file_path',
        'file_size',
        'track_id',
        'file_status',
    ];

    public function track() : BelongsTo
    {
        return $this->belongsTo(Track::class,"track_id","id");
    }

    public function formatSongsVersions() : BelongsToMany
    {
        return $this->belongsToMany(FormatSong::class,"format_songs_tracks","format_song_id","track_id");
    }

}
