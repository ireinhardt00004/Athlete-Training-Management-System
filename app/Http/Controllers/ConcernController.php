<?php
// app/Http/Controllers/ConcernController.php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Models\Concern;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\ActivityLog;
use App\Mail\ConcernReply;

class ConcernController extends Controller
{
   

public function store(Request $request)
{
    $validatedData = $request->validate([
        'name-con' => 'required',
        'email-con' => 'required|email',
        'phone-con' => 'nullable',
        'subject-con' => 'nullable',
        'message-con' => 'required',
    ], [
        'email-con.required' => 'The email field is required.',
        'email-con.email' => 'Please enter a valid email address.',
        'message-con.required' => 'The message field is required.',
    ]);

            // Assuming 'name-con', 'email-con', 'phone-con', 'subject-con', and 'message-con' are the names of your input fields
        $name = $request->input('name-con');
        $email = $request->input('email-con');
        $phone = $request->input('phone-con');
        $subject = $request->input('subject-con');
        $messageContent = $request->input('message-con');

        Concern::create([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'subject' => $subject,
            'message' => $messageContent,
        ]);

        $adminIDs = User::where('roles', 'admin')->pluck('id')->toArray();
       // Iterate over each admin ID to create a notification
        foreach ($adminIDs as $adminID) {
            Notification::create([
                'sender_id' => $adminID,
                'receiver_id' => $adminID,
                'message' =>  ' received an concern message from the Contact Us form.',
                'is_read' => false,
            ]);
        }
        // Send email to users with admin role
        $adminEmails = User::where('roles', 'admin')->pluck('email')->toArray();
        Mail::to($adminEmails)->send(new \App\Mail\ConcernSubmitted($name, $email, $phone, $subject, $messageContent));

        return redirect()->back()->with('success', 'Concern sent successfully!');

        }

        public function getConcern(){
            try {
                // Check if the authenticated user has a role of sub-admin
                $user = auth()->user();
                if ($user->roles !== 'admin') {
                    abort(403, 'You do not have permission to access this page.');
                }
        
                $concerns = Concern::latest()->paginate(10);
                // Fetch the organization details based on the user's studnum
                
                // Record the activity in the activity log
                ActivityLog::create([
                    'user_id' => $user->id,
                    'activity' => 'Checked the Contact Us page.',
                ]);
        
                return view('admin.concern', compact('concerns'));

            }
         catch (QueryException $e) {
            Log::error('Error fetching the member list: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while fetching the list who fillup the contact us form.');
        }
    }
        public function fetchConcern($id)
        {  try {
            $concern = Concern::findOrFail($id);
            return response()->json($concern);
        } catch (Exception $e) {
            Log::error('Error fetching the concern details: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while fetching the details of  who fillup the contact us form.');
            
    }
   }         

        public function sendReply(Request $request)
        {
            try {
            $request->validate([
                'concern_id' => 'required|exists:concerns,id',
                'reply_message' => 'required',
            ]);

            $concern = Concern::find($request->input('concern_id'));

            // Ensure the authenticated user is an admin
            $admin = auth()->user();
            if ($admin->roles !== 'admin') {
                abort(403, 'You do not have permission to reply to concerns.');
            }

            // Send email to the user who submitted the concern
            Mail::to($concern->email)->send(new ConcernReply($admin->email, $request->input('reply_message')));
                // Record the activity in the activity log
                ActivityLog::create([
                    'user_id' => $admin = auth()->user()->id,
                    'activity' => 'Sent a reply message  to a Concern.',
                ]);

            return redirect()->back()->with('success', 'Reply sent successfully!');
        }
        catch (QueryException $e) {
            Log::error('Error fetching the member list: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while processing the reply.');
        }
    }
  

        public function deleteAll(Request $request)
        {
            try {
                // Ensure the authenticated user is an admin
                $admin = auth()->user();
                if ($admin->roles !== 'admin') {
                    abort(403, 'You do not have permission to delete concerns.');
                }

                // Delete all rows in the Concern table
                Concern::truncate();

                // Record the activity in the activity log
                ActivityLog::create([
                    'user_id' => $admin->id,
                    'activity' => 'Cleared all concerns.',
                ]);

                return redirect()->back()->with('success', 'All concerns deleted successfully!');
            } catch (QueryException $e) {
                Log::error('Error deleting concerns: ' . $e->getMessage());
                return redirect()->back()->with('error', 'An error occurred while deleting concerns.');
            }
        }
        public function downloadCSV()
        {
            try {
                // Ensure the authenticated user is an admin
                $admin = auth()->user();
                if ($admin->roles !== 'admin') {
                    abort(403, 'You do not have permission to delete concerns.');
                }

                // Get concerns data
                $concerns = Concern::all();
        
                // Generate CSV content
                $csvData = "ID,Name,Email,Subject,Message,Timestamp\n";
                foreach ($concerns as $concern) {
                    $csvData .= "{$concern->id},{$concern->name},{$concern->email},{$concern->subject},{$concern->message},{$concern->created_at}\n";
                }
        
                // Download the CSV file
                $headers = array(
                    'Content-Type' => 'text/csv',
                    'Content-Disposition' => 'attachment; filename="concerns.csv"',
                );
                 // Record the activity in the activity log
                 ActivityLog::create([
                    'user_id' => $admin->id,
                    'activity' => 'Downloaded the  Concerns table data.',
                ]);

                return response()->stream(
                    function () use ($csvData) {
                        echo $csvData;
                    },
                    200,
                    $headers
                );
               
            } catch (\Exception $e) {
                // Handle exceptions here
                return redirect()->back()->with('error', 'An error occurred while downloading the CSV file.');
            }
        }
        
        public function deleteConcern(Request $request)
{
    try {
        $concernID = $request->input('concernID');
        $concern = Concern::where('id', $concernID)->delete();

        if (!$concern) {
            return redirect()->back()->with('error', 'Concern not found.');
        }

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'activity' => 'Deleted a concern.',
        ]);

        return redirect()->back()->with('success', 'Deleting the concern successfully.');
    } catch (\Exception $e) {
        // Log the exception for further investigation
        Log::error('Error deleting concern: ' . $e->getMessage());

        return redirect()->back()->with('error', 'An error occurred while deleting the concern.');
    }
}


}

    


