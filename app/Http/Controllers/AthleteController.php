<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Models\Athlete;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use App\Models\Sport;
use App\Models\Coach;
use App\Models\Material;
use App\Models\Checklist;
use App\Models\Rating;

class AthleteController extends Controller
{
  public function coachProfile() {
    

  }
  public function index()
{
    try {
        $user = auth()->user();
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

                    // Pass the data to the view
                    return view('user.index', compact('user','athlete', 'coach', 'sports', 'percentageByRating', 'totalChecklists', 'overallPercentage', 'totalMaterialCount', 'filledChecklistsCount', 'percentageFilledChecklists'));

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

}
