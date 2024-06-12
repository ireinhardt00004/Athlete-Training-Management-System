<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="icon" type="x/icon" href="{{ asset('assets/img/favicon.ico')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('home/css/login.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsVWvDpOsZZP+aiC50FqFReDhG2B1fFzEPuT1L8Lq2" crossorigin="anonymous">

</head>
<body>
 @include('preloader')
    <main>
    <div class="form">
       
      <form method="POST" action="{{ route('login') }}">
         <a href="/" title="Return to Home page"><img id="logo" class="img-fluid" src="{{ asset('assets/img/runner.png') }}"></a>
         <center><label class="mb-3 text-center">Sign in Your Account</label></center><br>
        @csrf
        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            @error('email')
                <div class="alert alert-danger mt-2" style="color: red;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">{{ __('Password') }}</label>
            <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" />
            @error('password')
                <div class="alert alert-danger mt-2" style="color:red;">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="mb-3 form-check" id="remember-me">
            
           
        <input id="remember-me" type="checkbox" class="form-check-input" name="remember" style="width:15px; height: 20px;">
         <label for="remember-me"  class="form-check-label" style="font-size: 12px;">'Remember my Preference </label>
        </div>
        <br>
       
        <div>
            <button type="submit" class="btn btn-primary btn-block">{{ __('Sign in') }}</button>
        </div><br>
         <div class="mb-3 text-center">
            @if (Route::has('password.request'))
                <a class="text-sm text-gray-600" href="{{ route('password.request') }}" style="text-decoration: none;">
                  <center>  {{ __('Forgot your password?') }}</center>
                </a>
            @endif     
        </div><br>
         <!--<div class="mb-3">
                Don't have an account?
                <a class="text-sm text-gray-600" href="{{-- route('password.request') --}}">Sign up
                </a>              
        </div>-->
    </form>
    </div>
</main>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-OBqDVmMz9ATKxIep9tiCxS/Z9fNfEX3n2gceWqX3oww8J0q2tU/J3RMpcc7AVgFJ" crossorigin="anonymous"></script>


     <script type="text/javascript">
        function checkPasswordMatch() {
  var password = document.getElementById("password");
  var confirm_password = document.getElementById("confirm-password");
  var password_match_msg = document.getElementById("password-match-msg");

  if (password.value != confirm_password.value) {
    password_match_msg.innerHTML = "Passwords do not match";
  } else {
    password_match_msg.innerHTML = "";
  }
}
     </script>

</body>
</html>