<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePackageRequest;
use App\Http\Requests\UpdatePackageRequest;
use App\Models\Package;
use App\Models\User;
use App\Services\PackageService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class PackageController extends Controller
{
    protected $packageService;

    public function __construct(PackageService $packageService)
    {
        $this->packageService = $packageService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->can('viewAny', Package::class)) {
            $packages = Package::orderBy('created_at', 'desc')->paginate(10);
        } else  {
            $packages = Package::whereHas('users', function ($query) use ($user) {
                $query->where('user_id', $user->id)->orderBy('created_at', 'desc');
            })->paginate(10);
        }

        return  view("packages.index", compact("packages"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::whereNull('deleted_at')
        ->get()
        ->map(function($user) {
            return [
                'value' => $user->id,
                'label' => $user->id . ' (' . $user->email . ')'  // Combinando id y email
            ];
        });

        return  view("packages.create", compact("users"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePackageRequest $request)
    {
       /*  try 
        { */
            $this->packageService->createPackage($request->toArray());
            return redirect()->route('packages.index')->banner('Paquete Creado Exitosamente');
       /*  } 
        catch (\Exception $e) 
        {
            return redirect()->route('packages.index')->dangerBanner('Error a la hora de la creación de paquete');
        } */
    }

    /**
     * Display the specified resource.
     */
    public function show(Package $package)
    {
        /* $files = Package::getFiles($package);
 */
        $package_data = Package::getPackage($package->id);

        return view('packages.show', compact('package','package_data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Package $package)
    {
        $users = User::whereNull('deleted_at')
        ->get()
        ->map(function($user) {
            return [
                'value' => $user->id,
                'label' => $user->id . ' (' . $user->email . ')'  // Combinando id y email
            ];
        });

        return view('packages.edit', compact('package','users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePackageRequest $request, Package $package)
    {
        $this->packageService->updatePackage($request->toArray());
            return redirect()->route('packages.show', ['package' => $package->id])->banner('Paquete Editado Exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        try 
        {
            $this->packageService->deletePackage($package);
            return redirect()->route('packages.index')->banner('Paquete Eliminado Exitosamente');
        } 
        catch (\Exception $e) 
        {
            return redirect()->route('packages.index')->dangerBanner('Error a la hora de borrar el paquete');
        }

    }

    public function fileUpload(Package $package)
    {
        return view('packages.file-upload', compact('package'));
    }



    public function trackCreate(Package $package)
    {
        return view('packages.track-create', compact('package'));
    }

    
}
