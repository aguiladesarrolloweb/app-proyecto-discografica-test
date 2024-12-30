<?php
namespace App\Services;

use App\Models\Package;
use App\Models\Album;
use App\Models\Packageable;
use App\Models\PackageType;
use App\Traits\ErrorLogTrait;
use Carbon\Carbon;
use Database\Seeders\PackagesTypeSeeder;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PackageService
{
    use ErrorLogTrait;

    public function createPackage(array $data)
    {
        $package_chosen = PackageType::find($data['package_id']);
        $user = Auth::user();
        $now = new DateTime();
        
        $package_name_slug = Str::slug("$package_chosen->id-$package_chosen->package_name-$package_chosen->format");
       
        try 
        {
            DB::beginTransaction();
            $package = Package::create([
                'package_name' => $package_name_slug, //pack-idtypepacke-format
                'format' => $package_chosen->format,
                'songs_limit' => $package_chosen->songs_limit,
                'price' => $package_chosen->price,
                'points' => $package_chosen->points,
                'package_path' => $this->createPackageFolder($user['id'],$package_name_slug),
            ]);

            

            $package->users()->attach($user['id'], [
                'points_earned' => 0, 
                'purchase_date' => $now->format('Y-m-d H:i:s.u'), 
            ]);


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

    function createPackageFolder($user_id, $package_name)
    {
        // Sanitizar el nombre del paquete
        $sanitized_package_name = Str::slug($package_name);

        // Obtener el timestamp actual
        $timestamp = Carbon::now()->timestamp;

        // Construir la ruta de la carpeta
        $folder_path = "{$user_id}-{$sanitized_package_name}-{$timestamp}";

        // Crear la carpeta
        Storage::disk('public')->makeDirectory($folder_path);

        return $folder_path;
    }

    public function deletePackage (Package $package)
    {

        
        DB::beginTransaction();
        
        try 
        {
                
            foreach ($package->tracks as $track) 
            {
                $track->formatSongsVersions()->detach();
                $track->formatSongs()->delete();
            }   
            
            Packageable::where("package_id",$package->id)->delete();
            

            


            // Eliminar relaciones "HasMany"
            $package->formDistributions()->delete();
            $package->paymentTransactions()->delete();

            // Detach de la relación "BelongsToMany"
            $package->users()->detach();


            Storage::disk('public')->deleteDirectory($package->package_path);

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
