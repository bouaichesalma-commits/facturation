<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\User;
use Illuminate\Auth\GenericUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $user;

    public function __construct() {

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            Gate::authorize('hasadmin',$this->user);
            return $next($request);
        });
        
    }

    // public function __construct()
    // {
    //    $this->authorizeResource(Role::class, 'roles');
    // }

    public function index()
    {
        
        $roles = Role::all();
        return response()->view('role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        

        $allPermission = Permission::all();
        return response()->view('role.create',compact('allPermission'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        
        $role = new Role();
        $role->fill($request->validated());
        $role->name = $request->input('nameRole');
        $role->save();

        if (is_array($request->input('permissions'))) {
            
            $perm = $role->syncPermissions(array_map('intval',$request->input('permissions')));
            // dd($perm);

        }
            
        return redirect('/role/create')->with('SuccessRole', 'The role added successfully !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::findOrFail($id);
        if ($role->name != "admin") {
            # code...
        $allPermission = Permission::all();
        $roleWithpermission = $role->permissions->pluck('id');
        return response()->view('role.edit', compact('role', 'allPermission','roleWithpermission'));
        }else{
            
            return abort(404);
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, string $id)
    {
        $role = Role::findOrFail($id);
        
        $role->fill($request->validated());
        

        $role->name = $request->input('nameRole');
        $role->save();

        if (is_array($request->input('permissions'))) {
            
            $perm = $role->syncPermissions(array_map('intval',$request->input('permissions')));

        }else{
            $perm = $role->syncPermissions(null);
        }

        $role->update();

        return redirect('/role/' . $id . '/edit')->with('SuccessRoleupdate', 'The role updated successfully !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect('/role');
    }
}
