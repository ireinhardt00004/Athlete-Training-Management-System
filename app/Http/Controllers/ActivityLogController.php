<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    //
    
    public function index() {
    try {
        $user = auth()->user();
        $userID = $user->id;

        // Use where instead of find for querying by user_id
        $logs = ActivityLog::where('user_id', $userID)->latest()->paginate(10);
        
        return view('activity.logs', compact('logs'));
    } catch (QueryException $e) {
        Log::error('Error occurred in fetching log: ' . $e->getMessage());

        // Set error message in the session
        return redirect()->back()->with('error', 'An error occurred while fetching the logs.');
    }
}
    public function adminIndex() {
      try {
        $user = auth()->user();
        $userID = $user->id;

        // Use where instead of find for querying by user_id
        $logs = ActivityLog::latest()->paginate(10);
        
        return view('activity.user-logs', compact('logs'));
    } catch (QueryException $e) {
        Log::error('Error occurred in fetching log: ' . $e->getMessage());

        // Set error message in the session
        return redirect()->back()->with('error', 'An error occurred while fetching the logs.');
    }
    }  
     public function delete($id) {
    try {
        // Find the log by ID
        $log = ActivityLog::find($id);

        if (!$log) {
            return redirect()->back()->with('error', 'Log Details not found.');
        }

        // Get the admin ID from the authenticated user
        $adminID = auth()->user()->id;

        // Check if the log is associated with the authenticated user
        if ($log->user_id != $adminID) {
            return redirect()->back()->with('error', 'Log not associated with the user.');
        }

        // Delete the log
        $log->delete();

        return redirect()->back()->with('success', 'Log Deleted Successfully.');
    } catch (QueryException $e) {
        Log::error('Error occurred in deleting: ' . $e->getMessage());

        // Set error message in the session
        return redirect()->back()->with('error', 'An error occurred while deleting the log.');
    }
}

    public function clearAll() {
    
        $user = auth()->user();
        $userID = $user->id;

        // Use where instead of find for querying by user_id
        ActivityLog::where('user_id', $userID)->truncate();

        return redirect()->back()->with('success', 'Cleared All Activity Logs Successfully.');
    
    }

    public function exportLogs()
    {
    try {
        // Get the authenticated user's activity logs, ordered by the latest first
        $activityLogs = ActivityLog::where('user_id', Auth::id())
            ->latest()
            ->get();

        // Handle case where there are no logs
        if ($activityLogs->isEmpty()) {
            return redirect()->back()->with('error', 'No logs available for export.');
        }

        // Define the CSV file name and headers
        $fileName = 'activity_logs.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
        ];

        // Create a CSV file
        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, ['Activity', 'Timestamp']);

        foreach ($activityLogs as $log) {
            fputcsv($handle, [$log->activity, $log->created_at->format('Y-m-d H:i:s')]);
        }

        rewind($handle);

        // Create a response with the CSV file
        $csv = stream_get_contents($handle);
        fclose($handle);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => 'Downloaded the activity logs record.',
        ]);

        return Response::make($csv, 200, $headers);
    } catch (QueryException $e) {
        Log::error('Error occurred in exporting logs: ' . $e->getMessage());

        // Set error message in the session
        return redirect()->back()->with('error', 'An error occurred while exporting the logs.');
    }
}

    public function exportUsersLogs()
    {
        try {
            // Get the authenticated user's activity logs, ordered by the latest first
            $activityLogs = ActivityLog::latest()->get();

            // Handle case where there are no logs
            if ($activityLogs->isEmpty()) {
                return redirect()->back()->with('error', 'No logs available for export.');
            }

            // Define the CSV file name and headers
            $fileName = 'activity_logs.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=$fileName",
            ];

            // Create a CSV file
            $handle = fopen('php://temp', 'r+');
            fputcsv($handle, ['User', 'Activity', 'Timestamp']);

            foreach ($activityLogs as $log) {
                fputcsv($handle, ["{$log->users->name}", "{$log->activity}", "{$log->created_at->format('Y-m-d H:i:s')}"]);
            }

            rewind($handle);

            // Create a response with the CSV file
            $csv = stream_get_contents($handle);
            fclose($handle);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'activity' => 'Downloaded the activity logs record.',
            ]);

            return Response::make($csv, 200, $headers);
        } catch (QueryException $e) {
            Log::error('Error occurred in exporting logs: ' . $e->getMessage());

            // Set error message in the session
            return redirect()->back()->with('error', 'An error occurred while exporting the logs.');
        }
    }

}
