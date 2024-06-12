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
        font-size: 15px;
        font-weight: bold;
        color: black;
    }

    /* Alternate row color */
    .table tbody tr:nth-child(odd) {
        background-color: #f2f2f2;
    }
</style>
<div class="nav-classlink">
   
  <div class="nav" style="margin-top: 20px;">
    <ul class="nav nav-tabs" style="background-color: #f8f9fa; border-radius: 8px; padding: 10px;">
        <li class="nav-item">
            <a class="nav-link " aria-current="page"  href="{{ route('class-page', ['sport_id' => $checklist->material->sport->id]) }}"style="color: #333; font-size: 16px;">Back to {{ $checklist->material->sport->name }} </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{ route('material.page', ['id' => $checklist->material->id]) }}" style="color: #333; font-size: 16px;">{{ $checklist->material->title }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ route('checklists.index', ['id' => $checklist->material->id]) }}" style="color: #333; font-size: 16px; font-weight: bold;"> {{ $checklist->title}} Checklist</a>
        </li>
         <li class="nav-item">
            <a class="nav-link " aria-current="page"   href="{{ route('stats.index', ['id' => $checklist->id]) }}" style="color: #333; font-size: 16px; "> {{ $checklist->title}} Statistical Report</a>
        </li>
    </ul>
</div>
<br>
             <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">{{ $checklist->title}}</h1> 
                     
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                             
                        </div>

                        <div class="card-body">
   <div class="table-responsive">

    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>#</th>
                @foreach ($columnNames as $columnName)
                    @if (!in_array($columnName, ['checklist_id', 'updated_at','id']))
                        @php
                            $displayName = ucwords(str_replace('_', ' ', $columnName));
                            if ($columnName === 'user_id') {
                                $displayName = 'User Name';
                            } elseif ($columnName === 'created_at') {
                                $displayName = 'Timestamp';
                            }
                        @endphp
                        <th>{{ $displayName }}</th>
                    @endif
                @endforeach
                <th colspan="2">Remarks</th>
            </tr>
        </thead>
        <tbody>
    @if($formData->isEmpty())
        <tr>
            <td colspan="{{ count($columnNames) + 1 }}">No Data available</td>
        </tr>
    @else
        {{-- Set the starting index for the next page --}}
        @php
            $startIndex = ($formData->currentPage() - 1) * $formData->perPage() + 1;
        @endphp
        @foreach ($formData as $index => $data)
    <tr>
        <td>{{ $startIndex + $index }}</td>
        <!-- Display dynamic column values -->
       @foreach ($columnNames as $columnName)
    @if (!in_array($columnName, ['checklist_id', 'id', 'updated_at']))
        @if ($columnName === 'user_id')
            {{-- Assuming $users is a collection of all users --}}
            @php
                $users = App\Models\User::all();
                $user = $users->where('id', $data->$columnName)->first();
            @endphp
            @if ($user)
                <td>{{ $user->name }}</td>
            @else
                <td>User Not Found</td>
            @endif
        @elseif ($columnName === 'created_at' && isset($data->$columnName))
            <td>
                @if ($data->$columnName)
                    {{ \Carbon\Carbon::parse($data->$columnName)->format('F j, Y h:i A') }} ({{ \Carbon\Carbon::parse($data->$columnName)->diffForHumans() }})
                @endif
            </td>
        @else
            @php
                $fileExtension = pathinfo($data->$columnName, PATHINFO_EXTENSION);
            @endphp
            @if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif', 'bmp']))
                <td><img src="{{ asset($data->$columnName) }}" alt="Image" style="max-width: 100px; max-height: 100px;"></td>
            @elseif (in_array(strtolower($fileExtension), ['mp4', 'avi', 'mov', 'wmv', 'mkv']))
                <td><video src="{{ asset($data->$columnName) }}" controls style="max-width: 100px; max-height: 100px;"></video></td>
            @elseif (in_array(strtolower($fileExtension), ['pdf', 'doc', 'docx', 'txt']))
                <td><a href="{{ asset($data->$columnName) }}" target="_blank">View Document</a></td>
            @else
                <td>{{ str_replace(['["', '"]'], '', $data->$columnName) }}</td>
            @endif
        @endif
    @endif
@endforeach
        <td>
    @if ($data->checklist_id && $data->user_id)
        @php
            $rating = \App\Models\Rating::where('checklist_id', $data->checklist_id)
                                          ->where('user_id', $data->user_id)
                                          ->first();
        @endphp

        @if ($rating && $rating->is_completed)
            <!-- Display a button or logo for a completed task -->
            <button class="btn btn-success" title="Marked as Complete">Completed  <i class="fa fa-check"></i></button>
        @else
             <button class="btn btn-info" title="Rate" data-toggle="modal" data-target="#rateModal{{ $data->user_id }}">
            <i class="fa fa-chart-bar"></i> Rate
            </button>
            <!-- Display a button to mark the task as done -->
           <button class="btn btn-success" data-target="#markAsDoneModal{{ $data->user_id }}" data-toggle="modal" title="Marked as Done"><i class="fa fa-check"></i>  Mark as Done</button>
        @endif
    @else
        <!-- Display a message or fallback content if checklist_id or user_id is not available -->
        <p>Task information not available</p>
    @endif
</td>


    </tr>
@endforeach

    @endif
</tbody>

    </table>
</div>


        <!-- Add pagination links -->
        <div class="pagination-container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    Showing {{ $formData->firstItem() }} to {{ $formData->lastItem() }} of {{ $formData->total() }} results
                </div>
                <ul class="pagination">
                    {{-- Pagination links --}}
                    {{ $formData->links('vendor.pagination.custom', ['paginator' => $formData]) }}
                </ul>
            </div>
        </div>
    </div>
</div>

@isset($data)
<!-- Rate Modal -->
<div class="modal fade" id="rateModal{{ $data->user_id }}" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel" style="color:black; font-weight:bold;">Rate</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('rate-task', ['id' => $data->user_id]) }}">
                    @csrf
                    <div class="form-group" style="color: black; font-weight: bold;">
                        <input type="hidden" name="checklist_id" value="{{ $data->checklist_id }}">
                        <label>Choose ratings.</label>
                        <!-- Use radio inputs for rating options -->
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="rate" id="rate5" value="5">
                            <label class="form-check-label" for="rate5">5 - Excellent</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="rate" id="rate4" value="4">
                            <label class="form-check-label" for="rate4">4 - Very Good</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="rate" id="rate3" value="3">
                            <label class="form-check-label" for="rate3">3 - Good</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="rate" id="rate2" value="2">
                            <label class="form-check-label" for="rate2">2 - Fair</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="rate" id="rate1" value="1">
                            <label class="form-check-label" for="rate1">1 - Poor</label>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Confirm</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Mark As Done Modal -->
<div class="modal fade" id="markAsDoneModal{{ $data->user_id }}" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel" style="color:black; font-weight:bold;">Mark As Done</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="color:black; font-weight:bold;">
                <form method="POST" action="{{ route('mark-as-done', ['id' => $data->user_id]) }}">
                @csrf
               <input type="hidden" name="checklist_id" value="{{ $data->checklist_id }}">
                 <input type="hidden" value="{{ $data->user_id }}">
                <p> Are you sure to mark it as done? </p>
            
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Confirm</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endisset


@endsection
@section('title', 'Response from ' . $checklist->title . ' Checklist')
