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

		<main>
			<div class="form">
     <form action="" method="post">
     	<img class="img-fluid" id="logo" src="assets/img/CVSU-LOGO.png">
     	@csrf
     	<h2>Sign in your Account</h2>
     <div class="form-group">
		  <label>Email Address</label>
		  <input type="Email" name="email" required>
		</div>
		<div class="form-group">
		  <label>Password</label>
		  <input type="password" id="password" name="password"  required>
		</div>
		<div class="form-group remember-me">
		  <input type="checkbox" id="remember-me">
		  <label for="remember-me">Remember Me</label>
		</div>
		<div class="form-group"><button class="btn btn-secondary" type="submit">Sign In</button>
		</div>
			<div class="form-group">
				Don't have an account? <a href="#">Sign up </a>
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