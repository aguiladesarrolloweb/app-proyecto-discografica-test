<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
        'package_path',
    ];

    protected $guarded = [
        'id', 
        'created_at', 
        'updated_at', 
    ];

    public function albums(): MorphToMany
    {
        return $this->morphedByMany(Album::class, 'packageable');
    }

    public function formDistributions() : HasMany
    {
        return $this->hasMany(FormDistribution::class,"package_id","id");
    }

    public function packageables()
    {
        return $this->morphMany(Packageable::class, 'packageable');
    }

    public function paymentTransactions() : HasMany
    {
        return $this->hasMany(PaymentTransaction::class,"package_id","id");
    }

    public function tracks(): MorphToMany
    {
        return $this->morphedByMany(Track::class, 'packageable');
    }

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class,"packages_users","package_id","user_id");
    }


    public static function getAlbums ($id)
    {
        return DB::select(
            "SELECT a.id,a.album_title,a.album_description,a.release_date,a.album_cover_image,
            a.genre,a.created_at,a.updated_at
            from albums a
            inner join packageables p on a.id= p.packageable_id and p.packageable_type = 'App\Models\Album'
            where p.package_id = $id");
    }



    public static function getFiles(Package $package)
    {
        $folder = $package->package_path;
        $files_final = [];

        // Verificar que la carpeta existe
        if (Storage::disk('public')->exists($folder)) 
        {
            // Listar todos los archivos en la carpeta
            $files = Storage::disk('public')->files($folder);
        
            // Crear URLs para la descarga
            $fileUrls = collect($files)->map(function ($file) {
                
                return [
                    'name' => basename($file),
                    'url' => Storage::disk('public')->url($file),
                ];
            });

            $files_final = $fileUrls;
        }

        return $files_final;
    }


    /**
     * * GET USERS, TRACKS AND/OR ALBUMS FROM A PACKAGE
     */
    public static function getPackage($id)
    {
        $tracks = self::getTracks($id);
        return collect([
            'albums' => self::getAlbums($id),
            'tracks' => $tracks,
            'count_tracks' => count($tracks),
            'users' => self::getUsers($id)
        ]);
    }

    public static function getTracks ($id)
    {
        return DB::select(
            "SELECT t.id, t.title, t.genre, t.duration, t.completion_date, t.original_file,
            t.final_file, t.comments, t.status, t.file_format, t.current_version, t.limit_version,
            t.created_at,t.updated_at 
            from tracks t
            inner join packageables p on t.id= p.packageable_id and p.packageable_type = 'App\\\\Models\\\\Track'
            where p.package_id = $id");
    }

    public static function getUsers ($id)
    {
        return DB::select(
            "SELECT u.id, u.name, u.email 
            from users u
            inner join packages_users pu on u.id= pu.user_id
            where pu.package_id = $id");
    }


}
