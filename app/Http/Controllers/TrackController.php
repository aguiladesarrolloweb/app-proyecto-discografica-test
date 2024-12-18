<?php

namespace App\Http\Controllers;

use App\Enums\FileFormatEnum;
use App\Enums\FileStatusEnum;
use App\Http\Requests\StoreTrackRequest;
use App\Http\Requests\UpdateTrackRequest;
use App\Models\FormatSong;
use App\Models\Package;
use App\Models\Track;
use App\Services\FileService;
use App\Services\TrackService;
use App\Traits\ErrorLogTrait;
use Carbon\Carbon;
use Illuminate\Support\Str;

class TrackController extends Controller
{
    use ErrorLogTrait;

    public function __construct(
        protected FileService $file_service,
        protected TrackService $track_service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Package $package)
    {
        /* return  view("tracks.create",compact("package")); */
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTrackRequest $request)
    {
        try 
        {
            $this->track_service->createTrack($request);
            return redirect()->route('packages.tracks.create',["package" =>$request->input('package_id')])->banner('Track Cargado Exitosamente');
        } 
        catch (\Throwable $th) 
        {
            ErrorLogTrait::logError("tracklog", "Error al ejecutarse TrackController@store", $th);
            return redirect()->route('packages.tracks.create',["package" =>$request->input('package_id')])->dangerBanner('Error a la hora de cargar Archivo/s');
        }
        
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Track $track)
    {
        $file = Track::getLastFile($track->id);
        return view("tracks.show",compact("track",'file'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Track $track)
    {
        return view("tracks.edit",compact("track"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTrackRequest $request)
    {
        try 
        {
            $this->track_service->updateTrack($request);
            return redirect()->route('tracks.edit',["track" =>$request->input('id')])->banner('Track Modificado Exitosamente');
        } 
        catch (\Throwable $th) 
        {
            return redirect()->route('tracks.edit',["track" =>$request->input('id')])->dangerBanner('Error a la hora de modificar Track');
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Track $track)
    {
        //
    }
}
