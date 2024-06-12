@extends('layouts.class')
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
<div class="nav-classlink">
   
  <div class="nav" style="margin-top: 20px;">
    <ul class="nav nav-tabs" style="background-color: #f8f9fa; border-radius: 8px; padding: 10px;">
        <li class="nav-item">
            <a class="nav-link " aria-current="page"  href="{{ route('class-page', ['sport_id' => $material->sport->id]) }}"style="color: #333; font-size: 16px;">Back to {{ $material->sport->name }} </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{ route('material.page', ['id' => $material->id]) }}" style="color: #333; font-size: 16px;">{{ $material->title }}  |  {{ $material->sport->name }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ route('checklists.index', ['id' => $material->id]) }}" style="color: #333; font-size: 16px; font-weight: bold;"> {{ $material->title }} Checklist</a>
        </li>
    </ul>
</div>
<br>
            
                     
 <div class="card shadow mb-4">
        <div class="card-header py-3">
                     @auth
                    @if (auth()->user()->hasRole('coach')) 
                            <h6 class="m-0 font-weight-bold text-primary">
                                <a href="#"data-toggle="modal" data-target="#createModal"><button class="btn btn-primary" style="margin:5px; float: right;"><i class="fa fa-pencil"></i> Create Checklist</button></a> 
                            </h6>
                             @endif @endauth
                             <h1 class="h3 mb-2 text-gray-800">{{ $material->title}}</h1> 
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Timestamp</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                </tfoot>
                                <tbody>
                                    @if($forms->isEmpty())
                                        <tr>
                                            <td colspan="4">No Checklist available</td>
                                            <!-- Add more columns as needed -->
                                        </tr>
                                    
                                    @else
                        {{-- Set the starting index for the next page --}}
                        @php
                        $startIndex = ($forms->currentPage() - 1) * $forms->perPage() + 1;
                         @endphp
                        @foreach ($forms as $index => $log)
                            <tr>
                        <td> {{ $startIndex + $index }}</td>  
                        <td>{{ $log->title}}</td>
                        <td>{{ $log->description}}</td>
                       <td>{{ $log->created_at->format('F j, Y h:i A') }} ({{ $log->created_at->diffForHumans() }})</td>
            <td>
          @auth
        @if (auth()->user()->hasRole('user'))          
            <a href="{{ route('checklistform-fetchpage',['id' => $log->id])  }}"><button class="btn btn-success" title="View Checklist" style="margin:5px;">
                <i class="fa fa-eye"></i>
            </button></a> 
        @endif
         @endauth
         @auth
         @if (auth()->user()->hasRole('coach') || auth()->user()->hasRole('admin'))
    
         <a href="{{route('checklist-page',['id' => $log->id])  }}"><button class="btn btn-success" title="View" style="margin:5px;">
                <i class="fa fa-eye"></i>
            </button></a>

           <button class="btn btn-info" title="Edit" 
           onclick="editChecklist({{ $log->id  }})" style="margin:5px;">
                <i class="fa fa-edit"></i>
            </button>
            <a href="{{route('response-from-user',['id' => $log->id])  }}"><button class="btn btn-warning" title="View Response Page" style="margin:5px;">
               <i class="fas fa-chart-bar"></i>
            </button></a>  
            <!-- Button to trigger the confirmation modal -->
            <button class="btn btn-danger" title="Remove CheckList" data-toggle="modal" data-target="#confirmationModal{{ $log->id }}" style="margin:5px;">
                <i class="fa fa-trash"></i>
            </button>
        @endif
        @endauth
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
                <form method="POST" action="{{ route('delete.checklist', ['id' => $log->id]) }}">
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                    Are you sure you want to delete this checklist?
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
                        Showing {{ $forms->firstItem() }} to {{ $forms->lastItem() }} of {{ $forms->total() }} results
                    </div>
                        <ul class="pagination">
                            {{-- Pagination links --}}
                            {{ $forms->links('vendor.pagination.custom', ['paginator' => $forms]) }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>




<!--Edit Material Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editMaterialModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMaterialModalLabel">Change title or Description</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form for editing material content -->
                <form id="editChecklistForm" method="POST" action="{{ route('checklist-updates') }}" enctype="multipart">
                    <!-- Form fields for editing content -->
                    <div class="mb-3">
                        @csrf
                         <input type="hidden" name="_method" value="PUT">
                        <label for="checkTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="checklistTitle" name="title" placeholder="Enter title">
                    </div>
                    <div class="mb-3">
                        <label for="materialContent" class="form-label">Description</label>
                        <textarea class="form-control" id="checklistDescription" name="description" rows="5" placeholder="Enter content"></textarea>
                    </div>
                    <input type="hidden" id="checklistId" name="checklist_id">
                    <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-secondary"><i class="fa fa-times"></i> Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Changes</button>
                    
                </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- create checklist Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="customizeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customizeModalLabel">Create Customize Checklist</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('checklists.create', ['id' => $material->id]) }}" enctype="multipart/form-data">
                    @csrf
                    {{--<div class="form-group">
                        <label for="exampleFormControlFile1">Choose an image file</label>
                        <input type="file" class="form-control-file" id="exampleFormControlFile1" onchange="loadFile(event)" accept="image/*" name="file" required>
                    </div>
                    <div class="text-center mt-3">
                        <img id="output" style="max-width: 100%; align-items: center;" class="img-thumbnail">
                    </div> --}}
                    {{-- Field Name --}}
                        <div class="form-group">
                            <label for="descr">Please input.</label>
                        </div>        
                    <input type="hidden" name="material_id" value="{{ $material->id }}">

                        {{-- title field --}}
                        <div class="form-group">
                            <label for="field_name">Title</label>
                            <input type="text" class="form-control" id="title-check" name="title" required >
                        </div>
                        {{-- description field --}}
                        <div class="form-group">
                            <label for="field_name">Description</label>
                            <textarea class="form-control" name="description"></textarea>
                        </div>
                     
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-close"></i> Cancel</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Function to handle AJAX request and open modal
function editChecklist(logId) {
    // Get CSRF token value
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    // AJAX request to fetch material details
    $.ajax({
        url: '/checklist-details/' + logId,
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function(response) {
            // Populate the form fields in the modal with material details
            $('#checklistId').val(logId);
            $('#checklistTitle').val(response.checklist.title);
            $('#checklistDescription').val(response.checklist.description);

            // Show the modal
            $('#editModal').modal('show');
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            // Optionally, display an error message to the user
        }
    });
}


</script>

@endsection
@section('title', $material->title . ' | Checklist')
