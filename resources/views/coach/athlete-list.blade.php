@extends('layouts.coach')
@section('content')
<style>
    .nav {
        font-size: 20px;
        font-family:   sans-serif;
    }
    table {
        font-size: 20px;
        font-family:  sans-serif;
    }
</style>
 <div>
    <div class="nav" style="margin-top: 20px;">
    <ul class="nav nav-tabs" style="background-color: #f8f9fa; border-radius: 8px; padding: 10px;">
        <li class="nav-item">
            <a class="nav-link " aria-current="page" href="{{ route('class-page', ['sport_id' => $sport->id]) }}" style="color: #333;  font-size: 16px;">{{ $sport->name }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " aria-current="page" href="{{ route('event.index', ['sport_id' => $sport->id]) }}" style="color: #333;  font-size: 16px;">{{ $sport->name }} Schedule Calendar</a>
        </li>
        @auth
        @if (auth()->user()->hasRole('coach') || auth()->user()->hasRole('admin'))
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ route('athletelist', ['id' => $sport->id]) }}" style="color: #333; font-size: 16px; font-weight: bold;">List of Athletes</a>
        </li>
       
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false" style="color: #333; font-size: 16px;"><i class="fa fa-cog"></i> Settings</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" data-toggle="modal" data-target="#customizeModal" style="font-size: 14px;"></a></li>
            </ul>
        </li>
        @endif
        @endauth
    </ul>
</div>
 <br>
 			<!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">List of Athletes</h1>
 				{{--<a href="{{ route('export.athletes') }}" class="btn btn-secondary" style="margin:5px;">
                <i class="fa fa-download"></i> Export as CSV</a>
              --}}
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"> </h6>
                        </div>
                        <div class="card-body">
                            <button class="btn btn-info" type="button" style="float:right; margin:5px;" data-target="#addAthleteModal" data-toggle="modal"><i class="fas fa-plus"></i><i class="fas fa-user"></i>  Register Athlete</button>
                            <div class="table-responsive">
                        <span><b>Note: </b>Allowed Number of Athletes <b>{{ $coach->sport->number_of_athlete_allowed }}</b></span> 
                        <div class="table-responsive">
                            
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                
                                <thead>
                                    <tr>
                                        <th>Student #</th>
                                        <th>Name</th>
                                        <th>Email Address</th>
                                        <th>Last Login</th>
                                        <th colspan="2">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($athletes->isEmpty())
                                        <tr>
                                            <td colspan="4">No athletes available</td>
                                        </tr>
                                    @else
                                        @foreach($athletes as $athlete)
                                            <tr>
                                                <td>{{ $athlete->user->student_num }}</td>
                                                <td>
                                                    @if ($athlete->user->avatar)
                                                        <img class="img-profile rounded-circle" src="{{ asset($athlete->user->avatar) }}" style="width:40px; height: 35px;">
                                                    @else
                                                        <img class="img-profile rounded-circle" src="{{ asset('assets/img/default-pfp.png') }}">
                                                    @endif
                                                    {{ $athlete->user->fname }} {{ $athlete->user->middlename }} {{ $athlete->user->lname }}
                                                </td>
                                                <td>{{ $athlete->user->email }}</td>
                                                <td>
                                                    @if($athlete->user && $athlete->user->visit)
                                                        {{ $athlete->user->visit->logout }}
                                                    @else
                                                        No logout data available
                                                    @endif
                                                </td>
                                                <td>
                                                    <!-- Button to visit profile -->
                                                    <a href="{{ route('my-profile', ['id' => $athlete->user->id]) }}" class="btn btn-success" title="Visit Profile">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <!-- Button to trigger delete modal -->
                                                    <button class="btn btn-danger" data-toggle="modal" data-target="#deleteAthleteModal{{ $athlete->id }}" title="Delete">
                                                        <i class="fa fa-trash"></i> 
                                                    </button>
                                                </td>
                                            </tr>


  <!-- Delete Confirmation Modal -->
  <div class="modal fade" id="deleteAthleteModal{{ $athlete->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteAthleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAthleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('delete.athleteAccount', ['id' => $athlete->id]) }}">
                    @csrf
            <input type="hidden" name="_method" value="DELETE">
                    Are you sure you want to delete this athlete?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                <!-- Pass the user's ID to the delete function in your controller -->
                <button type="submit"  class="btn btn-danger"><i class="fa fa-check"></i> Delete</button>
                </form>
            </div>
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


<!-- add Athlete Modal-->
<div class="modal fade" id="addAthleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel" style="color:black">Add athlete</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
       <form method="POST" action="{{ route('register.athlete') }}">
        @csrf
        <div class="form-group">
            <label style="color:black;">Student Number</label>
            <input type="text" class="form-control bg-light border-0 small" placeholder="0000-000-000" name="student_num" required 
            aria-label="" aria-describedby="basic-addon2">
        </div> 
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
        <div class="form-group">
            <label style="color:black;">Additional Details</label>
        <h6 style="color: black;">Coach {{$coach->user->fname}} of <b>{{$sport->name }}</b></h6>
        <input type="hidden" class="form-control bg-light border-0 small" placeholder="" name="coach_id" value="{{$coach->id}}" required
            aria-label="" aria-describedby="basic-addon2">
            <hr>
        {{-- <select class="form-control bg-light border-0 small" name="coach_id" required>
            <option value="" selected disabled>Select Coach</option>
            <!-- Options will be dynamically populated using JavaScript -->
        </select> --}}
        </div>
         </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
           <button type="submit" class="btn btn-primary" style="background-color:green;">Register</button>
        </div>
    </form>
    </div>
</div>
</div>


     <!-- Deleting All  Modal -->
<div class="modal fade" id="clearAllModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirm Deletion of all athletes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('clearall.log') }}">
                    @csrf
                    <input type="hidden" name="_method" value="DELETE">
                    Are you sure you want to delete all activity athletes?
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
@section('title','List of Athletes |  '.$sport->name)