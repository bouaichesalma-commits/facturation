<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
 
     
    public function index()
    {
        $users = User::all();
        $this->authorize('viewAny', User::class);
        return response()->view('user.index', compact('users')); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() 
    {
        $role = Role::all();
        $this->authorize('create', User::class);
        return response()->view('user.create',compact(('role')));
    }

    /**
     * Store a newly created resource in storage.
     */

     public function store(Request $request)
     {
         $this->authorize('create', User::class);
         $request->validate([
             'nom' => ['required', 'string', 'max:255'],
             'prenom' => ['required', 'string', 'max:255'], 
             'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], 
             'password' => ['required', 'confirmed', Rules\Password::defaults()],
             'role' => ['required'], 
             'image_user' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
         ]);
     
         // Create a new User instance
         $user = new User();
         $user->nom = $request->nom;
         $user->prenom = $request->prenom;
         $user->email = $request->email;
         $user->password = Hash::make($request->password);
     
         // Handle image upload if provided
         if ($request->hasFile('image_user')) {
             $files = $request->file('image_user');
     
             $ex = $files->extension();
             $filenam = $files->getClientOriginalName(); // Use the original name
             $nm = pathinfo($filenam, PATHINFO_FILENAME) . time() . '.' . $ex;
     
             // Define the public path where the image will be saved
             $destinationPath = public_path('storage/image_user');
     
             // Ensure the directory exists
             if (!file_exists($destinationPath)) {
                 mkdir($destinationPath, 0777, true);
             }
     
             // Move the file to the public directory
             $files->move($destinationPath, $nm);
     
             // Save correct image path in the database
             $user->photo = 'storage/image_user/' . $nm;
         }
     
         $user->save(); 
         $user->assignRole($request->role);
     
         return redirect('/users/create')->with('info', 'The user has been added successfully!');
     }
     

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        if (Gate::denies('isUserAdmin', $user)) {
            # code...
        $this->authorize('view', $user);
        $Namerole = $user->getRoleNames()[0];
        $role = Role::findByName($Namerole);
        $NamePermission = $role->permissions->pluck('name');
        return response()->view('user.show', compact('user','Namerole','NamePermission'));
        }else{
            
            return abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        if (Gate::denies('isUserAdmin', $user)) {
        $this->authorize('update', $user);
        $role = Role::all();
        return response()->view('user.edit', compact('user','role'));
        }else{
            
            return abort(404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        if (Gate::denies('isUserAdmin', $user)) {
            $this->authorize('update', $user);
            $request->validate([
                'nom' => ['required', 'string', 'max:255'],
                'prenom' => ['required', 'string', 'max:255'], 
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)], 
                'role' => ['required'], 
                'image_user' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            ]);
    
            $user->nom = $request->nom;
            $user->prenom = $request->prenom;
            $user->email = $request->email;
    
            // Handle image upload if provided
            if ($request->hasFile('image_user')) {
                $files = $request->file('image_user');
    
                // Delete the old image if it exists
                if ($user->photo) {
                    $oldImagePath = public_path($user->photo);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }
    
                $ex = $files->extension();
                $filenam = $files->getClientOriginalName(); // Use the original name
                $nm = pathinfo($filenam, PATHINFO_FILENAME) . time() . '.' . $ex;
    
                // Define the public path where the image will be saved
                $destinationPath = public_path('storage/image_user');
    
                // Ensure the directory exists
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
    
                // Move the file to the public directory
                $files->move($destinationPath, $nm);
    
                // Save correct image path in the database
                $user->photo = 'storage/image_user/' . $nm;
            }
    
            $user->save(); // Use save() instead of update()
            $user->syncRoles([$request->role]);
    
            return redirect('/users/' . $id . '/edit')->with('info', 'The user updated successfully!');
        } else {
            return abort(403);
        }
    }
    
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        if (Gate::denies('isUserAdmin', $user)) {

            $this->authorize('delete', $user);
            $user->syncRoles([]);
            $user->delete();

            return redirect('/users')->with('deleted', 'The user has been deleted ');

          }else{
            
            return abort(403);
        }
    }
}
