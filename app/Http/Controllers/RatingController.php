<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Athlete;
use App\Models\ActivityLog;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use App\Models\Rating;
use App\Models\Checklist;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\Notification;

class RatingController extends Controller
{
    //
    

    public function rating(Request $request, $id) {
    try {
        // Validate the request data
        $validatedData = $request->validate([
            'rate' => 'required|integer|between:1,5',
            'checklist_id' => 'required|exists:checklists,id', // Validate the existence of the checklist
        ]);

        // Find the checklist
        $checklist = Checklist::findOrFail($validatedData['checklist_id']);
        $checklistTitle = $checklist->title;

        // Create a new rating instance
        $rating = new Rating();
        $rating->user_id = $id; // Use the provided user ID
        $rating->checklist_id = $checklist->id;
        $rating->rating = $validatedData['rate'];
        $rating->save();

        // Create notification
        Notification::create([
            'sender_id' => auth()->user()->id,
            'receiver_id' => $id, // Assuming you want to notify the user who owns the checklist
            'message' => 'Rated your "'.$checklistTitle.'" checklist with "'.$validatedData['rate'].'".',
        ]);

        // Log activity
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Rated "'.$validatedData['rate'].'" the "'.$checklistTitle.'" checklist.',
        ]);

        return redirect()->back()->with('success', 'Rating saved successfully.');
    } catch (\Exception $e) {
        Log::error('Error occurred: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while saving the rating.');
    }
}

public function markAsDone(Request $request, $id) {
    try {
        // Validate the request data
        $validatedData = $request->validate([
            'checklist_id' => 'required|exists:checklists,id', // Validate the existence of the checklist
        ]);

        // Find the checklist
        $checklist = Checklist::find($validatedData['checklist_id']);
        if (!$checklist) {
            return redirect()->back()->with('error', 'Checklist not found.');
        }
        $checklistTitle = $checklist->title;

        // Check if there is an existing entry for the user and checklist
        $existingRating = Rating::where('user_id', $id)
            ->where('checklist_id', $validatedData['checklist_id'])
            ->first();

        // If there is an existing entry
        if ($existingRating) {
            // If the task is not already completed, update it
            if (!$existingRating->is_completed) {
                $existingRating->update(['is_completed' => true]);
                
                // Create notification
                Notification::create([
                    'sender_id' => auth()->user()->id,
                    'receiver_id' => $id, // Assuming you want to notify the user who owns the checklist
                    'message' => 'Marked as done the "'.$checklistTitle.'" checklist.',
                ]);

                // Log activity
                ActivityLog::create([
                    'user_id' => auth()->user()->id,
                    'activity' => 'Marked as done the "'.$checklistTitle.'" checklist.',
                ]);

                return redirect()->back()->with('success', 'Task marked as done successfully.');
            } else {
                // Task is already marked as done
                return redirect()->back()->with('error', 'Task is already marked as done.');
            }
        } else {
            // Insert a new entry
            Rating::create([
                'user_id' => $id,
                'checklist_id' => $validatedData['checklist_id'],
                'is_completed' => true,
            ]);

            // Create notification
            Notification::create([
                'sender_id' => auth()->user()->id,
                'receiver_id' => $id, // Assuming you want to notify the user who owns the checklist
                'message' => 'Marked as done the "'.$checklistTitle.'" checklist.',
            ]);

            // Log activity
            ActivityLog::create([
                'user_id' => auth()->user()->id,
                'activity' => 'Marked as done the "'.$checklistTitle.'" checklist.',
            ]);

            return redirect()->back()->with('success', 'Task marked as done successfully.');
        }
    } catch (\Exception $e) {
        Log::error('Error occurred: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while marking the task as done.');
    }
}


}
