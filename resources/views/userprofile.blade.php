@extends('layouts.events')
@section('title', 'My Profile | ' . $user->fname . ' ' . $user->middlename . ' ' . $user->lname)
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
            @if ($user->avatar && $user->avatar)
            <a href="#" data-toggle="modal" data-target="#imageModal" title="Click to enlarge image">
                <img class="circular-profile-pic" style=" border: 1px solid black;" src="{{ asset($user->avatar) }}" alt="{{ $user->lname }} {{ $user->fname }} {{ $user->middlename }}">
            </a>
            @else
            <a href="#" data-toggle="modal" data-target="#imageModal" title="Click to enlarge image">
                <img class="circular-profile-pic" src="{{ asset('img/avatar/default-pfp.png') }}" alt="{{ $user->lname }} {{ $user->fname }} {{ $user->middlename }}">
            </a>
            @endif
        </div>

        <div class="profile-info">
            <div class="profile-box">
                <h1 style="font-weight:bold; color: black; text-transform: uppercase;">{{ $user->fname }} {{ $user->middlename }} {{ $user->lname }}</h1>
                <p style="color: black; font-size: 17px;">Email Address: {{ $user->email }}</p>
                <p style="color: black; font-size: 17px;">Sport: {{ $athlete->coach->sport->name }}</p>
            </div>
        </div>
    </div>

    <div class="profile-details" style="color: black; font-size: 17px;">
        @if (auth()->check() && auth()->user()->id === $user->id)
        <button class="useredit-button facebook-font btn btn-success" data-target="#usereditModal" data-toggle="modal" title="Edit About" style="float:right;">
            <i class="fas fa-edit"></i> Edit About
        </button><br>
        @endif

        <h2>About Me</h2>
        <p><b>Sex:</b> {{ $athlete->gender ?: 'N/A' }}</p>
        <p><b>Height:</b> {{ $athlete->height ? $athlete->height . ' m' : 'N/A' }}</p>
        <p><b>Weight:</b> {{ $athlete->weight ? $athlete->weight . ' kg' : 'N/A' }}</p>
        <p><b>BMI (Body Mass Index):</b> {{ $athlete->bmi ?: 'N/A' }}</p>
        <p><b>Birth Date:</b> {{ $athlete->birthdate ?: 'N/A' }}</p>
        <p><b>Blood Type:</b> {{ $athlete->blood_type ?: 'N/A' }}</p>
            <hr style="border: none; border-top: 1px dashed black;">
                <h2>Statistics</h2>
                    <!-- Content Row -->
                    <div class="row">

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                               Overall Task</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalMaterialCount }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                         Overall Checklist</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        {{-- Display the overall checklist count --}}
                        {{ $totalChecklists }}
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-list fa-2x text-gray-300"></i> {{-- Using a checklist icon --}}
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Rating Level Cards Example -->
@foreach($percentageByRating as $ratingLevel => $percentage)
    {{-- Skip rating level 0 --}}
    @if($ratingLevel != 0)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Rating Level {{ $ratingLevel }}</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{-- Display the percentage for the current rating level --}}
                                {{ number_format($percentage, 2) }}%
                            </div>
                        </div>
                        <div class="col-auto">
                            {{-- Replace this with the appropriate icon for the rating level --}}
                            @if($ratingLevel == 5)
                                <i class="fas fa-star fa-2x text-gray-300"></i>
                            @elseif($ratingLevel == 4)
                                <i class="fas fa-star-half-alt fa-2x text-gray-300"></i>
                            @elseif($ratingLevel == 3)
                                <i class="far fa-star fa-2x text-gray-300"></i>
                            @elseif($ratingLevel == 2)
                                <i class="far fa-star-half fa-2x text-gray-300"></i>
                            @elseif($ratingLevel == 1)
                                <i class="far fa-star fa-2x text-gray-300"></i>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach

<!-- Earnings (Monthly) Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Completion Rate</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                        {{-- Display the overall percentage --}}
                        {{ number_format($overallPercentage, 2) }}%
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-user fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
  <!-- Task Card Example -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Completed Tasks</div>
                    <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ number_format($percentageFilledChecklists, 2) }}</div>
                        </div>
                        <div class="col">
                            <div class="progress progress-sm mr-2">
                                <div class="progress-bar bg-info" role="progressbar"
                                    style="width: {{ $percentageFilledChecklists }}%" aria-valuenow="{{ $percentageFilledChecklists }}"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
        
    </div>
</div>

<!-- Modal for Image Zoom -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <button type="button" class="btn btn-secondary close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times; Close</span>
            </button>
            <div class="modal-body">
                @if ($user->avatar && $user->avatar)
                <img src="{{ asset($user->avatar) }}" alt="Profile Picture">
                @else
                <img src="{{ asset('img/avatar/default-pfp.png') }}" alt="{{ $user->lname }} {{ $user->fname }} {{ $user->middlename }}">
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
                <h5 class="modal-title" id="editModalLabel">Edit Profile Statistics</h5>
                <button type="button" class="btn btn-secondary close" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
    <form method="POST" action="{{ route('athlete-credentials',['id' => auth()->user()->id]) }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="profile_pic" class="form-label">Profile Photo</label>
            <input name="profile_pic" type="file" class="form-control" accept="image/*">
        </div>
        <div class="form-group">
            <label for="height">Height (in meters)</label>
            <input type="number" class="form-control" id="height" name="height" step="0.01" value="{{ $athlete->height }}" oninput="calculateBMI()">
        </div>
        <div class="form-group">
            <label for="weight">Weight (in kilograms)</label>
            <input type="number" class="form-control" id="weight" name="weight" step="0.01" value="{{ $athlete->weight }}" oninput="calculateBMI()">
        </div>
        <div class="form-group">
            <label for="bmi">BMI</label>
            <!-- Hidden input field to store BMI value -->
            <input type="hidden" id="bmiInput" name="bmi" value="{{ $athlete->bmi }}">
            <!-- Output element to display BMI -->
            <output class="form-control" id="bmiOutput" for="height weight">{{ $athlete->bmi }}</output>
        </div>
       <div class="form-group">
        <div class="form-group">
    <label>Birth Date:</label>
<input id="datePicker" type="date" class="form-control datetimepicker-input" data-target="#start_datetimepicker" name="ddate" placeholder="Click here to set the date and time" value="{{ $athlete->birthdate ? date('Y-m-d', strtotime($athlete->birthdate)) : '' }}" />

</div>
    </div>
        <div class="form-group">
            <label>Sex:</label>
            <select name="gender" class="form-control">
                <option disabled>Select Sex</option>
                <option {{ $athlete->gender === 'Male' ? 'selected' : '' }}>Male</option>
                <option {{ $athlete->gender === 'Female' ? 'selected' : '' }}>Female</option>
                {{-- <option {{ $athlete->gender === 'Others' ? 'selected' : '' }}>Others</option>
                <option {{ $athlete->gender === 'N/A' ? 'selected' : '' }}>N/A</option> --}}
            </select>
        </div>
        <div class="form-group">
            <label>Blood Type</label>
            <input class="form-control" type="text" name="bloodtype" maxlength="2" value="{{ $athlete->blood_type }}">
        </div>
    </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fa fa-times"></i>  Close</button>
                <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i>  Save Changes</button>
            </div>
            </form>
        </div>
    </div>
</div>


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

    // Function to calculate BMI and update the output element and hidden input field
    function calculateBMI() {
        // Get height and weight values from input fields
        var height = parseFloat(document.getElementById('height').value);
        var weight = parseFloat(document.getElementById('weight').value);

        // Check if both height and weight are valid numbers
        if (!isNaN(height) && !isNaN(weight) && height > 0 && weight > 0) {
            // Calculate BMI
            var bmi = weight / (height * height);

            // Round BMI to two decimal places
            bmi = bmi.toFixed(2);

            // Update output element to display BMI
            document.getElementById('bmiOutput').textContent = bmi;

            // Update hidden input field with BMI value
            document.getElementById('bmiInput').value = bmi;
        } else {
            // If either height or weight is not a valid number, clear BMI output and hidden input
            document.getElementById('bmiOutput').textContent = '';
            document.getElementById('bmiInput').value = '';
        }
    }
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
