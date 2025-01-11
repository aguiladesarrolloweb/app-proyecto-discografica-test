<?php

namespace App\Http\Controllers;

use App\Enums\CategoryEnum;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use App\Rules\IgnoreCurrentEmail;
use App\Traits\ErrorLogTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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
        $roles = Role::where("name","<>","SuperAdmin")->get();
        return view("users.edit",compact("user","roles"));
    }

    public function update(Request $request, User $user)
{
    // Validaciones de los campos
    $validatedData = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', new IgnoreCurrentEmail($user->id)],
        'password' => ['nullable', 'string', 'min:8'],
        'address' => ['nullable', 'string', 'max:255'],
        'country' => ['nullable', 'string', 'max:255'],
        'post_code' => ['nullable', 'string', 'max:20'],
        'category' => ['nullable', 'in:' . implode(',', CategoryEnum::options())],
        'record_label' => ['nullable', 'string', 'max:255'],
        'is_independent_artist' => ['nullable', 'boolean'],
        'producer_name' => ['nullable', 'string', 'max:255'],
        'manager_name' => ['nullable', 'string', 'max:255'],
        'ar_name' => ['nullable', 'string', 'max:255'],
        'role_id' => ['required', 'exists:roles,id'],
    ]);

    // Si se envía una contraseña, la hasheamos antes de almacenarla
    if ($request->filled('password')) {
        $validatedData['password'] = Hash::make($request->password);
    } else {
        // Si no se cambió la contraseña, eliminamos esta entrada para no sobreescribir el valor existente
        unset($validatedData['password']);
    }

    // Actualizar los datos del usuario
    $user->update($validatedData);

    DB::table('roles_users')
    ->where('user_id', $user->id) // donde user_id sea el ID que estás buscando
    ->update([
        'role_id' => $validatedData['role_id'], // nuevo role_id que quieres actualizar
        'user_id_created_by' => auth()->user()["id"]  // nuevo user_id_created_by
    ]);

    return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function delete(User $user)
    {
        $user->deleted_at = date("Y-m-d H:i:s");
        $user->save();
        return redirect()->route('users.index')->with('success', 'Usuario Borrado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
