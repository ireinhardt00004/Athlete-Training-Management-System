@extends('layouts.coach')
@section('content')
<style>
       .nav {
        font-size: 20px;
        font-family:   sans-serif;
    }
  /* Style for the table */
     .table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        background-color: #fff;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    /* Style for table header */
    .table th {
        background-color: #007BFF;
        color: #fff;
        font-weight: bold;
        padding: 10px;
        text-align: left;
    }

    /* Style for table body */
    .table td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #e0e0e0;
    }

    /* Alternate row color */
    .table tbody tr:nth-child(odd) {
        background-color: #f2f2f2;
    }
</style>
 			<!-- Page Heading -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3"><a href="{{ route('logs.index')}}"><h4 class="mb-2 text-gray-800">Activity Logs</h4></a>
                            <a href="{{ route('export.logs') }}" class="btn btn-secondary" style="margin:5px; float:right;">
                <i class="fa fa-download"></i> Export as CSV</a>
                <a href="#"data-toggle="modal" data-target="#clearAllModal"><button class="btn btn-danger" style="margin:5px; float: right;"><i class="fa fa-trash"></i> Clear All Logs</button></a>  
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
							    <thead>
							        <tr>
							        	<th>Activity</th>
							            <th>Timestamp</th>
							            <th>Action</th>
							        </tr>
							    </thead>
							    <tbody>
							        @if($logs->isEmpty())
							            <tr>
							                <td colspan="4">No Logs available</td>
							                <!-- Add more columns as needed -->
							            </tr>
							        @else
							     @foreach($logs as $log)
                         <tr>
                        <td>{{ $log->activity}}</td>
                        <td>{{ $log->created_at->diffForHumans() }} {{ $log->created_at }}</td>
        <td>  
            <!-- Button to trigger the confirmation modal -->
            <button class="btn btn-danger" title="Remove Log" data-toggle="modal" data-target="#confirmationModal{{ $log->id }}">
                <i class="fa fa-trash"></i>
            </button>
        </td>
    </tr>

    <!-- Deleting Modal -->
<div class="modal fade" id="confirmationModal{{ $log->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirm Deletion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('delete.log', ['id' => $log->id]) }}">
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                    Are you sure you want to delete this log?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <!-- Pass the coach's ID to the delete function in your controller -->
                <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endforeach
@endif
	</tbody>
		</table>
             <!-- Add pagination links -->
            <div class="pagination-container">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        Showing {{ $logs->firstItem() }} to {{ $logs->lastItem() }} of {{ $logs->total() }} results
                    </div>
                        <ul class="pagination">
                            {{-- Pagination links --}}
                            {{ $logs->links('vendor.pagination.custom', ['paginator' => $logs]) }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

               </div>
                   </div>
                    	</div>



     <!-- Deleting All  Modal -->
<div class="modal fade" id="clearAllModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirm Deletion of all Logs</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('clearall.log') }}">
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                    Are you sure you want to delete all activity logs?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <!-- Pass the coach's ID to the delete function in your controller -->
                <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
	

@endsection
@section('title','Activity Logs')