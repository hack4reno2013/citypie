<!DOCTYPE html>

<head>
	<meta charset="UTF-8">
	<title> CityPie </title>
	<link rel = "stylesheet" type - "text/css" href = "css/reset.css" />
	<link rel = "stylesheet" type = "text/css" href = "css/master.css" />
	
	<link rel="icon" type="image/x-icon" href="favicon.png">
	
	<link href='http://fonts.googleapis.com/css?family=Grand+Hotel' rel='stylesheet' type='text/css'>
	
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script>
	function Sign_up() {
		$.ajax({
			type: "POST",
			url: "/stuff/Login/Signup_Signin.php",
			data: { REQUEST: "Sign_up" },
			success: function(data){
				$("#right").html(data).show();
			}
		});
	};
	function Sign_in() {
		$.ajax({
			type: "POST",
			url: "/stuff/Login/Signup_Signin.php",
			data: { REQUEST: "Sign_in" },
			success: function(data){
				$("#right").html(data).show();
			}
		});
	};
	
	$(document).ready(function(){
		$("#signup_button").click(function(){
			Sign_up();
		});
		$("#login_button").click(function(){
			Sign_in();
		});
	});
	</script>
	
</head>

<body>
  <div id="wrapper">
	<div id="left">
		<p id="landing_text">
			<span id="welcome">Welcome!</span><br>
			What needs to be done in your city? CityPie is a place to compile the slices of life in your town. <br><br>

			Whether you're a local or a visitor, CityPie helps people scratch the surface of cities or dive deep into the history and culture of an area. <br><br>

			Earn badges and compete with your friends along the way as you get to know your city better!! <br><br>
			
			Create a free account today!!
		</p>
	</div>
	<div id="right">
		<img src="http://citypie.us/images/CityPie_logo_landing.png"/>
		<span id="buttons">
			<div class="button_short" id="signup_button">Sign Up</div>
			<div class="button_short" id="login_button">Login</div>
		</span>
	</div>
  </div>
</body>