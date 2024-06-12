<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use App\Models\Coach; // Add this import for the Coach model
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; 
use Illuminate\Database\QueryException;
use App\Models\ActivityLog;
use App\Models\ChecklistItem;
use App\Models\Notification;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB; 
use App\Notifications\ChecklistNotification;
use Illuminate\Support\Facades\Mail;
use App\Models\Athlete;

class ChecklistController extends Controller
{
    public function index($id)
    {
        $user = auth()->user();
        $userID = $user->id;
        // Find the material with the given $id
        $material = Material::find($id);
        $forms = Checklist::where('material_id',$id)->latest()->paginate(10);
        ActivityLog::create([
            'user_id' => $userID,
            'activity' => 'Visited Checklist Page.'
        ]);
        // Pass the retrieved material to the view
        return view('checklists.index', compact('material','forms'));
    }
 

  public function save(Request $request, $id)
{
    try {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'material_id' => 'required|exists:materials,id',
        ]);

        // Retrieve authenticated user
        $user = auth()->user();
        $userID = $user->id;

        // Retrieve material by ID
        $material = Material::find($validatedData['material_id']);
        if (!$material) {
            return redirect()->back()->with('error', 'Material not found. Contact the Administrator.');
        }

        // Retrieve sport by material
        $sport = $material->sport;
        if (!$sport) {
            return redirect()->back()->with('error', 'Sport not found for the given material. Contact the Administrator.');
        }

        // Find the coach based on the sport
        $coach = Coach::where('sport_id', $sport->id)->first();
        if (!$coach) {
            return redirect()->back()->with('error', 'Coach not found for the given sport. Contact the Administrator.');
        }
        $coachID = $coach->id;

        // Create a new checklist instance
        $checklist = new Checklist;
        $checklist->title = $validatedData['title'];
        $checklist->description = $validatedData['description'];
        $checklist->material_id = $material->id;
        $checklist->coach_id = $coachID;

        // Save the checklist
        $checklist->save();

        // Create activity log for coach
        ActivityLog::create([
            'user_id' => $userID,
            'activity' => 'Created new checklist, "' . $validatedData['title'] . '" on the material ' . $material->title . '.'
        ]);

        // Optionally, you can redirect the user or return a response
        return redirect()->back()->with('success', 'Checklist created successfully');
    } catch (QueryException $e) {
        // Handle the database query exception
        Log::error('Error occurred while storing:'.$e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while storing the form field. Please try again later.');
    }
}


   public function fetchChecklistedit($id) {
        try {
            // Fetch the material by its ID
            $checklist = Checklist::findOrFail($id);

            // Return the material details as JSON response
            return response()->json([
                'checklist' => $checklist,
            ]);
        } catch (\Exception $e) {
            // Handle exceptions (e.g., material not found)
            return response()->json([
                'error' => 'Error fetching material details: ' . $e->getMessage(),
            ], 500); // Return status code 500 for internal server error
        }
    }
   public function update(Request $request)
{
    try {
        // Validate the request data
        $validatedData = $request->validate([
            'checklist_id' => 'required|exists:checklists,id',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Fetch the checklist
        $checklist = Checklist::findOrFail($validatedData['checklist_id']);

        // Check if title has changed
        if (isset($validatedData['title']) && $validatedData['title'] !== $checklist->title) {
            $checklist->title = $validatedData['title'];
        }
        if ($request->has('description') && $request->description !== $checklist->description) {
            $checklist->description = $request->description;
        }

        // Save the checklist if any changes are made
        if ($checklist->isDirty()) {
            $checklist->save();

            // Log the activity
            $user = auth()->user();
            ActivityLog::create([
                'user_id' => $user->id,
                'activity' => 'Updated checklist: ' . $checklist->title,
            ]);
        }

        return redirect()->back()->with('success', 'Checklist updated successfully.');
    } catch (\Exception $e) {
        Log::error('An error occurred while updating this checklist: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while updating this checklist. Please try again.');
    }
}
    public function delete($id) {
        try {
            // Retrieve authenticated user's ID
            $userID = auth()->user()->id;
        
            $checklist = Checklist::findOrFail($id);

           ActivityLog::create([
            'user_id' => $userID,
            'activity' => 'Deleted checklist, '.$checklist->title.' .',
        ]);
          
        $tableName = Str::slug($checklist->title, '_') . '_data';
        $checklist->delete();
             // Drop the table if it exists
            if (Schema::hasTable($tableName)) {
                Schema::dropIfExists($tableName);
            }

           return redirect()->back()->with('success', 'Checklist deleted successfully.');
       } catch (\Exception $e) {
        Log::error('An error occurred while deleting this checklist: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while deleting this checklist. Please try again.');
    }
}
   public function editIndex($id)

{   
    try {
        $user = auth()->user();
        $userID = $user->id;
        $checklist = Checklist::findOrFail($id);
        $material = $checklist->material; // Assuming there is a relationship between Checklist and Material
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
      // Generate table name
    $tableName = Str::slug($checklist->title, '_') . '_data';

    // Check if the table exists
    $tableExists = Schema::hasTable($tableName);
    //Log the activity
        ActivityLog::create([
            'user_id'=> $userID,
            'activity'=> 'Visited the ' . $checklist->title . ' form.'
        ]);
    // Pass the necessary data to the view for rendering
    return view('checklists.edit-form', compact('checklist', 'material', 'processedItems', 'tableExists'));
 } catch (\Exception $e) {
        Log::error('An error occurred while fetching this checklist items: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while fetching this checklist form. Please try again.');
    }
}  

    public function saveChecklistForm( Request $request, $id)
{
    try {
        $user = auth()->user();
        $userID = $user->id;
        // Fetch checklist data
        $checklist = Checklist::findOrFail($id);
        $checklistItems = ChecklistItem::where('checklist_id', $id)->get();
        $checklistTitle = $checklist->title;
        //dd($checklistTitle);
        // Generate table name
        $tableName = Str::slug($checklist->title, '_') . '_data';
        $coachID  = $checklist->coach_id;
        $coach  = Coach::find($coachID);
        if (!$coach) {
            return redirect()->back()->with('error', 'Coach not found. Contact the Administrator');
        }
        // Drop the table if it exists
        if (Schema::hasTable($tableName)) {
            Schema::dropIfExists($tableName);
        }

        // Create the table
        Schema::create($tableName, function (Blueprint $table) use ($checklistItems) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id'); 
            $table->unsignedBigInteger('checklist_id');

            // Add foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('checklist_id')->references('id')->on('checklists')->onDelete('cascade');
            $existingColumns = []; // Array to store existing column names

            foreach ($checklistItems as $item) {
                $fieldName = str_replace(' ', '_', $item->field_name);
                
                // Check if the column name already exists, if not, create the column
                if (!in_array($fieldName, $existingColumns)) {
                    $existingColumns[] = $fieldName; // Add the column name to the existing columns array
                    
                    $fieldType = $item->field_type;

                    if ($fieldType === 'textarea') {
                        $table->text($fieldName)->nullable();
                    } elseif ($fieldType === 'text' || $fieldType === 'range' || $fieldType === 'checkbox' || $fieldType === 'radio' || $fieldType === 'file') {
                        $table->string($fieldName)->nullable();
                    }
                    // Add other field types if needed
                }
            }
        });
        // Retrieve the list of athlete IDs associated with the coach
         // Find the coach ID based on the authenticated user
        $athletes = Athlete::where('coach_id', $coachID)->get();
              // Retrieve the material object
        $material = Material::findOrFail($checklist->material_id);
        // Now you can access its properties
        $materialTitle = $material->title;
        $sportName = $coach->sport->name;
        // Check if the notification should be sent
        $notifyAthletes = $request->has('notify_athletes');
        // Send notifications and create activity log for each athlete
       foreach ($athletes as $athlete) {
        Notification::create([
            'sender_id' => $userID,
            'receiver_id' => $athlete->user_id,
            'message' => 'created new checklist form, "' . $checklistTitle . '" for ' . $materialTitle . ' under ' . $sportName . '.',
        ]);

        // Optionally, send notifications to athletes
        if ($notifyAthletes) {
            $user = $athlete->user;
            $user->notify(new ChecklistNotification($checklist, $materialTitle, $coach->user->fname, $coach->user->lname, $sportName));
        }
    }

        // Handle saving the form data here...

        return redirect()->back()->with('success', 'Checklist form saved successfully');
    } catch (Exception $e) {
        // Handle the exception
        Log::error('Error occurred while saving checklist form: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while saving the checklist form. Please try again later.');
    }
}
    public function store(Request $request, $id)
{
    try {
        // Validate the incoming request data
        $validatedData = $request->validate([
        'field_name' => 'required|string',
        'field_type' => 'required|string',
        'options.*' => 'nullable|string', // Validate each option in the array
        'file_options' => 'nullable|string',
        'range' => 'nullable|array',
        'is_required' => 'required|boolean',
    ]);

    // Retrieve authenticated user's ID
    $userID = auth()->user()->id;
        
    // Find the checklist with the given $id
    $checklist = Checklist::find($id);
        
    foreach ($validatedData['options'] as $optionIndex => $option) {
    $checklistItem = new ChecklistItem;
    $checklistItem->field_name = $validatedData['field_name'];
    $checklistItem->field_type = $validatedData['field_type'];

    if ($validatedData['field_type'] === 'file') {
        // Save file option in the options column
        $checklistItem->options = $validatedData['file_options'];
    } else {
        // For other options, save as usual
        $checklistItem->options = $option;
    }

    // Check if the range has at least 2 elements (minimum and maximum thresholds)
    if (isset($validatedData['range'][0]) && isset($validatedData['range'][1])) {
        $checklistItem->minimum_threshold = $validatedData['range'][0];
        $checklistItem->maximum_threshold = $validatedData['range'][1];
    }

    // If the range has additional elements beyond the first two, store them in the options column
    if ($optionIndex >= 2 && isset($validatedData['range'][$optionIndex])) {
        $checklistItem->options = $validatedData['range'][$optionIndex];
    }

    $checklistItem->checklist_id = $id;
    $checklistItem->is_required = $validatedData['is_required'];
    $checklistItem->save(); // Save the checklist item
    }
    // Optionally, you can redirect the user or return a response
    return redirect()->back()->with('success', 'Checklist items created successfully');
    } catch (QueryException $e) {
        // Handle the database query exception
        Log::error('Error occurred while storing:'.$e->getMessage());
        return redirect()->back()->with('error','An error occurred while storing the form field, Please try again later.');
    }
}
    public function resetForm($id) {
    try {
        // Find the checklist and authenticated user
        $checklist = Checklist::findOrFail($id);
        $user = auth()->user();

        // Retrieve user ID
        $userID = $user->id;

        // Retrieve checklist items associated with the checklist ID
        $items = ChecklistItem::where('checklist_id', $id)->get();

        // Generate table name
        $tableName = Str::slug($checklist->title, '_') . '_data';

        // Delete all checklist items
        $items->each->delete();

        // Drop the table if it exists
        if (Schema::hasTable($tableName)) {
            Schema::dropIfExists($tableName);
        }

        // Log the activity
        ActivityLog::create([
            'user_id'=> $userID,
            'activity'=> 'Reset the form of ' . $checklist->title . '.'
        ]);

        return redirect()->back()->with('success', 'Checklist form reset successfully');
    } catch (ModelNotFoundException $e) {
        // Handle the case where the checklist with the given ID is not found
        Log::error('Checklist not found with ID: ' . $id);
        return redirect()->back()->with('error', 'Checklist not found.');
    } catch (\Exception $e) {
        // Handle other exceptions
        Log::error('Error occurred while resetting: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while resetting the form, please try again later.');
    }
}

}
