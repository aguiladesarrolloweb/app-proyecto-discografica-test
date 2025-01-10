<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use App\Traits\ErrorLogTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use ErrorLogTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->orderBy("created_at","desc")->paginate(10);
        return view("users.index", compact("users"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::where("name","<>","SuperAdmin")->get();
        return view("users.create", compact("roles"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
       /*  DB::beginTransaction();
        try 
        { */
            $user = User::create(array_merge(
                $request->except(['password']),
                ['password' => Hash::make($request->password)]
            ));
    
            $user->roles()->attach($request->role_id);
           /*  DB::commit(); */
            return redirect()->route('users.index')->banner('User Creado Exitosamente'); 
      /*   } 
        catch (\Throwable $th) 
        {
            ErrorLogTrait::logError("userlog","Error a la hora de ejecutrar UserController@store",$th);
            DB::rollBack();
            return redirect()->route('users.index')->banner('User Creado Exitosamente'); 
        } */

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view("users.show", compact("user"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
