<!DOCTYPE html>

<head>
	<title> CityPie </title>
	<link rel = "stylesheet" type="text/css" href = "css/reset.css">
	<link rel = "stylesheet" type="text/css" href = "css/master.css">
	<link rel="icon" type="image/x-icon" href="favicon.png">
	<link href='http://fonts.googleapis.com/css?family=Grand+Hotel' rel='stylesheet' type='text/css'>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="/js/jquery.cookie.js"></script>
	<style type="text/css">
		body {
			color: rgb(65,65,65);
		}
		
	</style>
	<script  type="text/javascript">
	$(document).ready(function(){
		$('#newuser').submit(function(e){
			e.preventDefault();
			$('#errors').hide();
			$('#notices').hide()
			$.ajax({
				'type' : 'POST', 
				'url' : '/api/1.0/users', 
				'data' : $("#newuser").serialize(), 
				'success' : function(data, textStatus, jqXHR){
					$.cookie('user_id', data['data']['id']);
					window.location = '/';
				}, 
				'error' : function (jqXHR, textStatus, errorThrown) {
					var response = jQuery.parseJSON(jqXHR.responseText);
					$('#errors').html(response.errors.join('<br>'));
					$('#errors').show();
				}
			});
		});
	});
	</script>
</head>
<body>
  <div id="wrapper">
  	<div id="errors"></div>

	<h2>Sign Up</h2>

	<form method="post" id="newuser" class="fform">
		
		<label for="name">Name</label>
		<input type="text" name="name" id="name" value="">
		
		<label for="email">Email Address</label>
		<input type="text" name="email" id="email" value="">
		
		<label for="password">Password</label>
		<input type="password" name="password" id="password" value="">
		
		<input type="submit" value="Sign Up">
		
	</form>
		
  </div>
</body>
</html>