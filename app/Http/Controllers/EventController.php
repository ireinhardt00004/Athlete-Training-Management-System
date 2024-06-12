<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use App\Models\ActivityLog;
use App\Models\Coach;
use Illuminate\Validation\ValidationException;
use App\Models\Sport;
use App\Models\Event;
use App\Models\User;
use App\Models\Notification;
use App\Models\Athlete;
use App\Models\Material;
use Illuminate\Support\Str;
use App\Notifications\EventNotification;


class EventController extends Controller
{
    //
   public function index($sport_id) {
    try {

        // Retrieve the sport based on the provided ID
        $sport = Sport::find($sport_id);
        $user = auth()->user();
        // Retrieve the IDs of users with the 'admin' role
        $adminIds = User::where('roles', 'admin')->pluck('id');

        // Check if the authenticated user's role is 'user'
        if ($user->roles === 'user') {
            $events = Event::where('sport_id', $sport_id)
                        ->orWhereIn('user_id', $adminIds)
                        ->get();
        } else {
            // Retrieve events based on the sport ID directly, including those created by admin
            $events = Event::where('sport_id', $sport_id)
                        ->orWhereIn('user_id', $adminIds)
                        ->get();
        }


      //  dd($events);
        
        // Debugging: Dump and die to check the user relationship
        foreach ($events as $event) {
            //dd($event->user->name); // Check if user relationship is loaded and name is accessible
        }

        // Format events
        $formattedEvents = $events->map(function ($event) {
            // You can add additional logic here if needed
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start_date,
                'end' => $event->end_date,
                'desc' => $event->description,
                'prior' => $event->priority,
                'author' => $event->user->name ?? 'Unknown', // Access the author's name from the related User model
                'created' => $event->created_at,
            ];
        });
        

        // Pass the formatted events and the sport data to the view
        return view('event-calendar', compact('formattedEvents', 'sport'));
    } catch (QueryException $e) {
        Log::error('Error occurred: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while loading the event calendar.');
    }
}
    //
   public function adminIndex() {
    try {
        
        // Retrieve events 
        $events = Event::all();
        
        // Debugging: Dump and die to check the user relationship
        foreach ($events as $event) {
            //dd($event->user->name); // Check if user relationship is loaded and name is accessible
        }

        // Format events
        $formattedEvents = $events->map(function ($event) {
            // You can add additional logic here if needed
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start_date,
                'end' => $event->end_date,
                'desc' => $event->description,
                'author' => $event->user->name ?? 'Unknown', // Access the author's name from the related User model
                'created' => $event->created_at,
            ];
        });
        

        // Pass the formatted events and the sport data to the view
        return view('admin.event-calendar', compact('formattedEvents'));
    } catch (QueryException $e) {
        Log::error('Error occurred: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while loading the event calendar.');
    }
}

    public function store(Request $request, $sport_id)
{
    try {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|string',
            'start_date' => 'required|date|not_in_past',
            'end_date' => 'required|date|after_or_equal:start_date|not_in_past',
        ], [
            'start_date.not_in_past' => 'The start date must not be in the past.',
            'end_date.not_in_past' => 'The end date must not be in the past.',
        ]);

        // Find the sport based on the provided ID
        $sport = Sport::find($sport_id);

        if (!$sport) {
            return redirect()->back()->with('error', 'Sport not found.');
        }
        $sportID = $sport->id;

        $user = auth()->user();
        $userID = $user->id;

        // Find the coach associated with the sport
        $coach = Coach::where('sport_id', $sportID)->firstOrFail();
        $coachID = $coach->id;

        // Add sport ID to validated data
        $validatedData['user_id'] = $userID;
        $validatedData['coach_id'] = $coachID;
        $validatedData['sport_id'] = $sportID;

        // Create the event
        $event = Event::create($validatedData);

        if ($user->roles === 'coach') {
            // Create a new task using the event data   
        $postContent = "NEW TASK!!!\n";
        $postContent .= "TASK TITLE: " . strtoupper($event->title) . "\n";
        $postContent .= "TASK DESCRIPTION: {$event->description}\n";
        $postContent .= "TASK PRIORITY: {$event->priority}\n";
        $postContent .= "TASK SCHEDULE: " . date('F j, Y g:i A', strtotime($event->start_date)) . " to " . date('F j, Y g:i A', strtotime($event->end_date)) . "\n";

        // Create the post
        Material::create([
            'material_number' => uniqid(),
            'user_id' => $event->coach_id,
            'title' => $event->title,
            'content' => $postContent,
            'sport_id' => $event->sport_id,
            'event_id' => $event->id
        ]);
        
       
        $athletes = Athlete::where('coach_id', $coachID)->get();
        if (!$athletes) {
            return redirect()->back()->with('error','Athletes not found. Contact the Administrator');
        }
        $notifyAthletes = $request->has('notify_athletes');

        // Send notifications and create activity log for each athlete
       foreach ($athletes as $athlete) {
        Notification::create([
            'sender_id' => $userID,
            'receiver_id' => $athlete->user_id,
            'message' => 'posted new task on the calendar named, "' . $event->title . '"  under of ' . $sport->name . '.',
        ]);

        // Optionally, send notifications to athletes
        if ($notifyAthletes) {
            $user = $athlete->user;
            $user->notify(new EventNotification($event->title, $coach->user->fname, $coach->user->lname, $sport->name, $sport->id));

        }
    }
     }       
        // Record the activity in the activity log
        ActivityLog::create([
            'user_id' => $userID,
            'activity' => 'Created a new event: ' . $event->title,
        ]);

        return back()->with('success', 'Event created successfully.');

    } catch (QueryException $e) {
        Log::error('Error occurred: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while creating the event.');
    } catch (ValidationException $e) {
        return redirect()->back()->withErrors($e->errors())->withInput();
    }
}
    public function destroy(Request $request)
{
    try {
        $user = auth()->user();
        $id = $request->input('event_id');
        // Find the event by ID
        $event = Event::find($id);
        
        // Check if the event exists
        if (!$event) {
            return redirect()->back()->with('error', 'Saved Routine Event not found.');
        }

        // Check if the authenticated user is the owner of the event
        if ($event->user_id === auth()->user()->id) {

            // Optionally delete associated materials
            $material = Material::where('event_id', $id)->first();
            if ($material) {
                $material->delete();
            }

            // Delete the event
            $event->delete();
            
            // Log the activity
            ActivityLog::create([
                'user_id' => $user->id,
                'activity' =>'Deleted a saved task on the Calendar.'
            ]); 

            return redirect()->back()->with('success', ' Saved Routine Event deleted successfully.');
        } else {
            // Redirect back with an error message if the user is not the owner
            return redirect()->back()->with('error', 'You are not the author to delete this saved routine event.');
        }
    } catch (QueryException $e) {
        Log::error('Error deleting event: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while deleting a Saved Routine Event.');
    }
}

    public function adminStore(Request $request)
{
    try {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|integer',
            'start_date' => 'required|date|not_in_past',
            'end_date' => 'required|date|after_or_equal:start_date|not_in_past',
        ], [
            'start_date.not_in_past' => 'The start date must not be in the past.',
            'end_date.not_in_past' => 'The end date must not be in the past.',
        ]);

        $user = auth()->user();
        $userID = $user->id;

        // Add sport ID to validated data
        $validatedData['user_id'] = $userID;

        // Create the event
        $event = Event::create($validatedData);

        // Record the activity in the activity log
        ActivityLog::create([
            'user_id' => $userID,
            'activity' => 'Created a new event: ' . $event->title,
        ]);

       // Retrieve user IDs with roles of "coach" and "user"
        $userIDs = User::whereIn('roles', ['coach', 'user'])->pluck('id');

        // Notify each user with the "coach" and "user" roles about the new event
        foreach ($userIDs as $id) {
            Notification::create([
                'sender_id' => $userID,
                'receiver_id' => $id,
                'message' => 'posted new event.',
            ]);
        }

        return back()->with('success', 'Event created successfully.');

    } catch (QueryException $e) {
        Log::error('Error occurred: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while creating the event.');
    } catch (ValidationException $e) {
        return redirect()->back()->withErrors($e->errors())->withInput();
    }
}

    

}
