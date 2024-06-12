@extends('layouts.coach')
@section('content')
<style>
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
    <div class="card-header py-3">
        <a href="{{ route('coachz.index') }}">
            <h1 class="h3 mb-2 text-gray-800">List of Coach</h1>
        </a>
        <a href="{{ route('export.coaches') }}">
            <button class="btn btn-secondary" style="margin:5px; float: right;">
                <i class="fa fa-download"></i> Export as CSV
            </button>
        </a>
        <a href="#" data-toggle="modal" data-target="#addCoachModal">
            <button class="btn btn-success" style="margin:5px; float: right;">
                <i class="fa fa-user"></i><i class="fa fa-plus"></i> Add Coach
            </button>
        </a>
        <a href="#" data-toggle="modal" data-target="#sportModal">
            <button class="btn btn-warning" style="margin:5px; float: right;">
                <i class="fa fa-running"></i> Sport List
            </button>
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Coach Number</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Handle Sport</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($coaches->isEmpty())
                    <tr>
                        <td colspan="5">No coaches available</td>
                    </tr>
                    @else
                    @foreach($coaches as $coach)
                    <tr>
                        <td>{{ $coach->coach_number }}</td>
                        <td>{{ $coach->user->fname }} {{ $coach->user->lname }}</td>
                        <td>{{ $coach->user->email }}</td>
                        <td>{{ $coach->sport->name }}</td>
                        <td>
                            <a href="#" data-target="#editCoachModal{{ $coach->id }}" data-toggle="modal">
                                <button class="btn btn-primary" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </button>
                            </a>
                            <button class="btn btn-danger" title="Remove Coach" data-toggle="modal" data-target="#confirmationModal{{ $coach->id }}">
                                <i class="fa fa-trash"></i>
                            </button>
                            <button class="btn btn-dark" title="Remove Account" data-toggle="modal" data-target="#removeAccountModal{{ $coach->id }}">
                                <i class="fa fa-skull"></i>
                            </button>
                        </td>
                    </tr>
                    <!-- Edit Credentials Modal -->
                    <div class="modal fade" id="editCoachModal{{ $coach->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalModalLabel">Edit Credentials</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{ route('edit-coachcredentials', ['id' => $coach->user->id]) }}">
                                        @csrf
                                        <input type="hidden" name="_method" value="PUT">
                                        <div class="form-group">
                                            <label for="password"><i class="fa fa-lock"></i> Change Password</label>
                                            <input class="form-control" type="password" name="password" placeholder="">
                                        </div>
                                        <div class="form-group">
                                            <p>Type your <b>password</b> to confirm</p>
                                            <input class="form-control" type="password" name="password_confirmation" placeholder="Your Password" required>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                        <i class="fa fa-times"></i> Cancel
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-check"></i> Confirm
                                    </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Confirmation Modal -->
                    <div class="modal fade" id="confirmationModal{{ $coach->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmationModalLabel">Confirm Deletion</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{ route('delete.coach', ['id' => $coach->id]) }}">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        Are you sure you want to delete this sport coach?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Remove Account Modal -->
                    <div class="modal fade" id="removeAccountModal{{ $coach->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmationModalLabel">Remove Account</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{ route('remove.coach', ['id' => $coach->id]) }}">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        <div class="form-group">
                                            <label style="color:black;">Type your Password to confirm</label>
                                            <input type="password" class="form-control bg-light border-0 small" placeholder="Enter your Password" name="my_password" required
                                            aria-label="" aria-describedby="basic-addon2">
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                        <i class="fa fa-times"></i> Cancel
                                    </button>
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fa fa-plus"></i> Confirm
                                    </button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>



<!-- add Coach Modal-->
    <div class="modal fade" id="addCoachModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="color:black">Add Coach</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
               <form method="POST" action="{{ route('add.coach') }}">
    			@csrf
                 <div class="form-group">
                 	<label style="color:black;">Last Name</label>
                	<input type="text" class="form-control bg-light border-0 small" placeholder="Enter Last Name" name="lname" required 
                    aria-label="" aria-describedby="basic-addon2">
                </div>            
           
                 <div class="form-group">
                 	<label style="color:black;">Middle Name</label>
                	<input type="text" class="form-control bg-light border-0 small" placeholder="Enter Middle Name" name="middlename" 
                    aria-label="" aria-describedby="basic-addon2">
                </div>            
                <div class="form-group">
                 	<label style="color:black;">First Name</label>
                	<input type="text" class="form-control bg-light border-0 small" placeholder="Enter First Name" name="fname" required
                    aria-label="" aria-describedby="basic-addon2">
                </div>
              <!-- Sport -->
                <div class="form-group">
                    <label style="color: black;">Sport to handle</label>
                    <div class="row">
                        @if($sports->isEmpty())
                            <div class="form-check">
                                <p>No sports data</p>
                            </div>
                        @else
                            @foreach($sports as $sport)
                                <div class="col-6 col-md-4 col-lg-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="sports[]" value="{{ $sport->id }}">
                                        <label class="form-check-label" style="color: black; font-size: 1rem;">{{ $sport->name }}</label>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="form-group">
                 	<label style="color:black;">Email Address</label>
                	<input type="email" class="form-control bg-light border-0 small" placeholder="Enter Valid Email Address" name="email" required
                    aria-label="" aria-describedby="basic-addon2">
                </div> 
                <div class="form-group">
                 	<label style="color:black;">Password</label>
                	<input type="password" class="form-control bg-light border-0 small" placeholder="Enter Password" name="password" required
                    aria-label="" aria-describedby="basic-addon2">
                </div>  
                <!-- Confirm Password -->
				<div class="form-group">
				    <label style="color:black;">Confirm Password</label>
				    <input type="password" class="form-control bg-light border-0 small" placeholder="Confirm Password" name="password_confirmation" required
				        aria-label="" aria-describedby="basic-addon2">
				</div>
                 </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fa fa-times"></i>  Cancel</button>
                   <button type="submit" class="btn btn-primary" style="background-color:green;"><i class="fa fa-plus"></i>  Register</button>
                </div>
            </form>
            </div>
        </div>
    </div>

<!-- Sport List Modal-->
<div class="modal fade" id="sportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="color:black">Sport List</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <a href="#" data-toggle="modal" data-target="#addSportModal">
                    <button class="btn btn-success" type="button" style="float:right;"><i class="fa fa-plus"></i> Add Sport</button>
                </a>
                <table class="table-responsive" style="width:100%;">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Number of Athletes Allowed</th>
                            <th colspan="2">Action</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($sports->isEmpty())
                            <tr>
                                <td colspan="3">No sports available</td>
                                <!-- Add more columns as needed -->
                            </tr>
                        @else
                            @foreach($sports as $sport)
                                <tr>
                                    <td>{{ $sport->name }}</td>
                                    <td>{{ $sport->description }}</td>
                                    <td>{{ $sport->number_of_athlete_allowed }}</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" onclick="editSport({{ $sport->id }})" title="Edit Sport" data-target="#editSportModal" data-toggle="modal">
                                            <i class="fa fa-edit"></i> 
                                        </button>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" onclick="confirmDeleteSport({{ $sport->id }})" title="Delete Trash">
                                            <i class="fa fa-trash"></i> 
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
            </table>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            </div>
        </div>
    </div>
</div>


   <!-- add Sport Modal-->
<div class="modal fade" id="addSportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="color:black">Add Sport</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('add.sport') }}">
                    @csrf
                    <div class="form-group">
                        <label style="color:black;">Name of Sport</label>
                        <input type="text" class="form-control bg-light border-0 small" placeholder="" name="name" required
                            aria-label="" aria-describedby="basic-addon2">
                    </div>

                    <div class="form-group">
                        <label style="color:black;">Description (Optional)</label>
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Optional" name="description"
                            aria-label="" aria-describedby="basic-addon2">
                    </div>
                    <div class="form-group">
                        <label style="color:black;">Number of Athletes Allowed</label>
                        <input type="number" class="form-control bg-light border-0 small" placeholder="" required name="number_of_athlete_allowed"
                            aria-label="" aria-describedby="basic-addon2">
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal"><i
                                class="fa fa-times"></i> Cancel</button>
                        <!-- Remove the data-dismiss attribute from the button below -->
                        <button type="submit" class="btn btn-primary" style="background-color:green;"><i
                                class="fa fa-plus"></i> Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- edit Sport --}}
<div class="modal fade" id="editSportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel" style="color:black">Edit Sport</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('update.sport') }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="sportId" name="sportId">
                    <div class="form-group">
                        <label style="color:black;">Name of Sport</label>
                        <input id="nameSport" type="text" class="form-control bg-light border-0 small" placeholder="" name="name" required aria-label="" aria-describedby="basic-addon2">
                    </div>
                    <div class="form-group">
                        <label style="color:black;">Description</label>
                        <input id="descSport" type="text" class="form-control bg-light border-0 small" placeholder="Optional" name="description" aria-label="" aria-describedby="basic-addon2">
                    </div>
                    <div class="form-group">
                        <label style="color:black;">Number of Athletes Allowed</label>
                        <input id="numberAthleteAllowed" type="number" class="form-control bg-light border-0 small" placeholder="" required name="number_of_athlete_allowed" aria-label="" aria-describedby="basic-addon2">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                        <!-- Remove the data-dismiss attribute from the button below -->
                        <button type="submit" class="btn btn-primary" style="background-color:green;"><i class="fa fa-save"></i> Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
   function editSport(sportId) {
    fetch(`/get-sport-details?sportId=${sportId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            updateModalWithData(data);
        })
        .catch(error => {
            console.error('Error fetching sport details:', error);
            alert('An error occurred while fetching sport details. Please try again later.');
        });
}

function updateModalWithData(data) {
    const { name, description, number_of_athlete_allowed, id: sportId } = data;
    document.getElementById('nameSport').value = name;
    document.getElementById('descSport').value = description;
    document.getElementById('numberAthleteAllowed').value = number_of_athlete_allowed;
    document.getElementById('sportId').value = sportId;

    const editSportModal = document.getElementById('editSportModal');
    editSportModal.classList.add('show');
}

</script>

<script>
    function confirmDeleteSport(sportId) {
        var isConfirmed = confirm("Are you sure you want to delete this sport?");

        if (isConfirmed) {
            fetch(`/delete-sport/${sportId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            })
            .then(response => {
                console.log('Response Headers:', response.headers);
                console.log('Response Status:', response.status);

                if (!response.ok) {
                    throw new Error(`Network response was not ok - Status: ${response.status} ${response.statusText}`);
                }

                const contentType = response.headers.get('content-type');
                console.log('Content Type:', contentType);

                if (contentType && contentType.includes('application/json')) {
                    return response.json();

                } else {
                    console.error('Invalid content type');
                    console.log('Response Text:', response.text());
                    throw new Error('Invalid content type');
                    location.reload();
                }
            })
            .then(data => {
                console.log(data);
                alert(data.success);
                location.reload();
            })
            .catch(error => {
                console.error('Error:', error.message);
            });
        }
    }
</script>



@endsection
@section('title', 'List of Coach')