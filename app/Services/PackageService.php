<?php
namespace App\Services;

use App\Models\Package;
use App\Models\Album;
use App\Traits\ErrorLogTrait;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PackageService
{
    use ErrorLogTrait;

    public function createPackage(array $data)
    {
        $user = Auth::user();
        $now = new DateTime();
        
       
        try 
        {
            DB::beginTransaction();
            $package = Package::create([
                'package_name' => $data['package_name'],
                'format' => $data['format'],
                'songs_limit' => $data['songs_limit'],
                'price' => 0,
                'points' => 0,
            ]);

            

            $package->users()->attach($user['id'], [
                'points_earned' => 0, 
                'purchase_date' => $now->format('Y-m-d H:i:s.u'), 
            ]);

            if (isset($data['is_album'])) 
            {
                $album = Album::create([
                    'album_title' => $data['album_title'],
                    'album_description' => $data['album_description'] ?? NULL,
                    'release_date' => $data['release_date'] ,
                    'album_cover_image' => $data['album_cover_image'] ?? NULL,
                    'genre' => $data['genre'],
                ]);

                $package->albums()->attach($album->id, [
                    'packageable_type' => Album::class,
                ]);
            }

            DB::commit();
            return 0;
        } 
        catch (\Throwable $e) 
        {
            DB::rollBack();

            ErrorLogTrait::logError('packagelog', "Error al ejecutarse packageService@createPackage", $e);
            return -1;
        }
    }

    public function deletePackage (Package $package)
    {
        DB::beginTransaction();
        try 
        {
            // Detach de relaciones polimórficas
            $package->albums()->detach();
            $package->tracks()->detach();

            // Eliminar relaciones "HasMany"
            $package->formDistributions()->delete();
            $package->paymentTransactions()->delete();

            // Detach de la relación "BelongsToMany"
            $package->users()->detach();

            // Eliminar el paquete
            $package->delete();

            DB::commit();
            return 0;
        } 
        catch (\Throwable $e) 
        {
            DB::rollBack();
            ErrorLogTrait::logError('packagelog', "Error al ejecutarse packageService@destroyPackage", $e);
            return -1;
        }
        
    }
}
