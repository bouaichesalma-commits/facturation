<?php

namespace App\Http\Controllers;

use App\Models\Agence;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Requests\AgenceRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
            'agence' => Agence::first()
        ]);
    }


    public function updateagence(AgenceRequest $request): RedirectResponse
    {
        if (auth()->user()->can('update agence')) {
            $request->validated();
            $newUpdate = $request->all();
            $agence = Agence::first();
            $destinationPath = public_path('storage/images');

            // Ensure the directory exists
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $fileFields = ['logo', 'cachet', 'signature'];

            foreach ($fileFields as $field) {
                if ($request->hasFile($field) && $request->file($field)->isValid()) {
                    $file = $request->file($field);

                    // Delete the old file if it exists
                    if (!empty($agence->$field)) {
                        $oldImagePath = public_path($agence->$field);
                        if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }

                    $ex = $file->extension();
                    $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $nm = $filename . '_' . time() . '.' . $ex;

                    // Move the file to the public directory
                    $file->move($destinationPath, $nm);

                    // Save correct image path in the database
                    $newUpdate[$field] = 'storage/images/' . $nm;
                }
            }
    
            $agence->update($newUpdate);
    
            return Redirect::route('profile.edit')->with('status', 'agence-updated');
        } else {
            abort(403, 'THIS ACTION IS UNAUTHORIZED.');
        }
    }
    




    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());
    
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
    
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $file = $request->file('photo');
            
            // Delete old photo if exists
            if ($request->user()->photo) {
                $oldPath = public_path($request->user()->photo);
                if (file_exists($oldPath) && is_file($oldPath)) {
                    unlink($oldPath);
                }
            }

            $ex = $file->extension();
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $nm = $filename . '_' . time() . '.' . $ex;
            
            $destinationPath = public_path('storage/image_user');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $file->move($destinationPath, $nm);
            $request->user()->photo = 'storage/image_user/' . $nm;
        } 
    
        $request->user()->save();
    
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
    
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // $request->validateWithBag('userDeletion', [
        //     'password' => ['required', 'current_password'],
        // ]);

        // $user = $request->user();

        // Auth::logout();

        // $user->delete();

        // $request->session()->invalidate();
        // $request->session()->regenerateToken();

        return Redirect::to('/profile');
    }
}
