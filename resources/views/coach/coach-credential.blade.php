@extends('layouts.coach')
@section('content')
<style>
    /* Profile container */
    .profile-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    /* Profile header */
    .profile-header {
        display: flex;
        align-items: center;
        flex-wrap: wrap; /* Added to allow wrapping on smaller screens */
    }

    .profile-picture {
        margin-right: 20px;
        flex: 0 0 auto; /* Added to prevent stretching */
    }

    .profile-picture img {
        width: 192px;
        height: 192px;
        /* border-radius: 50%; */
    }
    .profile-info {
        flex-grow: 1;
    }

    .profile-box {
        padding: 10px;
    }

    .profile-box h1 {
        font-size: 24px;
        margin-bottom: 5px;
    }

    .profile-box p {
        font-size: 16px;
        margin-bottom: 10px;
    }

    /* About section */
    .profile-details {
        margin-top: 20px;
    }

    .profile-details button {
        margin-bottom: 10px;
    }

    .profile-details h2 {
        font-size: 20px;
        margin-bottom: 10px;
    }

    /* Modal */
    .modal-dialog {
        max-width: 800px;
    }

    .modal-body img {
        width: 100%;
        height: auto;
    }

    /* Responsive adjustments */
    @media screen and (max-width: 768px) {
        .profile-header {
            flex-direction: column; /* Stack items vertically on smaller screens */
            align-items: flex-start; /* Align items to the start */
        }
        .profile-picture {
            margin-right: 0; /* Remove margin on smaller screens */
            margin-bottom: 20px; /* Add margin at the bottom */
        }
    }
</style>
<div class="profile-container">
    <div class="profile-header">
        <div class="profile-picture" >
            @if ($coach->user->avatar)
            <a href="#" data-toggle="modal" data-target="#imageModal" title="Click to enlarge image">
                <img class="circular-profile-pic" style="border: 1px solid black;" src="{{ asset($coach->user->avatar) }}" alt="{{ $coach->user->lname }} {{ $coach->user->fname }} {{ $coach->user->middlename }}">
            </a>
        @else
            <a href="#" data-toggle="modal" data-target="#imageModal" title="Click to enlarge image">
                <img class="circular-profile-pic" src="{{ asset('img/avatar/default-pfp.png') }}" alt="{{ $coach->user->lname }} {{ $coach->user->fname }} {{ $coach->user->middlename }}">
            </a>
        @endif
        
        </div>

        <div class="profile-info">
            <div class="profile-box">
                <h1 style="font-weight:bold; color: black; text-transform: uppercase;">{{ $coach->user->fname }} {{ $coach->user->middlename }} {{ $coach->user->lname }}</h1>
                <p style="color: black; font-size: 17px;">Email Address: {{ $coach->user->email }}</p>
                <p style="color: black; font-size: 17px; font-weight:bold;">Handled Sports:</p>
                <ul style="list-style-type: none; padding: 0;">
                    @foreach($sports as $sport)
                        <li style="color:black;"><h5>{{ $sport->name }}</h5></li>
                    @endforeach
                </ul>
            </div>
        </div>
        
    </div>

    <div class="profile-details" style="color: black; font-size: 17px;">
        @if (auth()->check() && auth()->user()->id === $coach->user->id)
        <button class="useredit-button facebook-font btn btn-success" data-target="#usereditModal" data-toggle="modal" title="Edit About" style="float:right;">
            <i class="fas fa-edit"></i> Edit Credentials
        </button><br>
        @endif

        <h2 style="font-weight: bold">About Coach</h2>
        <p><b>Sex:</b> {{ $coach->user->gender ?: 'N/A' }}</p>
        {{-- <p><b>Age:</b> {{  $coach->user->gender ?: 'N/A' }}</p> --}}
        <h2 style="font-weight: bold">Credentials</h2>
        @if ($credentials->count() == 0)
            <div class="alert alert-info" role="alert">
                No credentials found.
            </div>
        @else
            <div class="row">
                @foreach($credentials as $credential)
                    @php
                        // Generate a random color
                        $randomColor = '#' . substr(md5(mt_rand()), 0, 6);
                    @endphp
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2" style="border-color: {{ $randomColor }};">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Seminar Attended</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ isset($credential->seminar_name) ? $credential->seminar_name : 'N/A' }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                                <hr>
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Date</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{ isset($credential->seminar_date) ? $credential->seminar_date->format('F d, Y') : 'N/A' }}
                                            </div>                                            
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                                <hr>
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Additional Details</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ isset($credential->additional_details) ? $credential->additional_details : 'N/A' }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                                <hr>
                                {{-- Delete button --}}
                                @if (auth()->check() && auth()->user()->id === $coach->user->id)
                                <div class="row no-gutters align-items-center justify-content-end">
                                    <div class="col-auto">
                                        <button class="btn btn-danger delete-btn" style="opacity:0.7;" title="Remove this credential" data-credential-id="{{ $credential->id }}"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        
        <!-- Delete Confirmation Modal -->
        @if (auth()->check() && auth()->user()->id === $coach->user->id)
        <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this credential?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <form id="deleteCredentialForm" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
        
      
        
<!-- Modal for Image Zoom -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <button type="button" class="btn btn-secondary close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times; Close</span>
            </button>
            <div class="modal-body">
                @if ($coach->user->avatar && $coach->user->avatar)
                <img src="{{ asset($coach->user->avatar) }}" alt="Profile Picture">
                @else
                <img src="{{ asset('img/avatar/default-pfp.png') }}" alt="{{ $coach->user->lname }} {{ $coach->user->fname }} {{ $coach->user->middlename }}">
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal for edit -->
<div class="modal fade" id="usereditModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Coach Credentials</h5>
                <button type="button" class="btn btn-secondary close" onclick="handleCancel()" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('coach-credentials',['id' => auth()->user()->id]) }}" enctype="multipart/form-data">
                    @csrf
                    <input name="coachID" type="hidden" class="form-control" value="{{$coach->id}}">
                    {{-- <div class="mb-3">
                        <label for="profile_pic" class="form-label">Profile Photo</label>
                        <input name="profile_pic" type="file" class="form-control" accept="image/*">
                    </div> --}}
                    <div class="form-group">
                        <label>Sex:</label>
                        <select name="gender" class="form-control">
                            <option disabled>Select Sex</option>
                            <option {{ $coach->gender === 'Male' ? 'selected' : '' }}>Male</option>
                            <option {{ $coach->gender === 'Female' ? 'selected' : '' }}>Female</option>
                            {{-- <option {{ $coach->gender === 'Others' ? 'selected' : '' }}>Others</option>
                            <option {{ $coach->gender === 'N/A' ? 'selected' : '' }}>N/A</option> --}}
                        </select>
                    </div>
                    <div id="seminar-fields-container">
                        <div class="form-group">
                            <label for="seminar_name">Name of Seminar Attended</label>
                            <input name="seminar_name[]" type="text" class="form-control" placeholder="Enter seminar name">
                        </div>
                        <div class="form-group">
                            <label for="seminar_date">Date (Optional)</label>
                            <input name="seminar_date[]" type="date" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="additional_details">Additional Details (Optional)</label>
                            <textarea name="additional_details[]" class="form-control" placeholder="Enter additional details"></textarea>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary mb-3" id="add-seminar-field">
                        <i class="fa fa-plus"></i> Add Another Seminar
                    </button>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="handleCancel()">Cancel</button>
                        <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>  Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to append seminar fields -->
<script>
    document.getElementById('add-seminar-field').addEventListener('click', function () {
        var container = document.getElementById('seminar-fields-container');
        var newField = document.createElement('div');
        newField.classList.add('seminar-field-group');
        newField.innerHTML = `
            <div class="form-group">
                <label for="seminar_name">Name of Seminar Attended</label>
                <input name="seminar_name[]" type="text" class="form-control" placeholder="Enter seminar name">
            </div>
            <div class="form-group">
                <label for="seminar_date">Date (Optional)</label>
                <input name="seminar_date[]" type="date" class="form-control">
            </div>
            <div class="form-group">
                <label for="additional_details">Additional Details (Optional)</label>
                <textarea name="additional_details[]" class="form-control" placeholder="Enter additional details"></textarea>
            </div>
            <button type="button" class="btn btn-danger remove-seminar-field"><i class="fa fa-trash"></i> Remove</button>
            <hr>
        `;
        container.appendChild(newField);
        
        newField.querySelector('.remove-seminar-field').addEventListener('click', function () {
            newField.remove();
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var deleteButtons = document.querySelectorAll('.delete-btn');
    
        deleteButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var credentialId = this.getAttribute('data-credential-id');
                var deleteForm = document.getElementById('deleteCredentialForm');
                deleteForm.setAttribute('action', '/credentials/' + credentialId);
                $('#deleteConfirmationModal').modal('show');
            });
        });
    });
    
    function handleCancel() {
        console.log('Cancel button clicked');
        $('#deleteConfirmationModal').modal('hide');
    }
</script>


<script>
var loadFile = function(event) {
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById('output');
        output.style.display = 'block';
        output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
};
</script>

<script>
    $(document).ready(function() {
        // Fetch user data via AJAX when the date input field is changed
        $('#datePicker').change(function() {
            var selectedDate = $(this).val();

            // Make an AJAX request to fetch data from the users table
            $.ajax({
                url: '/fetchUserData',
                method: 'GET',
                data: {
                    date: selectedDate
                },
                success: function(response) {
                    // Handle the response data here
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    // Handle errors
                    console.error(xhr.responseText);
                }
            });
        });

        // Set the default value for the input field
        var currentDate = new Date();
        var tenYearsAgo = new Date(currentDate.getFullYear() - 10, currentDate.getMonth(), currentDate.getDate());
        var formattedDate = tenYearsAgo.toISOString().split('T')[0];
        $('#datePicker').val(formattedDate);
    });
</script>



@endsection
@section('title','Coach Credential')