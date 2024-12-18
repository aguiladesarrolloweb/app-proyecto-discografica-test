<?php
namespace App\Services;

use getID3;
use Illuminate\Support\Facades\Storage;

class FileService
{
    protected $disk;

    public function __construct($disk = 'public')
    {
        $this->disk = $disk;
    }

    public function upload($file, $path, $name)
    {
        return Storage::disk($this->disk)->putFileAs(
            $path,  // Directorio destino
            $file,  // Archivo subido
            $name             // Nombre del archivo
        );
    }

    public function download($filePath)
    {
        return Storage::disk($this->disk)->download($filePath);
    }

    public function delete($file_name)
    {

        return Storage::disk($this->disk)->delete($file_name);
    }

    public function update($file, $path, $oldFilePath = null)
    {
        if ($oldFilePath) {
            $this->delete($oldFilePath);
        }

        return $this->upload($file, $path);
    }


    public function getAudioMetadata($filePath)
    {
        // Create a new getID3 instance
        $getID3 = new getID3();

        // Analyze the file
        $fileInfo = $getID3->analyze($filePath);

        // Handle possible errors
        if (isset($fileInfo['error'])) {
            return ['error' => $fileInfo['error']];
        }

        // Extract metadata
        $metadata = [
            'duration' => $fileInfo['playtime_string'] ?? null,
            'format' => $fileInfo['fileformat'] ?? null,
            'bitrate' => $fileInfo['bitrate'] ?? null,
            'artist' => $fileInfo['tags']['id3v2']['artist'][0] ?? null,
            'album' => $fileInfo['tags']['id3v2']['album'][0] ?? null,
            'title' => $fileInfo['tags']['id3v2']['title'][0] ?? null,
            'size' => isset($fileInfo['filesize']) ? round($fileInfo['filesize'] / 1024, 2): null,
        ];

        return $metadata;
    }


    public function getFile($file_name)
    {
        // Explode por el guion bajo para aislar la parte inicial del nombre
        $parts = explode('-', $file_name);
        // Reensamblamos las primeras 3 partes para obtener la carpeta
        $folder_name = implode('-', array_slice($parts, 0, 3));

        $path = $folder_name . '/' . $file_name;

        return $path;
    }

    
}