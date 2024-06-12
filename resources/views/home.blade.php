<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="x/icon" href="{{ asset('assets/img/favicon.ico')}}">
    <title>CvSU Athlete Training Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
</head>
<body class="overflow-hidden" style="height: 100vh; width:100%;" >

<nav id="NavBar" class="container z-3">
    <div class="row">
        <div class="col d-flex justify-content-start align-items-center p-2">
            <h1 class="h4 fs-4 pla"><a href="/" class="text-decoration-none text-black"><span class="text-success">CvSU </span>Athlete Training Management</a></h1>
        </div>
        <div class="col d-flex justify-content-end d-sm-flex text-center p-2">
            <ul class="navbar-nav">
                
                <li class="ms-auto nav-item fs-5 fs-sm-2 d-flex justify-content-between align-items-center gap-4">
                   <a class="nav-link" href="#" data-toggle="modal" data-target="#contactUsModal" >Contact Us</a>
                    @if (Route::has('login'))
                    @auth
                    @php
                    $dashboardLink = '';
                    switch(auth()->user()->roles) {
                        case 'admin':
                            $dashboardLink = url('/admin-dashboard');
                            break;
                        case 'coach':
                            $dashboardLink = url('/coach-dashboard');
                            break;
                        case 'user':
                            $dashboardLink = url('/dashboard');
                            break;
                        default:
                            $dashboardLink = url('/dashboard');
                    }
                    @endphp
                    <a class="nav-link" aria-current="page" href="{{ $dashboardLink }}"> <img src="{{ asset(Auth::user()->avatar) }}"  alt="man" style="height: 42px; width:42px; border-radius: 50%;" title="Return to Dashboard"></a>
                    @else
                    <a class="nav-link" aria-current="page" href="{{ route('login') }}" >Log in</a>
                    @endauth @endif
                    
                </li >
               
            </ul>
        </div>
    </div>
</nav>

<main class="container-fluid scrollspy-example overflow-y-auto" style="height: calc(100vh - 56px);" data-bs-spy="scroll" data-bs-target="#NavBar" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true">
    <div class="row align-items-center" style="height: 100%">
        <div class="col-lg-6">
            <div id="Home" class="d-flex justify-content-center align-items-center flex-column h-100 p-2">
                <h1 class="h1 text-success mb-4">Achieve Your Athletic Goals Together!</h1>
                <p class="fs-4 w-75 text-wrap">Welcome to our comprehensive training platform designed for coaches and athletes alike. Whether you're looking to improve performance, track progress, or streamline communication, our user-friendly system has you covered. Let's work together towards success!</p>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="d-flex justify-content-center align-items-center flex-column h-100 p-2">
                <img src="{{ asset('assets/img/runner.png') }}" class="img-fluid" style="height:70%; width:70%;" alt="">
            </div>
        </div>
    </div>

 <!-- Contact US Modal -->
<div class="modal fade" id="contactUsModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Send a Concern</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <form method="post" action="{{ route('submit-concern') }}" >
                   @csrf
                    <div class="row">
                        <h3></h3>
                        <div class="col form-group">
                            <input type="text" name="name-con" id="full_name" class="form-control"  placeholder="Your Name" required>
                        </div>
                        <div class="col form-group">
                            <input type="email" class="form-control"  name="email-con" id="email-con" placeholder="Your Email" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" name="phone-con" id="con-phone" placeholder="Enter Phone Number" class="form-control"  required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="subject-con" id="con-subject" placeholder="Subject" required>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control"name="message-con" id="con-message" rows="5" placeholder="State your concern here..."  required></textarea>
                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                <!-- Pass the user's ID to the delete function in your controller -->
                <div class="text-center"><button class="btn btn-success" style="background-color: green; float: right; margin:10px; color:white;" type="submit" onclick="submitConcernF()">
                    <i class="fas fa-envelope"></i>  Send Message</button></div>
                </form>
            </div>
        </div>
    </div>
</div>

</main>

<!-- Footer -->
 <footer class="sticky-footer bg-white fixed-bottom">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span id="currentYearSpan"></span>
            <script>
                // Get the current year
                var currentYear = new Date().getFullYear();
                // Set the current year in the span element
                document.getElementById("currentYearSpan").innerHTML = currentYear;
            </script>
             <span> Copyright &copy; <a href="/" style="text-decoration:none; color:green;"> CvSU Athlete Training Management System</a></span>
        </div>
    </div>
</footer>

 <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    // Check for the flash message and display it
    @if(session('success'))
        toastr.success('{{ session('success') }}', 'Success', { "timeOut": 5000, "extendedTimeOut": 1000, "positionClass": "toast-top-right", "closeButton": true, "progressBar": true });
    @endif

    @if(session('status'))
        toastr.success('{{ session('status') }}', 'Success', { "timeOut": 5000, "extendedTimeOut": 1000, "positionClass": "toast-top-right", "closeButton": true, "progressBar": true });
    @endif

    @if(session('error'))
        toastr.error('{{ session('error') }}', 'Error', { "timeOut": 5000, "extendedTimeOut": 1000, "positionClass": "toast-top-right", "closeButton": true, "progressBar": true });
    @endif

    // Display validation errors
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            toastr.error('{{ $error }}', 'Validation Error', { "timeOut": 5000, "extendedTimeOut": 1000, "positionClass": "toast-top-right", "closeButton": true, "progressBar": true });
        @endforeach
    @endif

    function submitConcernF() {
    // Show loading message with green background
    toastr.options = {
        "positionClass": "toast-top-right",
        "timeOut": "15000",
        "extendedTimeOut": "0",
        "tapToDismiss": false,
        "closeButton": true,
        "progressBar": true,
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
        "preventDuplicates": true,
        "progressBar": true,
        "background-color": "#4CAF50" // Green background color
    };

    toastr.info('Please wait for a while. Don\'t cancel the process. Notifying the Admin via email...');

    // Submit the form after a short delay
    setTimeout(function() {
        document.getElementById('concernF').submit();
    }, 15000); // You can adjust the delay time as needed
}

</script>

</body>
</html>
