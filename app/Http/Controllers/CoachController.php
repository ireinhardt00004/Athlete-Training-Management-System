<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use App\Models\Coach;
use App\Models\ActivityLog;
use App\Models\Sport;
use App\Models\Material;
use App\Models\Athlete;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Models\CoachCredential;

class CoachController extends Controller
{
   
    public function coachProfile() {
        $userID = auth()->user()->id;
        
        // Fetch coach based on user ID
        $coach = Coach::where('user_id', $userID)->first();
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
    
   public function destroyCred($id)
{
    // Find the credential by its ID
    $credential = CoachCredential::findOrFail($id);

    // Delete the credential
    $credential->delete();

    // Redirect back or wherever appropriate after deletion
    return redirect()->back()->with('success', 'Credential deleted successfully.');
}

   public function updateCredentials(Request $request, $id)
{
    $request->validate([
        'coachID' => 'required|exists:coaches,id',
        'profile_pic' => 'nullable|image',
        'gender' => 'nullable|string',
        'seminar_name.*' => 'nullable|string',
        'seminar_date.*' => 'nullable|date',
        'additional_details.*' => 'nullable|string',
    ]);

    $coachID = $request->input('coachID');
    $coach = Coach::find($coachID);
    $user = User::find($id);

    if ($request->hasFile('profile_pic')) {
        $profilePicPath = $request->file('profile_pic')->store('profile_pics', 'public');
        $user->profile_pic = $profilePicPath;
    }

    if ($request->filled('gender')) {
        $user->gender = $request->gender;
    }

    $user->save();
    $coach->save();

    // Save new credentials
    foreach ($request->seminar_name as $index => $seminarName) {
        CoachCredential::create([
            'coach_id' => $coach->id,
            'seminar_name' => $seminarName,
            'seminar_date' => $request->seminar_date[$index] ?? null,
            'additional_details' => $request->additional_details[$index] ?? null,
        ]);
    }

    return redirect()->back()->with('success', 'New coach credentials added successfully.');
}
public function deleteAthlete($id)
{
    try {
        // Find the athlete by ID
        $athlete = Athlete::find($id);

        if (!$athlete) {
            return redirect()->back()->with('error', 'Athlete Details not found.');
        }

        $user = $athlete->user;

        // Get the admin ID from the authenticated user
        $adminID = auth()->user()->id;

        // Create an activity log for the deletion
        ActivityLog::create([
            'user_id' => $adminID,
            'activity' => "Deleted Athlete, {$user->fname} {$user->lname}."
        ]);

        // Delete the athlete and associated user
        $athlete->delete();
        $user->delete();

        return redirect()->back()->with('success', 'Athlete Deleted Successfully.');
    } catch (QueryException $e) {
        Log::error('Error occurred in deleting: ' . $e->getMessage());

        // Set error message in the session
        return redirect()->back()->with('error', 'An error occurred while deleting the athlete details.');
    }
}

    public function index()
{
    try {
        // Get the authenticated user
        $user = auth()->user();
        
        // Check if the user is authenticated
        if (!$user) {
            // Redirect if user is not authenticated
            return redirect()->route('login')->with('error', 'Please login to access this page.');
        }
        
        // Get the user ID
        $userID = $user->id;
        
        // Fetch all coach entries associated with the user ID
       $coaches = Coach::where('user_id', $userID)->get();

    // Assuming there could be multiple coaches for the user, loop through each coach
    $totalAthleteCount = 0;
    foreach ($coaches as $coach) {
        // Get the coach's ID
        $coachID = $coach->id;

        // Count the total number of athletes associated with each coach
        $athleteCount = Athlete::where('coach_id', $coachID)->count();

        // Add the athlete count for the current coach to the total count
        $totalAthleteCount += $athleteCount;
    }

    // Extract unique sport IDs from coach entries
    $uniqueSportIds = $coaches->pluck('sport_id')->unique()->toArray();

    // Count the number of unique sports handled by coaches
    $totalSportsCount = count($uniqueSportIds);

    // Count the total number of materials associated with the coach
    $totalMaterialsCount = Material::where('user_id', $userID)->count();
        // Initialize an array to store athlete counts per sport
        $athletePerSportCounts = [];
        
        // Initialize an array to store material counts per sport
        $materialPerSportCounts = [];

        // Loop through each unique sport ID
        foreach ($uniqueSportIds as $sportId) {
            // Count the number of athletes for the current coach and sport
            $athleteCount = Athlete::whereIn('coach_id', function($query) use ($userID, $sportId) {
                $query->select('id')
                      ->from('coaches')
                      ->where('user_id', $userID)
                      ->where('sport_id', $sportId);
            })->count();

            // Count the number of materials for the current coach and sport
            $materialCount = Material::where('user_id', $userID)
                                     ->where('sport_id', $sportId)
                                     ->count();

            // Store the athlete count for the current sport
            $athletePerSportCounts[$sportId] = $athleteCount;

            // Store the material count for the current sport
            $materialPerSportCounts[$sportId] = $materialCount;
        }

        // Fetch sports using the unique sport IDs
        $sports = Sport::whereIn('id', $uniqueSportIds)->get();
        ActivityLog::create([
            'user_id' => $userID,
            'activity' => 'Visited Coach Dashboard.'
        ]);
        // Return the coach index view with sports data, total counts, and athlete counts per sport
        return view('coach.index', compact('sports', 'totalSportsCount', 'totalMaterialsCount', 'totalAthleteCount', 'athletePerSportCounts', 'materialPerSportCounts'));
    } catch (QueryException $e) {
        // Log any errors that occur
        Log::error('Error occurred with the page: ' . $e->getMessage());
        
        // Redirect back with an error message
        return redirect()->back()->with('error', 'An error occurred while fetching the page.');
    }
}

    public function athleteList($id)
{
    try {
        // Retrieve the coach for the specified sport ID
        $coach = Coach::where('sport_id', $id)->first();
        $sport = Sport::find($id);
        $user = auth()->user();
        $userID = $user->id;
        $sportName = $sport->name;
        // Check if coach exists
        if ($coach) {
            // Retrieve athletes associated with the coach
            $athletes = Athlete::where('coach_id', $coach->id)->get();

        ActivityLog::create([
            'user_id' => $userID,
            'activity' => 'Visited List of Athletes under of '.$sportName.' .'
        ]);  
            // Pass athletes data to the view
            return view('coach.athlete-list', compact('athletes','sport', 'coach'));
        } else {
            // Handle case where coach with the specified sport ID doesn't exist
            return redirect()->back()->with('error', 'Coach not found for the specified sport.');
        }
    } catch (QueryException $e) {
        // Log any errors that occur
        Log::error('Error occurred with the page: ' . $e->getMessage());

        // Redirect back with an error message
        return redirect()->back()->with('error', 'An error occurred while fetching the page.');
    }
}
public function addAthlete(Request $request)
{
    try {
        $request->validate([
            'student_num' => [
                'nullable',
                'string',
                'regex:/^\d{4}-\d{3}-\d{3}$/',
                'max:255',
            ],
            'lname' => ['required', 'string', 'max:255'],
            'middlename' => ['nullable', 'max:255'],
            'fname' => ['required', 'string', 'max:255'],
            'coach_id' => ['nullable', 'exists:coaches,id'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'confirmed'],
        ]);

        // Validate the coach_id and get the associated sport_id
        $sportId = null;
        if ($request->coach_id) {
            $coach = Coach::find($request->coach_id);
            if ($coach) {
                $sportId = $coach->sport_id;
            }
        }

        // Check if sport_id is valid
        if (!$sportId) {
            return redirect()->back()->with('error', 'Invalid coach ID or associated sport.');
        }

        // Get the number of athletes allowed for this sport
        $sport = Sport::find($sportId);
        if (!$sport) {
            return redirect()->back()->with('error', 'Sport not found.');
        }

        // Check the number of athletes already registered for this sport/coach
        $athleteCount = Athlete::where('coach_id', $request->coach_id)->count();

        if ($athleteCount >= $sport->number_of_athlete_allowed) {
            return redirect()->back()->with('error', 'The maximum number of athletes (' . $sport->number_of_athlete_allowed . ') for this sport/coach has been reached.');
        }

        // Check if the user already exists based on either email or student number
        $user = User::where('student_num', $request->student_num)
                    ->orWhere('email', $request->email)
                    ->first();

        if (!$user) {
            // Create a new user if the user doesn't exist
            $user = User::create([
                'student_num' => $request->student_num,
                'name' => $request->fname . ' ' . $request->middlename . ' ' . $request->lname,
                'lname' => $request->lname,
                'middlename' => $request->middlename,
                'fname' => $request->fname,
                'email' => $request->email,
                'roles' => 'user',
                'password' => Hash::make($request->password),
            ]);
        }

        // Get the user ID
        $userId = $user->id;

        // Check if the athlete already exists for this user
        $existingAthlete = Athlete::where('user_id', $userId)->first();

        if (!$existingAthlete) {
            // Create the athlete entry if it doesn't already exist
            Athlete::create([
                'user_id' => $userId,
                'coach_id' => $request->coach_id,
            ]);

            // Log the activity
            ActivityLog::create([
                'user_id' => auth()->id(),
                'activity' => "Registered new athlete, {$user->fname} {$user->lname}.",
            ]);

            // Set success message in the session
            return redirect()->back()->with('success', 'Registering Athlete Successfully.');
        } else {
            // Set error message in the session if athlete already exists
            return redirect()->back()->with('error', 'The athlete already exists.');
        }
    } catch (QueryException $e) {
        Log::error('Error occurred in storing: ' . $e->getMessage());

        // Set error message in the session
        return redirect()->back()->with('error', 'An error occurred while saving the athlete details.');
    }
}


}