@extends('layouts.coach')

@section('title', 'Concern from the Contact Us')

@section('content')
<style>
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
        color: black;
    }

    /* Alternate row color */
    .table tbody tr:nth-child(odd) {
        background-color: #f2f2f2;
    }
</style>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <!-- Navbar Brand (Logo) -->
    <a class="navbar-brand" href="javascript:void(0)" onclick="redirectToContactUS()" title="Contact Us List " style="color: green;"><b><h1>Concern from the Contact Us</h1></b></a>

    <!-- Navbar Toggler Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar Collapse Items -->
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a href="{{ route('download-concern') }}">
                    <button class="btn btn-secondary " style="margin:5px; float: right;" title="Download CSV">
                        <i class="fas fa-download"></i> Download CSV
                    </button>
                </a>  
            </li>            
            <li class="nav-item">
                <button class="btn btn-danger" style="margin:5px; float: right;" data-toggle="modal" data-target="#clearconcernsModal">
                    <i class="fas fa-trash"></i> Clear Record Logs
                </button>
            </li>
        </ul>
    </div>
</nav>
   
   <br>
    <div class="table-responsive">
        @if ($concerns->isNotEmpty())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>TimeStamp</th>
                </tr>
            </thead>
            <tbody>
                @php
                $startIndex = ($concerns->currentPage() - 1) * $concerns->perPage() + 1;
            @endphp
                @foreach ($concerns as $index => $user)
                <tr style="cursor: pointer;" title="Click to view" class="concern-row" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}" data-subject="{{ $user->subject }}" data-message="{{ $user->message }}" data-created-at="{{ $user->created_at->format('F j, Y h:i A') }} ({{ $user->created_at->diffForHumans() }})">
                    <td>{{ $startIndex + $index }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->subject }}</td>
                    <td>{{ $user->message }}</td>
                    <td>{{ $user->created_at->format('F j, Y h:i A') }} ({{ $user->created_at->diffForHumans() }})</td>
                </tr>

            @endforeach

            </tbody>
        </table>
        <div class="pagination-container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    Showing {{ $concerns->firstItem() }} to {{ $concerns->lastItem() }} of {{ $concerns->total() }} results
                </div>
                <ul class="pagination">
                    {{-- Pagination links --}}
                    {{ $concerns->links('vendor.pagination.custom', ['paginator' => $concerns]) }}
                </ul>
            </div>
        </div>        
    @else
        <p>No record found</p>
    @endif

   <!-- Concern Details -->
<div class="modal fade" id="concernModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel" style="color: black;">Concern Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeBtn">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="color: black;">
                <div class="form-group mb-3">
                    <h5 class="text-primary" style="text-transform: uppercase;" id="modal-subject"></h5>
                    <h6 class="modal-title" id="modal-name" style="text-transform: uppercase;"></h6>
                    <p id="modal-email"></p>
                    <em><p style="text-transform: uppercase;" id="modal-created-at"></p></em>
                </div>
                <div class="form-group mb-3">
                    <h5 id="modal-message"></h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" title="Close"><i class="fa fa-times"></i> </button>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteconcernModal" title="Delete Concern"><i class="fa fa-trash"></i> </button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#replyconcernModal" title="Reply Message"><i class="fa fa-reply"></i> </button>
                </div>
            </div>
        </div>
    </div>
</div>

      <!-- Reply Concern  -->
    <div class="modal fade" id="replyconcernModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel" style="color: black;">Concern Reply</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeButton">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="color: black;">
                    <form id="concernF" method="POST" action="{{ route('contact-us-reply') }}"> 
                        @csrf
                        <input type="hidden" name="concern_id" id="concern_id" value="">
                        <div class="form-group">
                            <label for="reply_message">Reply Message (it will send through their email)</label><br>
                            <textarea name="reply_message" id="reply_message" class="form-control" required placeholder="Type your reply message here.."></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="closeBtns" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button> 
                            <button type="submit" id="submitBtn"class="btn btn-primary" onclick="submitForm()"><i class="fa fa-send"></i>  Send</button> 
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
       <!-- Clear All Concern  -->
    <div class="modal fade" id="clearconcernsModal" tabindex="-1" role="dialog" aria-labelledby="verificationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verificationModalLabel" style="color: black;">Clear All Concerns Logs</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form  method="POST" action="{{ route('contact-clearlogz') }}">
                    @csrf
                    <div class="modal-body" style="color: black;">
                        <p>Are you sure you want to clear all the records? <br><br><b>Once it deleted, it cannot be undone.</b> </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                        <button type="submit" class="btn btn-danger"><i class="fa fa-check"></i> Confirm</button>
                    </div>
                </form> 
            </div>
        </div>
    </div>   

       <!-- Delete Concern  -->
    <div class="modal fade" id="deleteconcernModal" tabindex="-1" role="dialog" aria-labelledby="verificationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verificationModalLabel" style="color: black;">Delete  Concerns </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('contact-deletez') }}">
                    @csrf
                    @method('delete')
                    <div class="modal-body" style="color: black;">
                        <input type="hidden" name="concernID" id="concernIDz" value="">
                        <p>Are you sure you want to delete this  concern record? <br><br><b> It cannot be undone.</b> </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                        <button type="submit" class="btn btn-danger"><i class="fa fa-check"></i> Confirm</button>
                    </div>
                </form> 
            </div>
        </div>
    </div>   
   
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.concern-row').click(function() {
            var concernId = $(this).data('id');

            $.ajax({
                url: '/fetch-concern/' + concernId,
                method: 'GET',
                success: function(response) {
                    // Parse the date string into a Date object
                    var createdAtDate = new Date(response.created_at);

                    // Define an array of month names
                    var monthNames = [
                      "January", "February", "March",
                      "April", "May", "June", "July",
                      "August", "September", "October",
                      "November", "December"
                    ];

                    // Get the month, day, year, hours, and minutes
                    var month = monthNames[createdAtDate.getMonth()];
                    var day = createdAtDate.getDate();
                    var year = createdAtDate.getFullYear();
                    var hours = createdAtDate.getHours();
                    var minutes = createdAtDate.getMinutes();

                    // Convert hours to 12-hour format
                    var ampm = hours >= 12 ? 'PM' : 'AM';
                    hours = hours % 12;
                    hours = hours ? hours : 12; // Handle midnight (0 hours)

                    // Add leading zeros to minutes if needed
                    minutes = minutes < 10 ? '0' + minutes : minutes;

                    // Construct the formatted date string
                    var formattedDate = month + ' ' + day + ', ' + year + ' ' + hours + ':' + minutes + ' ' + ampm;

                    // Set the formatted date string to the modal element
                    $('#modal-created-at').text('Sent: ' + formattedDate);

                    // Set other modal fields
                    $('#modal-name').text('Name: ' + response.name);
                    $('#modal-email').text('Email: ' + response.email);
                    $('#modal-subject').text('Subject: ' + response.subject);
                    $('#modal-message').text('Message: ' + response.message);
                    $('#concern_id').val(response.id);
                    $('#concernIDz').val(response.id);
                    $('#concernModal').modal('show'); 
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    });

    function disableButtons() {
            // Disable all buttons in the modal
           
            document.getElementById('submitBtn').disabled = true;
            document.getElementById('closeBtns').disabled = true;
            document.getElementById('closeButton').disabled = true;
    }
    
    function submitForm() {
            // Show loading message
            toastr.info('Please wait for a while. Don\'t cancel the process. Notifying the person via email...');
    
            // Disable all buttons to prevent multiple submissions
            disableButtons();
    
            // Submit the form
            document.getElementById('concernF').submit();
        }
</script>  

 @endsection