<?php

// app/Http/Controllers/FormFieldController.php

namespace App\Http\Controllers;

use App\Models\FormField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema; 
use App\Models\Organization; 
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB; 
use Illuminate\Database\QueryException;
use App\Models\ActivityLog;


class FormFieldController extends Controller
{
    public function index()
    {
        // Check if the authenticated user has roleID = sub-admin
        if (auth()->user()->roleID === 'sub-admin') {
            // Get the studnum of the authenticated user
            $studnum = auth()->user()->studnum;
    
            // Find the organization with the matching studnum
            $organization = Organization::where('studnum', $studnum)->first();
    
            if ($organization) {
                // Get the organization ID
                $organizationId = $organization->organization_id;
    
                // Get the form fields related to the organization
                $formFields = FormField::where('organization_id', $organizationId)->get();
            } else {
                // Handle the case where no organization is found for the user's studnum.
                // You can return an error message or perform another action.
                $formFields = collect(); // Empty collection
            }
        } else {
            // Handle the case where the user does not have roleID = sub-admin.
            // You can return an error message or perform another action.
            $formFields = collect(); // Empty collection
        }
       // dd( $organizationId );
        return view('formfields.index', compact('formFields', 'organization'));
    }
    

    public function create()
{
    $user = auth()->user();

    // Check if the user has a roleID of "sub-admin"
    if ($user->roleID === 'sub-admin') {
        // Retrieve the studnum of the authenticated user
        $studnum = $user->studnum;

        // Retrieve the organization based on the studnum
        $organization = \App\Models\Organization::where('studnum', $studnum)->first();

        // Check if an organization is found
        if ($organization) {
            // Get the organization_id
            $organizationId = $organization->organization_id;
           // Record the activity in the activity log
    ActivityLog::create([
        'user_id' => auth()->user()->id,
        'activity' => 'Visited the formfield create page ',
    ]); 
            // Pass the organization_id to the view
            return view('formfields.create', ['organizationId' => $organizationId]);
        }
    }

    // If the user doesn't have the roleID "sub-admin" or the organization is not found,
    // simply return the view without passing the organization_id.
    return view('formfields.create');
}


public function store(Request $request)
{
    try {
        $data = $request->validate([
            'field_name' => 'required|string',
            'field_type' => 'required|string',
            'paragraph_text' => 'string|nullable',
            'is_required' => 'boolean',
        ]);

        $user = auth()->user();

        if ($user->roleID === 'sub-admin') {
            $studnum = $user->studnum;
            $organization = \App\Models\Organization::where('studnum', $studnum)->first();

            if ($organization) {
                $organizationId = $organization->organization_id;
                $organizationName = $organization->organization_name;
                $organizationSpecificTable = Str::slug($organizationName, '_') . '_data';

                if (!Schema::hasTable($organizationSpecificTable)) {
                    Schema::create($organizationSpecificTable, function ($table) use ($organizationId, $data) {
                        $table->id();
                        $table->unsignedBigInteger('organization_id');
                        $table->unsignedBigInteger('user_id');
                        $table->enum('status', ['pending', 'not-join', 'joined'])->default('not-join');
                        $table->timestamps();

                        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                    });
                }

                Schema::table($organizationSpecificTable, function ($table) use ($data) {
                    $fieldName = str_replace(' ', '_', $data['field_name']);
                    $fieldType = $data['field_type'];

                    if ($fieldType === 'text') {
                        $table->text($fieldName)->nullable();
                    } elseif ($fieldType === 'document' || $fieldType === 'image' || $fieldType === 'video') {
                        $table->string($fieldName)->nullable();
                    }
                    // Add other field types if needed
                });

                $data['organization_id'] = $organizationId; // Set the organization_id for form fields
                $data['user_id'] = $user->id; // Set the user_id for form fields

                $formField = FormField::create($data);

                ActivityLog::create([
                    'user_id' => $user->id,
                    'activity' => 'Created a form field: ' . $formField->field_name,
                ]);

                return redirect()->route('formfields.index')->with('success', 'Form field created successfully.');
            }
        }
    } catch (QueryException $e) {
        return redirect()->back()->with('error', 'An error occurred while creating the form field.');
    }
}

    public function edit(FormField $formField)
    {
        return view('formfields.edit', compact('formField'));
    }

    public function update(Request $request, FormField $formField)
    {
        $data = $request->validate([
            'field_name' => 'required|string',
            'field_type' => 'required|string',
            'is_required' => 'boolean',
        ]);

        $formField->update($data);

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Updated a form field: ' . $formField->field_name, // Customize the message as needed
        ]);

        return redirect()->route('formfields.index')->with('success', 'Form field updated successfully.');
    }

    public function destroy(FormField $formField)
    {
        $formField->delete();

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Deleted a form field ' . $formField->field_name, // Customize the message as needed
        ]);


        return redirect()->route('formfields.index')->with('success', 'Form field deleted successfully.');
    }

    public function show()
{
    $formFields = FormField::all();

    return view('organization.show', ['formFields' => $formFields]);
}
public function reset() {
    try {
        $user = auth()->user();

        if ($user->roleID === 'sub-admin') {
            $studnum = $user->studnum;
            $organization = \App\Models\Organization::where('studnum', $studnum)->first();

            if ($organization) {
                $organizationId = $organization->organization_id;
             
                $organizationName = $organization->organization_name;
                $organizationSpecificTable = Str::slug($organizationName, '_') . '_data';
               // dd( $organizationSpecificTable);
                // Delete values associated with the organizationID from formfields
                FormField::where('organization_id', $organizationId)->delete();
                
                // Drop the organization_specific_table_data table
                if (Schema::hasTable($organizationSpecificTable)) {
                    Schema::dropIfExists($organizationSpecificTable);
                }
                ActivityLog::create([
                    'user_id'=> $user->id,
                    'activity'=> 'Reset the Form Fields and the Table',
                ]);
                return redirect()->back()->with('success', 'Reset successful: Form fields and table data deleted.');
            }
        }
    } catch (QueryException $e) {
        return redirect()->back()->with('error', 'An error occurred during the reset process.');
    }
}

}

