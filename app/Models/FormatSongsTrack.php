<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormatSongsTrack extends Model
{
    /** @use HasFactory<\Database\Factories\FormatSongsTrackFactory> */
    use HasFactory;


    public function formatSong()
{
    return $this->belongsTo(FormatSong::class, 'format_song_id');
}
}
