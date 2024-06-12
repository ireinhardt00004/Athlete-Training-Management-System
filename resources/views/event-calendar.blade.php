@extends('layouts.events')
@section('content')
<style> 
    .nav {
        font-size: 20px;
        font-family:   sans-serif;
    }
    #calendar {
        width: 100%;
        margin: 0 auto;
    }

    .modal-dialog {
        max-width: 600px;
    }

    .modal-content {
        padding: 20px;
    }

    input {
        height: 10px;
        margin-bottom: 10px;
    }
    #create-event-btn {
    font-size: 18px;
    width: auto;    
    }

    /* Responsive styles */
    @media (max-width: 768px) {
        #calendar {
            width: 90%;
            margin: 0 auto;
        }

        .modal-dialog {
            max-width: 90%;
        }

        .modal-content {
            padding: 10px;
        }
    }
</style>
<div class="nav" style="margin-top: 20px;">
    <ul class="nav nav-tabs" style="background-color: #f8f9fa; border-radius: 8px; padding: 10px;">
        <li class="nav-item">
            <a class="nav-link " aria-current="page" href="{{ route('class-page', ['sport_id' => $sport->id]) }}" style="color: #333;  font-size: 16px;">{{ $sport->name }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{ route('event.index', ['sport_id' => $sport->id]) }}" style="color: #333; font-weight: bold;  font-size: 16px;">{{ $sport->name }} Schedule Calendar</a>
        </li>
        @auth
        @if (auth()->user()->hasRole('coach') || auth()->user()->hasRole('admin'))
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="{{ route('athletelist', ['id' => $sport->id]) }}" style="color: #333; font-size: 16px;">List of Athletes  |  {{ $sport->name }}</a>
        </li>
       
        @endif
        @endauth
    </ul>
</div>
<br>
<!-- Calendar Container -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <button id="create-event-btn" class="btn btn-success btn-block mb-3" data-toggle="modal" data-target="#createEventModal" title="Click to create event">
                <i class="fas fa-calendar-plus"></i> Create Event Task
            </button>
        </div> 
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="calendar-container">
                <!-- FullCalendar -->
                <div id='calendar'></div>
            </div>
        </div>
    </div>
</div>

            
        <!-- Create Event Modal -->
<div class="modal fade" id="createEventModal" tabindex="-1" role="dialog" aria-labelledby="createEventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="createEventModalLabel">
                    <i class="fas fa-calendar-plus"></i> Create Event Task
                </h5>
                <button type="button" class="close text-black" data-dismiss="modal" aria-label="Close" title="Close" id="closeButtons">
                    <span aria-hidden="true"><i class="fa fa-times" ></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('event.store', ['sport_id' => $sport->id]) }}" method="POST" id="create-eventForm">
                    @csrf
                    <div class="form-group">
                        <label for="title"><i class="fas fa-heading"></i> Task Title:</label>
                        <input type="text" class="form-control" name="title" placeholder="Enter the title of the Task">
                    </div>
                    <div class="form-group">
                        <label for="description"><i class="fas fa-file-alt"></i> Task Description:</label>
                        <textarea class="form-control" placeholder="Provide Description" name="description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="priority"><i class="fas fa-users"></i> Task Priority</label>
                        <select class="form-control" name="priority" required>
                            <option value="URGENT">High</option>
                            <option value="NORMAL">Low</option>
                        </select>
                    </div>
                    <span style="color: red;"><b>Note:</b> It is required to specify the Date and Time (12-hour Format) of the Event</span>

                    <div class="form-group">
                        <label for="start_datetime"><i class="fas fa-calendar-alt"></i> Start Date and Time:</label>
                        <div class="input-group date" id="start_datetimepicker" data-target-input="nearest">
                            <input id="datePicker" type="datetime-local" class="form-control datetimepicker-input" data-target="#start_datetimepicker" name="start_date" placeholder="Click here to set the date and time" required />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="end_datetime"><i class="fas fa-calendar-alt"></i> End Date and Time:</label>
                        <div class="input-group date" id="end_datetimepicker" data-target-input="nearest">
                            <input id="datePicker" type="datetime-local" class="form-control datetimepicker-input" data-target="#end_datetimepicker" name="end_date" placeholder="Click here to set the date and time" required />
                        </div>
                    </div>
                    @auth
                     @if (auth()->user()->hasRole('coach') || auth()->user()->hasRole('admin'))
                    <div class="form-group">
                        <label for="notify_members">Notify  via Email (Optional)</label>
                        <input type="checkbox" name="notify_athletes" id="notify_athletes" value="" style="height:20px; width:30px;">
                    </div>
                    @endif @endauth
                    <div class="modal-footer">
                        <button type="button" id="closeBtn" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                        <button type="submit"id="submitBtn" class="btn btn-primary"><i class="fas fa-upload"></i> Save Event Task</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Event Details Modal -->
<div class="modal fade" id="eventDetailsModal" tabindex="-1" role="dialog" aria-labelledby="eventDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="eventDetailsModalLabel">
                    <i class="fas fa-info-circle"></i> Task Details
                </h5>
                <button type="button" class="close text-black" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-justify" style="font-size: 25px;">
                <!-- Event details content -->
                ${eventDetails}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>

    <!-- Modal for deleting an event -->
    <div class="modal fade" id="deleteEventModal" tabindex="-1" role="dialog" aria-labelledby="verificationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verificationModalLabel">Delete Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{ route('events.destroy') }}">
                    @csrf
                    <div class="modal-body">
                        <p>Are you sure you want to delete this event? <br><br><b>Once it deleted, it cannot be undone.</b> </p>
                        <input type="hidden" name="event_id" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fas fa-times"></i> Cancel</button>
                        <button type="submit" class="btn btn-danger"> <i class="fas fa-check"></i> Confirm</button>
                    </div>
                </form> 
            </div>
        </div>
    </div>   
    <!-- Include FullCalendar JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.10.1/main.min.js"></script>

<!-- FullCalendar Initialization -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            // Calendar options here
            initialView: 'dayGridMonth', // Example initial view
            events: {!! json_encode($formattedEvents) !!}, // Pass formatted events here
            eventClick: function(info) {
                // Handle event click here
            }
        });
        calendar.render(); // Render the calendar
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            // Calendar options here
            initialView: 'dayGridMonth', // Example initial view
            events: {!! json_encode($formattedEvents) !!}, // Pass formatted events here
            eventClick: function(info) {
                var event = info.event;
                var eventDetails = `
                <p><strong>Task Title:</strong> ${event.title}</p>
                <p><strong>Task Description:</strong> ${event.extendedProps.desc}</p>
                <p><strong>Task Start Date:</strong> ${formatDate(event.start)}</p>
                <p><strong>Task End Date:</strong> ${formatDate(event.end)}</p>
                <p><strong>Task Priority:</strong> ${event.extendedProps.prior}</p>
                <p><strong>Task Author:</strong> ${event.extendedProps.author}</p> <!-- Access the author property -->
                `;

                eventDetails += `             
                        <button id="deleteEventBtn" style="float:right;" type="button" class="btn btn-danger" data-event-id="${event.id}"> <i class="fas fa-trash"></i> Delete Event</button>
                `;

                $('#eventDetailsModal .modal-body').html(eventDetails);
                $('#eventDetailsModal').modal('show');
            }
        });

        calendar.render();

        $(document).on('click', '#deleteEventBtn', function(e) {
            e.preventDefault();

            // Get the event ID
            var eventId = $(this).data('event-id');

            // Set the value of the input field in the delete event modal
            $('#deleteEventModal input[name="event_id"]').val(eventId);

            // Open the delete event modal
            $('#deleteEventModal').modal('show');
        });

        // Function to format date
        function formatDate(date) {
            if (!date) return ''; // Check if date is null or undefined

            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', hour12: true };
            return date.toLocaleString('en-US', options);
        }

        flatpickr("#datePicker", {
            enableTime: true, // Enable time selection
            dateFormat: "Y-m-d H:i", // Format for display
        });
    });
</script>

<script>
    // Check for the flash message and display it
    @if(session('status'))
        toastr.success('{{ session('status') }}');
    @endif
</script>
<script>
    function disableButtons() {
        // Disable all buttons in the modal
       
        document.getElementById('submitBtn').disabled = true;
        document.getElementById('closeBtn').disabled = true;
        document.getElementById('closeButtons').disabled = true;
    }

    function submitForm() {
        // Show loading message
        toastr.info('Please wait for a while. Don\'t cancel the process. Notifying users via email...');

        // Disable all buttons to prevent multiple submissions
        disableButtons();

        // Submit the form
        document.getElementById('create-eventForm').submit();
    }
</script>

@endsection
@section('title', 'Task Calendar')