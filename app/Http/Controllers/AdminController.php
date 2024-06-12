<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\ActivityLog;
use App\Models\Coach;
use App\Models\Athlete;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\Models\Sport;
use App\Models\Notification;
use App\Models\Visit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Artisan;



class AdminController extends Controller
{

    public function index() {
    // Assuming 'roles' is an enum column inside the 'users' table
    $totalUsersCount = User::where('roles', 'user')
                      ->orWhere('roles', 'coach')
                      ->count();

    $coachCount = User::where('roles', 'coach')->count();
    $userCount = User::where('roles', 'user')->count();
    $sportsCount = Sport::count();   

    // Query visits table to get logins per day
    $loginsPerDay = Visit::select(DB::raw('DATE(logout) as date'), DB::raw('COUNT(*) as count'))
                        ->groupBy('date')
                        ->get();

    return view('admin.index', compact('totalUsersCount', 'coachCount', 'userCount', 'sportsCount', 'loginsPerDay'));
}
    public function adminIndex() {
    $user = auth()->user();
    $admins = User::where('id', '!=', $user->id) // Exclude the current user
                  ->where('roles', 'admin')
                  ->latest()
                  ->paginate(10);

    ActivityLog::create([
        'user_id' => $user->id,
        'activity' => 'Visited Add Admin Page.'
    ]);

    return view('admin.add-admin', compact('admins'));
}

    public function coachIndex(){
        $user = auth()->user();
        //dd($user);
        $coaches = Coach::latest()->get();
        $sports = Sport::latest()->get();
         ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Visited Coach List Page.'
        ]);
        return view('admin.coach', compact('user','coaches','sports'));
    }
    
    public function addSport (Request $request) {
        try {
            $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'max:255'],
            'number_of_athlete_allowed' => ['required', 'integer'],
            ]);

            $sport = Sport::create([
            'name' => $request->name,
            'description' => $request->description,
            'number_of_athlete_allowed' => $request->number_of_athlete_allowed
            ]);
            $sport->save();

            ActivityLog::create([
                'user_id' => auth()->user()->id,
                'activity' => 'Added new Sport named, '.$sport->name.'.'
            ]);

        return redirect()->back()->with('success', 'Registering Sport Successfully.');
    } catch (QueryException $e) {
        Log::error('Error occurred in storing: ' . $e->getMessage());

        // Set error message in the session
        return redirect()->back()->with('error', 'An error occurred while saving the sport details.');
    }
}

public function getSportDetails(Request $request)
{
    $sportId = $request->query('sportId');
    $sport = Sport::find($sportId);

    if ($sport) {
        return response()->json($sport);
    } else {
        return response()->json(['error' => 'Sport not found'], 404);
    }
}

public function editSport(Request $request) {
   try { 
    $sportID = $request->input('sportId');
    $sport = Sport::find($sportID);
    if (!$sport) {
        return redirect()->back()->with('error', 'Sport not found.');
    }
    $sport->name = $request->input('name', $sport->name);
    $sport->description = $request->input('description', $sport->description);
    $sport->number_of_athlete_allowed = $request->input('number_of_athlete_allowed', $sport->number_of_athlete_allowed);
    $sport->save();
    return redirect()->back()->with('success', 'Sport updated successfully.');
    } catch (QueryException $e) {
        Log::error('Error:' .$e->getMessage());
        return redirect()->back()->with('error', 'An error occured while editing the sport details.');
    }
}

    public function deleteSport(Request $request, $sportId)
{
    try {
        $user = auth()->user();

        // Get the user ID
        $userID = $user->id;

        $sport = Sport::find($sportId);

        if (!$sport) {
            // Handle the case where the sport is not found
            return response()->json(['error' => 'Sport not found'], 404);
        }

        ActivityLog::create([
            'user_id' => $userID,
            'activity' => 'Deleted Sport named, ' . $sport->name . ' on the list.'
        ]);

        $sport->delete();
    // Return a JSON response with success message
        return response()->json(['success' => 'Deleted a Sport Successfully.']);
    } catch (Exception $e) {
        Log::error('Error occurred in deleting: ' . $e->getMessage());

        // Return a JSON response with error message
        return response()->json(['error' => 'An error occurred while deleting the sport.'], 500);
    }
}

    public function addAdmin(Request $request)
{
    try {
        $admin = auth()->user();
        $adminID = $admin->id;

        $request->validate([
            'lname' => ['required', 'string', 'max:255'],
            'middlename' => ['nullable', 'string', 'max:255'],
            'fname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()]
        ]);

        $adminRole = 'admin';
        $currentYear = now()->year;
        $fullName = $request->fname . ' ' . $request->middlename . ' ' . $request->lname;

        $user = User::create([
            'name' => $fullName,
            'lname' => $request->lname,
            'middlename' => $request->middlename,
            'fname' => $request->fname,
            'email' => $request->email,
            'roles' => $adminRole,
            'password' => Hash::make($request->password),
        ]);

        $user->save();

        // Set success message in the session
        return redirect()->back()->with('success', 'Registering Admin Successfully.');
    } catch (QueryException $e) {
        Log::error('Error occurred in storing: ' . $e->getMessage());

        // Set error message in the session
        return redirect()->back()->with('error', 'An error occurred while saving the admin.');
    }
}


public function addCoach(Request $request)
{
    try {
        $admin = auth()->user();
        // Validate the request data
        $request->validate([
            'lname' => ['required', 'string', 'max:255'],
            'middlename' => ['nullable', 'string', 'max:255'],
            'fname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'sports' => ['required', 'array'], // Validate that sports is an array and is required
        ]);

        // Check if the user already exists based on the provided email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            // Create a new user if the user doesn't exist
            $user = User::create([
                'name' => $request->fname . ' ' . $request->middlename . ' ' . $request->lname,
                'lname' => $request->lname,
                'middlename' => $request->middlename,
                'fname' => $request->fname,
                'email' => $request->email,
                'roles' => 'coach',
                'password' => Hash::make($request->password),
            ]);
        }

        // Get the user ID
        $userId = $user->id;

        foreach ($request->sports as $sportId) {
            // Create a coach entry for each sport
            $currentYear = now()->year;
            $randomChars = strtoupper(Str::random(8));
            $registrationNumber = $currentYear . 'COACH-' . $randomChars;
            
            $coach = Coach::create([
                'user_id' => $userId,
                'coach_number' => $registrationNumber,
                'sport_id' => $sportId,
            ]);
            $sport = Sport::findOrFail($sportId); // Changed to findOrFail() and removed first() since findOrFail() already returns a single model instance.
            Notification::create([
                'sender_id' => $admin->id,
                'receiver_id' => $userId,
                'message' => 'appointed you coach of ' .$sport->name. '. Allowed number of Athletes is '.$sport->number_of_athlete_allowed, // Removed space before .$sport->name. since it's already in the correct position.
                'is_read' => false,
            ]);

            ActivityLog::create([
                'user_id' => auth()->id(),
                'activity' => 'Registered new coach, ' . $user->fname . ' ' . $user->lname . ' for sport ' . $sport->name . '.', // Used sport name instead of ID.
            ]);
        }

        // Set success message in the session
        return redirect()->back()->with('success', 'Registering Coach Successfully.');
    } catch (\PDOException $e) { // Changed to a more specific exception
        Log::error('Error occurred in storing: ' . $e->getMessage());

        // Set error message in the session
        return redirect()->back()->with('error', 'An error occurred while saving the coach.');
    }
}


    public function deleteAdmin($id)
{
    try {
        // Find the coach by ID
        $admin = User::find($id);

        if (!$admin) {
            return redirect()->back()->with('error', 'Admin Details not found.');
        }
        
        // Create an activity log for the deletion
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => "Deleted Admin, {$admin->fname} {$admin->lname}."
        ]);
        $admin->delete();
        return redirect()->back()->with('success', 'Admin Deleted Successfully.');
    } catch (QueryException $e) {
        Log::error('Error occurred in deleting: ' . $e->getMessage());

        // Set error message in the session
        return redirect()->back()->with('error', 'An error occurred while deleting the admin details.');
    }
}


     public function deleteCoach($id)
{
    try {
        // Find the coach by ID
        $coach = Coach::find($id);

        if (!$coach) {
            return redirect()->back()->with('error', 'Coach Details not found.');
        }

        $user = $coach->user;

        // Get the admin ID from the authenticated user
        $adminID = auth()->user()->id;

        // Create an activity log for the deletion
        ActivityLog::create([
            'user_id' => $adminID,
            'activity' => "Deleted Coach, {$user->fname} {$user->lname}."
        ]);

        // Delete the coach and associated user
        $coach->delete();
        return redirect()->back()->with('success', 'Coach Deleted Successfully.');
    } catch (QueryException $e) {
        Log::error('Error occurred in deleting: ' . $e->getMessage());

        // Set error message in the session
        return redirect()->back()->with('error', 'An error occurred while deleting the coach details.');
    }
}
    public function removeCoach(Request $request, $id)
{
    try {
        // Find the coach by ID
        $admin = auth()->user();
        $coach = Coach::find($id);

        if (!$coach) {
            return redirect()->back()->with('error', 'Coach Details not found.');
        }
        // Check if the provided password matches the authenticated user's password
        $passwordMatches = $admin && Hash::check($request->my_password, $admin->password);

        if (!$passwordMatches) {
            return redirect()->back()->with('error', 'Your password is invalid. Please enter your current password to confirm the changes.');
        }
        $user = $coach->user;

        // Get the admin ID from the authenticated user
        $adminID = auth()->user()->id;

        // Create an activity log for the deletion
        ActivityLog::create([
            'user_id' => $adminID,
            'activity' => "Deleted Coach, {$user->fname} {$user->lname}."
        ]);

        // Delete the coach and associated user
        $coach->delete();
        $user->delete();

        return redirect()->back()->with('success', 'Coach Deleted Successfully.');
    } catch (QueryException $e) {
        Log::error('Error occurred in deleting: ' . $e->getMessage());

        // Set error message in the session
        return redirect()->back()->with('error', 'An error occurred while deleting the coach details.');
    }
}

    public function indexAthlete() {
        try {

        $user = auth()->user();
        $userID = $user->id;

        $aths = Athlete::latest()->paginate(10);
        ActivityLog::create([
        'user_id' => $userID,
        'activity' =>'Visited Athlete List Page'
        ]);
        return view('admin.athlete', compact('aths'));
        } catch (QueryException $e) {
            Log::error('Error in fetching the page' .$e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while fetching the page');
        }
    }

    public function getCoaches()
{
    $coaches = Coach::with(['user', 'sport'])->get(); // Eager load the 'user' and 'sport' relationships
    return response()->json($coaches);
}


public function addAthlete(Request $request)
{
    try {
        $request->validate([
            'student_num' => [
                'nullable', // Make the student number field nullable
                'string',
                'regex:/^\d{4}-\d{3}-\d{3}$/',
                'max:255',
            ],
            'lname' => ['required', 'string', 'max:255'],
            'middlename' => ['nullable', 'max:255'],
            'fname' => ['required', 'string', 'max:255'],
            'coach_id' => ['nullable', 'exists:coaches,id'], // Ensure coach_id exists in the coaches table
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

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

        // Check if the user ID already exists in the athletes table
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
  public function updateUserCredentials(Request $request, $id)
{
    try {
        $admin = auth()->user();

        if ($admin->roles !== 'admin') {
            abort(403, 'You do not have permission to update user credentials.');
        }

        try {
            // Retrieve the athlete by ID
            $athlete = Athlete::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Athlete not found.');
        }

        // Get the user_id associated with the athlete
        $userId = $athlete->user_id;

        try {
            // Retrieve the user by user_id
            $user = User::findOrFail($userId);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'User not found.');
        }

        // Check if the provided password matches the authenticated user's password
        $passwordMatches = $admin && Hash::check($request->password_confirmation, $admin->password);

        if (!$passwordMatches) {
            return redirect()->back()->with('error', 'Your password is invalid. Please enter your current password to confirm the changes.');
        }

        // Validate and update the password if provided
        if ($request->filled('password')) {
            $validatedData = $request->validate([
                'password' => 'string|min:8',
            ]);

            // Update the password
            $user->password = Hash::make($validatedData['password']);
        } else {
            return redirect()->back()->with('info', 'No changes made.');
        }

        // Save the updated user
        $user->save();

        ActivityLog::create([
            'user_id' => $admin->id,
            'activity' => 'Changed the password of user "' . $user->name.' ".'
        ]);

        Notification::create([
            'sender_id' => $admin->id,
            'receiver_id' => $user->id,
            'message' => 'edited your credentials.',
            'is_read' => false,
        ]);

        return redirect()->back()->with('success', 'User password updated successfully.');

    } catch (ModelNotFoundException $e) {
        // Log the exception
        Log::error('ModelNotFoundException: ' . $e->getMessage());
        
        return redirect()->back()->with('error', 'Athlete or user not found.');
    } catch (\Exception $e) {
        // Log the exception
        Log::error('Exception: ' . $e->getMessage());

        return redirect()->back()->with('error', 'Error updating user password.');
    }
}
    public function updatecoachCredentials(Request $request, $id)
{
    try {
        $admin = auth()->user();

        if ($admin->roles !== 'admin') {
            abort(403, 'You do not have permission to update user credentials.');
        }
        try {
            // Retrieve the athlete by ID
            $coach = Coach::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Athlete not found.');
        }

        // Get the user_id associated with the athlete
        $userId = $coach->user_id;

        try {
            // Retrieve the user by user_id
            $user = User::findOrFail($userId);
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'User not found.');
        }

        // Check if the provided password matches the authenticated user's password
        $passwordMatches = $admin && Hash::check($request->password_confirmation, $admin->password);

        if (!$passwordMatches) {
            return redirect()->back()->with('error', 'Your password is invalid. Please enter your current password to confirm the changes.');
        }

        // Validate and update the password if provided
        if ($request->filled('password')) {
            $validatedData = $request->validate([
                'password' => 'string|min:8',
            ]);

            // Update the password
            $user->password = Hash::make($validatedData['password']);
        } else {
            return redirect()->back()->with('info', 'No changes made.');
        }

        // Save the updated user
        $user->save();

        ActivityLog::create([
            'user_id' => $admin->id,
            'activity' => 'Changed the password of Coach "' . $user->name.' ".'
        ]);

        Notification::create([
            'sender_id' => $admin->id,
            'receiver_id' => $user->id,
            'message' => 'edited your credentials.',
            'is_read' => false,
        ]);

        return redirect()->back()->with('success', 'User password updated successfully.');

    } catch (ModelNotFoundException $e) {
        // Log the exception
        Log::error('ModelNotFoundException: ' . $e->getMessage());
        
        return redirect()->back()->with('error', 'Athlete or user not found.');
    } catch (\Exception $e) {
        // Log the exception
        Log::error('Exception: ' . $e->getMessage());

        return redirect()->back()->with('error', 'Error updating user password.');
    }
}

    public function exportAdmins(Request $request) {
        $admins = User::where('roles', 'admin')->latest()->get();

        // Generate CSV data
        $csvData = '';
        $csvData .= "ID,FullName,Email Address\n"; // CSV header

        foreach ($admins as $admin) {
            $csvData .= $admin->id . ',' . $admin->fname . ' ' . $admin->lname . ',' . $admin->email . "\n";
        }
        ActivityLog::create([
            'user_id'=> auth()->user()->id,
            'activity' => 'Exported the Admin List Table as CSV Format'
        ]);
        // Return CSV file as response
        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="admins.csv"',
        ]);
    }

    public function exportAthletes(Request $request) {
        $athletes = Athlete::with('user', 'coach', 'coach.user', 'coach.sport')->latest()->get();

        // Generate CSV data
        $csvData = '';
        $csvData .= "Student Number,FullName,Email Address,Coach,Sport\n"; // CSV header

        foreach ($athletes as $athlete) {
            $csvData .= $athlete->user->student_num . ',';
            $csvData .= $athlete->user->fname . ' ' . $athlete->user->lname . ',';
            $csvData .= $athlete->user->email . ',';
            $csvData .= optional($athlete->coach)->user->fname . ' ' . optional($athlete->coach)->user->middlename . ' ' . optional($athlete->coach)->user->lname . ',';
            $csvData .= optional($athlete->coach)->sport->name . "\n";
        }
        ActivityLog::create([
            'user_id'=> auth()->user()->id,
            'activity' => 'Exported the Athlete List Table as CSV Format'
        ]);
        // Return CSV file as response
        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="athletes.csv"',
        ]);
    }

    public function exportCoaches(Request $request) {
        $coaches = Coach::with('user', 'sport')->latest()->get();

        // Generate CSV data
        $csvData = '';
        $csvData .= "Coach Number,Name,Email,Handle Sport\n"; // CSV header

        foreach ($coaches as $coach) {
            $csvData .= $coach->coach_number . ',';
            $csvData .= $coach->user->fname . ' ' . $coach->user->lname . ',';
            $csvData .= $coach->user->email . ',';
            $csvData .= $coach->sport->name . "\n";
        }
         ActivityLog::create([
            'user_id'=> auth()->user()->id,
            'activity' => 'Exported the Coach List Table as CSV Format'
        ]);
        // Return CSV file as response
        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="coaches.csv"',
        ]);
    }
    public function clearCache()
    {
        Artisan::call('cache:clear');
        return redirect()->back()->with('success', 'Cache cleared successfully.');
    }


}
