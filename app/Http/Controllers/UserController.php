<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Models\Athlete;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use App\Models\Coach;
use App\Models\Sport; 
use App\Models\User;
use App\Models\Checklist;
use App\Models\Material;
use App\Models\Rating;
class UserController extends Controller
{
    
    public function fetchSport($sport_id)
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

        // Get materials associated with the specified sport along with their material_files
        $materials = Material::with('files')->where('sport_id', $sport_id)->latest()->get();

        ActivityLog::create([
            'user_id' => $userID,
            'activity' => 'Visited '.$sportName.' page.'
        ]);
        return view('classes.dashboard', compact('sport', 'coaches', 'materials'));
    } catch (QueryException $e) {
        Log::error('Error occurred with: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while fetching the page.');
    }
}
    public function userProfile($id)
{
    try {
        $user = User::find($id);
        $userID = $user->id;

        // Fetch athlete based on user ID
        $athlete = Athlete::where('user_id', $userID)->first();

        // If athlete found, get coach and sport
        if ($athlete) {
            $coach = Coach::find($athlete->coach_id);
            if ($coach) {
                $sportID = $coach->sport_id;
                $sports = Sport::find($sportID); // Fetch sport object
                if ($sports) {
                    // Fetch materials associated with the coach and sport
                    $materials = Material::where('user_id', $coach->user_id)
                                         ->where('sport_id', $sportID)
                                         ->with('checklists')
                                         ->get();
                    $totalMaterialCount = $materials->count();
                    // Initialize arrays to store counts for each rating level
                    $ratingsCounts = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];
                    $totalChecklists = 0;
                    $filledChecklistsCount = Rating::where('user_id', $userID)->count(); // Moved this line

                    // Loop through each material to fetch ratings for associated checklists
                    foreach ($materials as $material) {
                        foreach ($material->checklists as $checklist) {
                            $totalChecklists++;
                            // Fetch ratings associated with the checklist and user ID
                            $rating = Rating::where('checklist_id', $checklist->id)
                                             ->where('user_id', $userID)
                                             ->first();
                            if ($rating) {
                                $ratingValue = $rating->rating;
                                // Increment the count for the corresponding rating level
                                if ($ratingValue >= 1 && $ratingValue <= 5) {
                                    $ratingsCounts[$ratingValue]++;
                                }
                            }
                        }
                    }

                    // Calculate percentages for each rating level
                    $percentageByRating = [];
                    foreach ($ratingsCounts as $rating => $count) {
                        $percentageByRating[$rating] = $totalChecklists > 0 ? ($count / $totalChecklists) * 100 : 0;
                    }

                    // Calculate overall percentage
                    $overallPercentage = $totalChecklists > 0 ? ($filledChecklistsCount / $totalChecklists) * 100 : 0;


                    // Calculate the percentage of filled checklists against the total number of checklists available
                    $percentageFilledChecklists = $totalChecklists > 0 ? ($filledChecklistsCount / $totalChecklists) * 100 : 0;
                    ActivityLog::create([
                        'user_id' =>$userID,
                        'activity'=> 'Visited My Profile.'
                    ]);
                    // Pass the data to the view
                    return view('userprofile', compact('user','athlete', 'coach', 'sports', 'percentageByRating', 'totalChecklists', 'overallPercentage', 'totalMaterialCount', 'filledChecklistsCount', 'percentageFilledChecklists'));

                } else {
                    // Handle case where sport is not found
                    return redirect()->back()->with('error', 'Sport not found.');
                }
            } else {
                // Handle case where coach is not found
                return redirect()->back()->with('error', 'Coach not found.');
            }
        } else {
            // Handle case where athlete is not found
            return redirect()->back()->with('error', 'Athlete not found.');
        }

    } catch (QueryException $e) {
        Log::error('Error occurred: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while fetching the page.');
    }
}

   
  public function storeUserData(Request $request, $id)
{
    try {
        // Validate the request data
        $validatedData = $request->validate([
            'profile_pic' => 'image|mimes:jpg,jpeg,png,gif|max:2048', // Max 2MB
            'height' => 'numeric',
            'weight' => 'numeric',
            'bmi' => 'numeric',
            'ddate' => 'date',
            'gender' => 'string',
            'bloodtype' => 'string|max:2',
        ]);

        // Find the user by ID
        $user = User::findOrFail($id);

        // Handle profile picture upload
        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $fileName = '2024PROFILE-' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('profile_pic'), $fileName);
            $user->avatar = 'profile_pic/' . $fileName;
        }

        // Save other user information
        // Assuming other user fields are present in the request and stored directly in the users table

        // Save the user
        $user->save();
        
        // If the user is an athlete, update athlete information
        $athlete = Athlete::where('user_id', $id)->first(); // Retrieve the athlete record
        
        if ($athlete) {
            $athlete->height = $validatedData['height'];
            $athlete->weight = $validatedData['weight'];
            $athlete->bmi = $validatedData['bmi'];
            $athlete->birthdate = $validatedData['ddate'];
            $athlete->gender = $validatedData['gender'];
            $athlete->blood_type = $validatedData['bloodtype'];
            $athlete->save();
        }

        // Log the file path for debugging
        Log::info('Profile Picture Path:', ['path' => $user->avatar]);
        
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Updated Profile Details.'
        ]);
        return redirect()->back()->with('success', 'User profile updated successfully.');
    } catch (QueryException $e) {
        // Log the error
        Log::error('Error updating user profile: ' . $e->getMessage());
        
        // Redirect back with error message
        return redirect()->back()->with('error', 'An error occurred while updating the user profile.');
    }
}   

    public function fetchUserData(Request $request)
    {
        // Retrieve the birth date from the AJAX request
        $selectedDate = $request->input('date');

        // Fetch users with the provided birth date
        $users = User::whereDate('birthdate', $selectedDate)->get();

        // Return the fetched user data as JSON response
        return response()->json($users);
    }

}


