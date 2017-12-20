<?php
	session_start();		
	if(!empty($_SESSION["user_id"]))
	{
		echo '<script>window.location.href="./home.php";</script>';
	}
			
?>
<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Yon</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="https://use.fontawesome.com/1685ebbb24.js"></script>
		<link href="./css/style-index.css" rel="stylesheet">
		<script type="text/javascript" src="./js/script-index.js"></script>
	</head>
	<body>	
		
		<div class="container-fluid header">
			<div class="row" data-spy="affix" data-offset-top="70" style="padding-top: 10px; padding-bottom: 10px;">
				<div class="col-sm-1"></div>
				<div class="col-sm-4" id="logo"><img src="img/CKrJW_3UYAAYwRO.png"></div>
				<div class="col-sm-2"></div>
				<div class="col-sm-4 log-reg">
						<a href="#form-nav-to" class="btn" onclick="openChat()">Anonymous Chat</a>
						<a href="#form-nav-to" class="btn" id="login-header">Login</a>
						<a href="#form-nav-to" class="btn" id="reg-header">Register</a>
				</div>
				<div class="col-sm-1"></div>
			</div>
		</div>
			
		<div class="hero">
			<h1>Connect, learn and innovate</h1>
			<h4>Trying to learn something new? There are thousands in your rank and many more to help you out.</h4>
			<a href="" id="hero-button">KNOW MORE</a>
			<div name="form-nav-to" id="form-nav-to" style="position:absolute; bottom:70px;"></div>
		</div>
			
		<div class="container" style="margin-top: 50px;">
			<div class="row">
				<div class="col-sm-1 col-md-2 col-lg-3"></div>
				<div class="col-sm-10 col-md-10 col-lg-6">
					<ul class="nav nav-tabs">
							<li class="active" id="login-tab"><a data-toggle="tab" href="#logintab">Login</a></li>
							<li id="reg-tab"><a data-toggle="tab" href="#registertab">Register</a></li>
					</ul>
						
					<div class="tab-content" style="padding: 20px;">
						<div id="logintab" class="tab-pane fade in active">
							
							<form method="post" id="login-form">
								<legend>Login to your account</legend>
								<span id="log-info"></span>
								<div class="form-group">
									<label>Email</label>
									<input type="email" class="form-control" id="logemail" name="logemail" placeholder="Email" autocomplete="on" required>
								</div>
								<div class="form-group">
									<label>Password</label>
									<input type="password" class="form-control" id="logpass" name="logpass" placeholder="Password" autocomplete="off" required>
									<span id="login-info"></span>
								</div>
								<button type="submit" class="btn btn-primary btn-lg" style="margin-top: 15px;" id="login-btn">Sign In</button>
							</form>

						</div>    
						
						<div  id="registertab" class="tab-pane fade">
							<form method="post" id="reg-form">
								<legend>Create your account</legend>
								<span id="reg-info"></span>
								<div class="form-group">
									<label>Email</label>
									<input type="email" class="form-control" id="email" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" placeholder="Email" autocomplete="off" required>
								</div>
								<div class="form-group">
									<label>First Name</label>
									<input type="text" class="form-control" id="firstname" maxlength="25" name="firstname" placeholder="First Name" value="<?php if(isset($_POST['firstname'])) echo $_POST['firstname']; ?>" autocomplete="on" required>
								</div>
								<div class="form-group">
									<label>Last Name</label>
									<input type="text" class="form-control" id="lastname" maxlength="25" name="lastname" placeholder="Last Name" value="<?php if(isset($_POST['lastname'])) echo $_POST['lastname']; ?>" autocomplete="on" required>
								</div>
								<div class="form-group">
									<label>Gender</label>
									<label>Male&nbsp;<input type="radio" class="form-control" name="gender" value="male" checked></label>
									<label>Female&nbsp;<input type="radio" class="form-control" name="gender" value="female"></label>
								</div>
								<div class="form-group">
									<label>Password</label>
									<input type="password" class="form-control" id="password" maxlength="30"name="password" placeholder="Password" autocomplete="off" required>
								</div>
								<button type="submit" class="btn btn-primary btn-lg" style="margin-top: 15px;" id="register-btn">Sign Up</button>
							</form>
						</div>
						</div>
				</div>
				<div class="col-sm-1 col-md-2 col-lg-3"></div>
			</div>
		</div>
			
		<div class="footer">
			<div>
				<a href=""><img src="./img/fb.png"></a>
				<a href=""><img src="./img/google-plus.png"></a>
				<a href=""><img src="./img/twitter.png"></a>
				<a href=""><img src="./img/youtube.png"></a>
			</div>
			<div>Copyright &copy; 2017 <a href="">www.pioneer.com</a></div>
		</div>
	
		<!--<div class="container-fluid" style="margin-top: 2000px;">
				<div class="row">
						<div class="col-sm-2 col-md-3 col-lg-4" style="background: green;">a</div>
						<div class="col-sm-8 col-md-6 col-lg-4" style="background: red;">asdf</div>
						<div class="col-sm-2 col-md-3 col-lg-4" style="background: blue;">b</div>
				</div>
		</div> -->
			
	</body>
	<script>
		$('#reg-form').on('submit',function(e){
						
			e.preventDefault();
			var url = "./register.php";
			$.ajax({
					type:"POST",
					url:url,
					data:$(this).serialize(),
					beforeSend:function()
					{
						$("#reg-info").html('Registering....');
					},
					success: function(data){
						$("#reg-info").html(data);
						setTimeout(function(){
					 		$("#reg-info").html(""); 
						}, 3000);
					},
					error: function(){
						$("#reg-info").html('Technical error! We will connect soon');
					},
					complete: function()
					{
					}
			})

		});

		$('#login-form').on('submit',function(e){
						
			e.preventDefault();
			var url = "./signin.php";
			$.ajax({
					type:"POST",
					url:url,
					data:$(this).serialize(),
					beforeSend:function()
					{
						$("#log-info").html('Logging....');
					},
					success: function(data){
					 	console.log(data);
						$("#log-info").html(data);
						// if(data[1] == <?php echo md5(1); ?>)
						// {
						// 	window.location.href="./home.php";
						// }
					},
					error: function(data){
						$("#log-info").html('<span style="color:red"><b>Logging Error! Please try after sometime</b></span>');
					},
					complete: function()
					{
					}
			})
		});

	</script>
    
    <script>
        function openChat(){
            window.location.href = "./chat-home.html";
        }
    </script>
 </html>