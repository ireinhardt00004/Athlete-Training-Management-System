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
                        <div class="card-header py-3">
                             <a href="{{ route('add.adminindex') }}"><h1 class="h3 mb-2 text-gray-800">List of Admin</h1></a>
                            <a href="#"data-toggle="modal" data-target="#adduserModal"><button class="btn btn-success" style="margin:5px; float:right;"><i class="fa fa-user"></i><i class="fa fa-plus"></i> Add Admin</button></a>
                            <a href="{{ route('export.admins') }}"><button class="btn btn-secondary" style="margin:5px; float: right;"><i class="fa fa-download"></i> Export as CSV</button></a> 
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
							    <thead>
							        <tr>
							        	<th>ID</th>
							            <th>FullName</th>
                                        <th>Email Address</th>
							            <th colspan="2" >Action</th>
                                       
							        </tr>
							    </thead>
							 <tbody>
							 @if($admins->isEmpty())
							     <tr>
							     <td colspan="4">No another admin data available</td>
							     </tr>
							 @else
						@foreach($admins as $user)
                        <tr>
                    <td>{{ $user->id }}</td>
                    <td>
                    @if ($user->avatar)   
                    <img class="img-profile rounded-circle" src="{{ asset($user->avatar) }}" style="width:20px; height: 25px;">    
                        @else
                    <img class="img-profile rounded-circle" src="{{ asset('assets/img/default-pfp.png') }}">
                    @endif
        {{ $user->fname }} {{ $user->lname }}</td>
        <td>{{ $user->email }}</td>
        <td > 
            <!-- Button to trigger the confirmation modal -->
            <button class="btn btn-danger" title="Remove user" data-toggle="modal" data-target="#confirmationModal{{ $user->id }}">
                <i class="fa fa-trash"></i>
            </button>
        </td>
    </tr>
 
    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmationModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirm Deletion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('delete.admin', ['id' => $user->id]) }}">
                        @csrf
                <input type="hidden" name="_method" value="DELETE">
                        Are you sure you want to delete this admin?
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


<!-- add Admin Modal-->
    <div class="modal fade" id="adduserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="color:black">Add Admin</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
               <form method="POST" action="{{ route('add.admin') }}">
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
                <button class="btn btn-secondary" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                   <button type="submit" class="btn btn-primary" style="background-color:green;"><i class="fa fa-plus"></i> Register</button>
                </div>
            </form>
            </div>
        </div>
    </div>


<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


    
@endsection
@section('title', 'Add Admin')