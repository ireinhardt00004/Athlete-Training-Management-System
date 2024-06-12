<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\MaterialFile;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\ActivityLog;
use App\Models\Coach;
use App\Notifications\NewTaskNotification;
use App\Models\Athlete;
use App\Models\Notification;
use App\Models\Sport;
use Illuminate\Support\Facades\Schema;
use App\Models\Event;


class MaterialController extends Controller
{
    public function index()
    {
        // Retrieve all materials
        $materials = Material::with('files')->get();
        
        // Return view with materials data
        return view('materials.index', compact('materials'));
    }

    public function store(Request $request)
    {
    try {
        $user = auth()->user();
        $userID = $user->id;

        // Validate the request data
        $request->validate([
            'title' => 'required|string',
            'content' => 'nullable',
            'files.*' => 'nullable|file|max:10240',
            'sport_id' => 'required|exists:sports,id' // Use exists rule to validate sport_id
        ]);

        // Create material
        $material = Material::create([
            'material_number' => uniqid(), // Generate a unique material number
            'title' => $request->title,
            'content' => $request->content,
            'sport_id' => $request->sport_id,
            'user_id' => $userID,
        ]);
        // Assigning $materialTitle
        $materialTitle = $material->title;

        // Check if files are uploaded
        if ($request->hasFile('files')) {
            // Store files associated with the material
            foreach ($request->file('files') as $file) {
                $extension = $file->getClientOriginalExtension();
                $materialNumber = $material->material_number;
                
                // Generate a unique file name (e.g., using a timestamp)
                $timestamp = time(); // Get current timestamp
                $fileName = $materialNumber . '_' . $timestamp . '.' . $extension;

                // Move file to the public/materials_files directory
                $file->move(public_path('materials_files'), $fileName);

                // Save file path in the database
                $filePath = 'materials_files/' . $fileName;
                $material->files()->create(['path' => $filePath]);
            }
        }
       
        $sport = Sport::find($request->sport_id);
        if (!$sport) {
            return redirect()->back()->with('error','Sport not found. Contact the Administrator');
        }
        $sportName= $sport->name;

        $coach = Coach::where('sport_id', $sport->id)->firstOrFail();
         if (!$coach) {
            return redirect()->back()->with('error','Coach not found. Contact the Administrator');
        }
        $coachID = $coach->id; 
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
            'message' => 'created new task, "' . $materialTitle . '"  under of ' . $sportName . '.',
        ]);

        // Optionally, send notifications to athletes
        if ($notifyAthletes) {
            $user = $athlete->user;
            $user->notify(new NewTaskNotification($material->title, $coach->user->fname, $coach->user->lname, $material->sport->name, $material->sport_id));

        }
    }
        ActivityLog::create([
            'user_id' => $userID,
            'activity' => 'Posted new task "'.$request->title.'" .'
        ]);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Task posted successfully.');
    } catch (\Exception $e) {
        Log::error('An error occurred while saving the task: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while saving the task. Please try again.');
    }
}
    public function update(Request $request)
{
    try {
        // Validate the request data
        $request->validate([
            'material_id' => 'required|exists:materials,id',
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
        ]);
        $user = auth()->user();     
        // Get the user ID
        $userID = $user->id;
        // Fetch the material
        $material = Material::findOrFail($request->material_id);

        // Check if title or content has input
        if ($request->has('title') && $request->title !== $material->title) {
            $material->title = $request->title;
        }

        if ($request->has('content') && $request->content !== $material->content) {
            $material->content = $request->content;
        }

        // Save the material if any changes are made
        if ($material->isDirty()) {
            $material->save();
        }
        ActivityLog::create([
            'user_id' => $userID,
            'activity' => 'Updated material, ' .$request->title.'.'
        ]);
        return redirect()->back()->with('success', 'Material updated successfully.');
    } catch (\Exception $e) {
        Log::error('An error occurred while updating materials: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while updating the materials. Please try again.');
    }
}


    public function edit($id)
    {
        try {
            // Fetch the material by its ID
            $material = Material::findOrFail($id);

            // Return the material details as JSON response
            return response()->json([
                'material' => $material,
            ]);
        } catch (\Exception $e) {
            // Handle exceptions (e.g., material not found)
            return response()->json([
                'error' => 'Error fetching material details: ' . $e->getMessage(),
            ], 500); // Return status code 500 for internal server error
        }
    }
    
    public function deleteMaterial(Request $request) {
    try {
        // Validate the request data
        $request->validate([
            'material_id' => 'required|exists:materials,id' 
        ]);
        
        // Get the authenticated user
        $user = auth()->user();     
        // Get the user ID
        $userID = $user->id;
        // Get the material ID from the request
        $materialID = $request->material_id;
        
        // Find the material by ID
        $material = Material::find($materialID);
        
        // Check if the material exists
        if (!$material) {
            return redirect()->back()->with('error', 'Material not found.');
        }
        
        // Get the associated checklists
        $checklists = $material->checklists; 
        
        // Loop through each checklist
        foreach ($checklists as $checklist) {
            // Get the checklist title
            $checklistTitle = $checklist->title;
            
            // Get the table name for the checklist data
            $tableName = Str::slug($checklistTitle, '_') . '_data';
            
            // Drop the table if it exists
            if (Schema::hasTable($tableName)) {
                Schema::dropIfExists($tableName);
            }
            
            // Now delete the checklist
            $checklist->delete();
        }
        $event = Event::find($material->event_id);
        if ($event) {
            $event->delete();
        }
        
        // Create activity log for deleting material
        ActivityLog::create([
            'user_id' => $userID,
            'activity' => 'Deleted a Task, "'.$material->title.'" .'
        ]);
        
        // Delete the material
        $material->delete();

        return redirect()->back()->with('success', 'Task and associated checklists deleted successfully.');
    } catch (\Exception $e) {
        Log::error('An error occurred while deleting tasks: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while deleting the tasks. Please try again.');
    }
}



}
