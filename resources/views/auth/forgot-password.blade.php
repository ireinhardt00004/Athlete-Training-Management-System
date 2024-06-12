
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password</title>
    <link rel="icon" type="x/icon" href="{{ asset('assets/img/favicon.ico')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('home/css/login.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsVWvDpOsZZP+aiC50FqFReDhG2B1fFzEPuT1L8Lq2" crossorigin="anonymous">

</head>
<body>
   @include('preloader') 
    <main>
    <div class="form">

 

    <form method="POST" action="{{ route('password.email') }}">
         <a href="/"><img id="logo" class="img-fluid" src="{{ asset('assets/img/runner.png') }}"></a>
         <center><label class="mb-3 text-center">Forgot Password</label></center><br>
         <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>
                <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" style="color:green;" />
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2"  style="color:red"/>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
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