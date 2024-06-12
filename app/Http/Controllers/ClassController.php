<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use App\Models\Sport; 
use App\Models\Coach; 
use App\Models\Customize;
use App\Models\ActivityLog;
use App\Models\Material; 
use App\Models\MaterialFile;
use App\Models\CoachCredential;

class ClassController extends Controller
{
    public function coachProfile($coach_id) {
       
        $userID = $coach_id;
        // Fetch coach based on user ID
        $coach = Coach::find($userID)->first();
        if (!$coach) {
            return redirect()->back()->with('error', 'Coach not found.');
        }
        
        $sportID = $coach->sport_id;
        $coachID = $coach->id;
        $coachUserID = $coach->user_id;
        // Fetch all sports associated with the coach's sport ID
        $sports = Sport::whereHas('coaches', function($query) use ($coachUserID) {
            $query->where('user_id', $coachUserID);
        })->get();
        $credentials = CoachCredential::where('coach_id', $coachID)->latest()->get();
        
        return view('coach.coach-credential', compact('coach', 'sports', 'credentials'));
    }
    
public function index($sport_id)
{
    try {
        // Get the specific sport by ID
        $sport = Sport::find($sport_id);
        $user = auth()->user();
        $userID = $user->id;

        // Check if the sport exists
        if (!$sport) {
            // Handle case where sport is not found
            return redirect()->back()->with('error', 'Sport not found.');
        }
        $sportName = $sport->name;
        // Get coaches associated with the specified sport
        $coaches = Coach::whereHas('sport', function ($query) use ($sport_id) {
            $query->where('id', $sport_id);
        })->get();
        $coachIDs = $coaches->pluck('id')->toArray();
        // Get materials associated with the specified sport along with their material_files
        $materials = Material::with('files')->where('sport_id', $sport_id)->latest()->get();

        ActivityLog::create([
            'user_id' => $userID,
            'activity' => 'Visited '.$sportName.' page.'
        ]);
        return view('classes.dashboard', compact('sport', 'coaches', 'materials', 'coachIDs'));
    } catch (QueryException $e) {
        Log::error('Error occurred with: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while fetching the page.');
    }
}

    public function fetchClassPage($id) {
        try {
        // Retrieve the material object based on the provided ID
        $materials = Material::findOrFail($id);
        //dd($materials);
        $user = auth()->user();
        $userID = $user->id;
        $title = $materials->title;
        ActivityLog::create([
            'user_id' => $userID,
            'activity' => 'Visited the '.$title.' page.' 
        ]);
        // Pass the $material object to the view
        return view('classes.class', compact('materials'));
   } catch (QueryException $e) {
        Log::error('Error occurred with: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while fetching the page.');
    }
}
    
public function customCover(Request $request, $sport_id)
{
    try {
        // Get the specific sport by ID
        $sport = Sport::find($sport_id);
        $user = auth()->user();
        $userID = $user->id;

        // Check if the sport exists
        if (!$sport) {
            // Handle case where sport is not found
            return redirect()->back()->with('error', 'Sport not found.');
        }

        // Validate the request data
        $validatedData = $request->validate([
            'file' => [
                'nullable',
                'file',
                'max:2048',
                'mimes:jpg,jpeg,png,gif',
            ],
        ], [
            'file.max' => 'File must not exceed 2 megabytes.',
            'file.mimes' => 'Invalid file format. Please upload an image with extensions: jpg, jpeg, png, gif.',
        ]);

        // Check if there is already an entry for the specified sport_id
        $custom = Customize::where('sport_id', $sport_id)->first();
        
        // If an entry exists, update it; otherwise, create a new entry
        if ($custom) {
            // Update the existing entry
            $custom->user_id = $userID;

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $prefix = 'IMG';
                $uniqueMediaNumber = $prefix . '-' . uniqid();
                $file->move(public_path('custom_photos'), $uniqueMediaNumber);
                $filePath = 'custom_photos/' . $uniqueMediaNumber;
                $custom->photo_path = $filePath;
            }

            // Save the Customize instance to the database
            $custom->save();
        } else {
            // Create a new entry
            $custom = new Customize();
            $custom->user_id = $userID;

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $prefix = 'IMG';
                $uniqueMediaNumber = $prefix . '-' . uniqid();
                $file->move(public_path('custom_photos'), $uniqueMediaNumber);
                $filePath = 'custom_photos/' . $uniqueMediaNumber;
                $custom->photo_path = $filePath;
            }

            $custom->sport_id = $sport_id;
            // Save the Customize instance to the database
            $custom->save();
        }

        ActivityLog::create([
            'user_id' => $userID,
            'activity' => 'Changed the cover photo of ' . $sport->name . '.'
        ]);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Customized saved successfully');
    } catch (QueryException $e) {
        Log::error('Error occurred with: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while fetching the page.');
    }
}


}
