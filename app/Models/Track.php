<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

    public function users() : BelongsTo
    {
        return $this->BelongsTo(User::class,"user_id");
    }


    public static function getLastFile(int $track_id)
    {
        $track = Track::find($track_id);
        $folder = $track->packages[0]->package_path;
        $file_path = $folder.'/'.$track->final_file;

        $file_data = [
            'name' => basename($file_path),
            'url' => Storage::disk('public')->url($file_path),
        ];

        return $file_data;
    }


    public static function getLastFormatSong(int $track_id)
    {
        $last_format_song = FormatSongsTrack::where('track_id', $track_id)
            ->where('version', function($query) use ($track_id) {
                $query->selectRaw('MAX(version)')
                    ->from('format_songs_tracks as fst1')
                    ->where('fst1.track_id', $track_id);
            })
            ->with('formatSong') // Asegúrate de tener la relación definida en el modelo.
            ->get()
            ->pluck('formatSong')[0];

        return $last_format_song;
    }
}
