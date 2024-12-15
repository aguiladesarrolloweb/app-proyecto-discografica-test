<?php
namespace App\Services;

use App\Enums\FileFormatEnum;
use App\Enums\FileStatusEnum;
use App\Models\FormatSong;
use App\Models\Package;
use App\Models\Track;
use App\Traits\ErrorLogTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TrackService
{
    use ErrorLogTrait;

    public function __construct(
        protected FileService $file_service)
    {
    }

    public function createTrack($request)
    {
        /* DB::beginTransaction();
        try { */
            $package = Package::findOrFail($request->input('package_id'));
        $file = $request->file('file');
        
        $tempPath = $file->getPathname();
        $metadata = $this->file_service->getAudioMetadata($tempPath);

        $track_name = Str::slug($request->input('title')).'-'.date("Y_m_d__H_i_s").'.' . $request->file->getClientOriginalExtension();
        $file_format = FileFormatEnum::getEnumFromFileExtension($metadata["format"]);

        // ingresa los datos en tracks
        $track = Track::create([
            'user_id' => $package->users()->first()->id,
            'package_id' => $package->id,
            'title' => preg_replace('/[^A-Za-z0-9áéíóúÁÉÍÓÚñÑ\s]/', '', $request->input('title')),
            'genre' => $request->input('genre'),
            'duration' => $metadata["duration"],
            'original_file' => $track_name,
            'final_file' => $track_name,
            'comments' => $request->input('comments'),
            'status' => FileStatusEnum::ACTIVE,
            'file_format' => $file_format,
            'current_version' => 1,
            'limit_version' => 3,
        ]);
        
        // ingresa datos a packageables
        $package->tracks()->attach($track->id, [
            'packageable_type' => Track::class,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        // si el track pertenece a un album, se inserta a albums_tracks
        // subi el track en la carpeta
        $this->file_service->upload($file,$package->package_path,$track_name);
        // se inserta en el format_songs
        $format_song = FormatSong::create([
            'file_name' => $track_name,
            'file_format' => $file_format,
            'file_path' => rtrim($package->package_path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $track_name,
            'file_size' => $metadata["size"],
            'track_id' => $track->id,
            'file_status' => FileStatusEnum::ACTIVE,
        ]);

        $format_song->formatSongsVersions()->attach($track->id, [
            'version' => 1,
            'created_at' => Carbon::now(),
        ]);
        /* } 
        catch (\Throwable $e) 
        {
            Storage::disk("local")->delete("{$package->package_path}/{$track_name}");
            DB::rollBack();
            ErrorLogTrait::logError('tracklog', "Error al ejecutarse TrackService@createTrack", $e);
        } */
        
    }
}