<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
      public function edit(Request $request): View
    {
        $userId = auth()->user()->id;
        $user = User::findOrFail($userId);
        return view('profile.edit', ['user' => $user]);
    }

  public function update(ProfileUpdateRequest $request): RedirectResponse
{
    try {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'lname' => 'string',
            'middlename' => 'string',
            'fname' => 'string',
            'email' => 'email|string',
        ]);

        // Initialize $user outside the if block
        $user = $request->user();
        // Update the user's profile information
        // Update the user's profile information
        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');

            // Validate file type
            $allowedFileTypes = ['jpg', 'jpeg', 'png', 'gif'];
            $extension = $file->getClientOriginalExtension();

            if (!in_array(strtolower($extension), $allowedFileTypes)) {
                return redirect()->back()->with('error', 'Invalid file format. Please upload an image file with extensions: jpg, jpeg, png, gif.');
            }
            // Define $fileType based on logic (e.g., image or video)
            $fileType = 'image';

            $prefix = ($fileType === 'image') ? '2024PROFILE' : 'OTHER';
            $uniqueMediaNumber = $prefix . '-' . uniqid();

            // Use the move method to store the file in the public directory
            $file->move(public_path('profile_pic'), $uniqueMediaNumber);

            // Set the file path for future use if needed
            $filePath = 'profile_pic/' . $uniqueMediaNumber;
            $user->avatar = $filePath;

            // Log the file path for debugging
            Log::info('Profile Picture Path:', ['path' => $filePath]);
        }

        // Update the user's first name, middle name, last name, and name
        $user->fill($validatedData);
        // Generate the name based on the updated first name, middle name, and last name
        $user->name = trim($user->fname . ' ' . $user->middlename . ' ' . $user->lname);
        $user->save();

        return Redirect::route('profile.edit')->with('success', 'Profile Information updated successfully.');
    } catch (\Exception $e) {
        // Log and handle exceptions
    }
}

        /**
         * Delete the user's account.
         */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
    public function updatePassword(Request $request)
    {
        try {
            $request->validate([
                'current_password' => ['required', 'password'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
    
            // Get the authenticated user
            $userid = auth()->user()->id;
            $user = User::findorFail($userid);
    
            // Check if the current password matches the stored password
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->route('profile.edit')->with('error', 'Current password is incorrect.');
            }
    
            // Update the password
            $user->password = Hash::make($request->password);
            $user->save();
    
            return redirect()->route('profile.edit')->with('status', 'password-updated');
        } catch (\Exception $e) {
            // Log the exception for debugging purposes
            Log::error('Password update failed: ' . $e->getMessage());
    
            // You can customize the error message based on the exception type
            return redirect()->route('profile.edit')->with('error', 'Failed to update password. Please try again.');
        }
    }

    
}

