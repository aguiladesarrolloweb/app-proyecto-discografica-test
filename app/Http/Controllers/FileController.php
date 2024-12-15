<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Services\FileService;
use App\Traits\ErrorLogTrait;
use Illuminate\Http\Request;

class FileController extends Controller
{
    use ErrorLogTrait;
    protected $file_service;


    public function __construct(FileService $file_service)
    {
        $this->file_service = $file_service;
    }


    public function create()
    {
        return view("files.create");
    }

    public function upload(Request $request)
    {
        try 
        {
            $package = Package::findOrFail($request->input("package_id"));
        
            $name = "$package->package_path-".date("Y_m_d__H_i_s")."-" . uniqid(). '.' . $request->file->getClientOriginalExtension();
    
            $this->file_service->upload($request->file('file'),$package->package_path,$name);
            return redirect()->route('packages.show',["package" =>$package->id])->banner('Archivo/s Cargados Exitosamente');
        } 
        catch (\Exception $e) 
        {
            ErrorLogTrait::logError('filelog', "Error al ejecutarse FileController@upload", $e);
            return redirect()->route('packages.create')->dangerBanner('Error a la hora de cargar Archivo/s');
        }

    }

    public function download($filePath)
    {
        return $this->file_service->download($filePath);
    }

    public function delete($filePath)
    {
        $this->file_service->delete($filePath);

        return response()->json(['message' => 'File deleted successfully'], 200);
    }

    public function update(Request $request, $oldFilePath)
    {
        $request->validate([
            'file' => 'required|file|max:5120', // 5MB
        ]);

        $path = 'uploads/' . uniqid() . '.' . $request->file->getClientOriginalExtension();

        $newFilePath = $this->file_service->update($request->file('file'), $path, $oldFilePath);

        return response()->json(['path' => $newFilePath], 200);
    }
}
