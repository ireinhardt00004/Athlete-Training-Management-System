<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use App\Models\ActivityLog;
use App\Models\Material;
use App\Models\Checklist;
use App\Models\ChecklistItem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class ChecklistResponseController extends Controller
{
  public function getFormSubmittor($id) {
    try {
        $user = auth()->user();
        $userID = $user->id;
        $checklist = Checklist::findOrFail($id);
       
        $material = $checklist->material; // Assuming there is a relationship between Checklist and Material
        $checklistItems = ChecklistItem::where('checklist_id', $id)->get();
        $tableName = Str::slug($checklist->title, '_') . '_data';
        
        // Check if the table name is empty
        if (empty($tableName)) {
            return redirect()->back()->with('error', 'Table name is empty.');
        }

        // Check if the table exists
        if (!Schema::hasTable($tableName)) {
            return redirect()->back()->with('error', 'Table not found.');
        }

        // Fetch records from the table
        $formData = DB::table($tableName)->paginate(10); // Assuming 10 records per page

        // Get column names from the table
        $columnNames = Schema::getColumnListing($tableName);

        ActivityLog::create([
            'user_id'=> $userID,
            'activity'=> 'Visited the ' . $checklist->title . ' form.'
        ]);

        // Pass the necessary data to the view for rendering
        return view('coach.checked-user', compact('checklist', 'material', 'formData', 'columnNames'));
    } catch (\Exception $e) {
        Log::error('An error occurred while fetching this checklist items: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while fetching this checklist form. Please try again.');
    }
}

 public function processedData($id) {
    try {
        $user = auth()->user();
        $userID = $user->id;
        $checklist = Checklist::findOrFail($id);
       
        $material = $checklist->material; // Assuming there is a relationship between Checklist and Material
        $checklistItems = ChecklistItem::where('checklist_id', $id)->get();
        $tableName = Str::slug($checklist->title, '_') . '_data';
        
        // Check if the table exists
        if (!Schema::hasTable($tableName)) {
            return redirect()->back()->with('error', 'Table not found.');
        }

        // Fetch records from the table
        $formData = DB::table($tableName)->get(); // Assuming 10 records per page

        // Get column names from the table
        $columnNames = Schema::getColumnListing($tableName);

        // Prepare data for the chart
        $chartData = [];

        foreach ($formData as $item) {
            $user = User::find($item->user_id);
            $userName = $user ? $user->name : null;

            if ($user) {
                foreach ($columnNames as $columnName) {
                    // Skip if it's a user ID, ID, checklist_id, created_at, or updated_at
                    if ($columnName == 'user_id' || $columnName == 'id' || $columnName == 'checklist_id' || $columnName == 'created_at' || $columnName == 'updated_at') {
                        continue;
                    }

                    $value = $item->{$columnName};

                    // Add a new entry for each user and column combination
                    $chartData[$columnName][] = [
                        'label' => $userName,
                        'x' => $columnName,
                        'y' => $value
                    ];
                }
            }
        }
       // dd($chartData);
        ActivityLog::create([
            'user_id' => $userID,
            'activity' => 'Visited the ' . $checklist->title . ' form.'
        ]);
        
        // Pass the necessary data to the view for rendering
        return view('coach.stats', compact('checklist', 'material', 'chartData'));

    } catch (\Exception $e) {
        Log::error('An error occurred while fetching this checklist items: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while fetching this checklist form. Please try again.');
    }
}


  public function fetchFormforUsers($id){
    try {
        $user = auth()->user();
        $userID = $user->id;
        $checklist = Checklist::findOrFail($id);

        // Check if the table exists for the checklist
        $tableName = Str::slug($checklist->title, '_') . '_data';

        if (!Schema::hasTable($tableName)) {
            return redirect()->back()->with('error', 'The form associated with this checklist does not exist. Please contact the administrator.');
        }

        $material = $checklist->material;
        $checklistItems = ChecklistItem::where('checklist_id', $id)->get();
    
        // Preprocess the checklist items to concatenate duplicates
        $processedItems = [];

        foreach ($checklistItems as $item) {
            $key = $item->field_name . $item->field_type . $item->minimum_threshold . $item->maximum_threshold;

            if (!isset($processedItems[$key])) {
                $processedItems[$key] = $item;
            } else {
                // Concatenate options if they exist and differ
                if ($item->options && $processedItems[$key]->options && $item->options != $processedItems[$key]->options) {
                    $processedItems[$key]->options .= ', ' . $item->options;
                }
            }
        }

        ActivityLog::create([
            'user_id'=> $userID,
            'activity'=> 'Visited the ' . $checklist->title . ' form.'
        ]);

        // Pass the necessary data to the view for rendering
        return view('checklists.checklist-form', compact('checklist', 'material', 'processedItems'));
    } catch (\Exception $e) {
        Log::error('An error occurred while fetching this checklist items: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while fetching this checklist form. Please try again.');
    }
}

    public function submitForm(Request $request, $id) {
        try {
            // Find the checklist and authenticated user
            $checklist = Checklist::findOrFail($id);
            $user = auth()->user();

            // Retrieve user ID
            $userID = $user->id;

            // Generate table name
            $tableName = Str::slug($checklist->title, '_') . '_data';

            // Check if the table exists
            if (!Schema::hasTable($tableName)) {
                return redirect()->back()->with('error', 'Table not found.');
            }

            // Handle form submission
            $dataToInsert = [];
            $specificFolder = $tableName . '_folder';
            foreach ($checklist->items as $item) {
                $fieldName = str_replace(' ', '_', $item->field_name);

                // Handle different field types
                if ($item->field_type === 'file') {
                    // Handle file upload
                    if ($request->hasFile($fieldName)) {
                        $file = $request->file($fieldName);
                        $fileName = $file->getClientOriginalName();
                        // Store file in the public directory
                        $file->move(public_path($specificFolder), $fileName);
                        // Save file path to array to be inserted into the database
                        $dataToInsert[$fieldName] = $specificFolder . '/' . $fileName;
                    }
                } elseif ($item->field_type === 'checkbox' || $item->field_type === 'radio') {
                    // Handle checkbox and radio arrays
                    $checkboxValues = $request->has($fieldName) ? $request->input($fieldName) : [];
                    $dataToInsert[$fieldName] = json_encode($checkboxValues);
                } else {
                    // Save other field types to array to be inserted into the database
                    $fieldValue = $request->input($fieldName);
                    $dataToInsert[$fieldName] = $fieldValue;
                }
            }

            // Add user_id and checklist_id to the data
            $dataToInsert['user_id'] = $userID;
            $dataToInsert['checklist_id'] = $checklist->id;

            // Add timestamps
            $now = now();
            $dataToInsert['created_at'] = $now;
            $dataToInsert['updated_at'] = $now;

            // Insert data into the table
            DB::table($tableName)->insert([$dataToInsert]);

            ActivityLog::create([
                'user_id' => $userID,
                'activity'=> 'Submitted Form.'
            ]);

            // Optionally, you can redirect back with a success message
            return redirect()->route('material.page', ['id' => $checklist->material_id])->with('success', 'Form submitted successfully.');
        } catch (QueryException $e) {
            Log::error('Error while submitting: ' .$e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while processing the submission of form. Please try again later.');
        }
    }

}
