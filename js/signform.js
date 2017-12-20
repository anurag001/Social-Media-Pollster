	function check_email()
	{
			var email = $('#email').val();
			email = $.trim(email);
				if (email == '') {
					$('#email-info').fadeIn();
					$('#email-info').html('<span style="color:red; padding:2px;">Please provide your email id</span>');
					/*setTimeout(function() {
						$("#email-info").fadeOut();
					}, 3000);*/
				return false;
				} 
				else if (email.match(/\s/g)) {

					//alert("Please Check Your Fields For Spaces");
					$('#email-info').html('<span style="color:red; padding:2px;">Don\'t provide spaces.Provide valid email id</span>');
					return false;
				}
				else {
					$.ajax({  
						type: "POST",  
						url: "./email_check.php", 
						data:"email="+email,
						success: function(response){
							$('#email-info').fadeIn();
							$('#email-info').html(response);
							/*setTimeout(function() {
							$("#username-info").fadeOut();
							}, 3000);*/
						},
						error:  function(){
							$('#email-info').fadeIn();
							$('#email-info').html("Some error occured");
							/*setTimeout(function() {
							$("#username-info").fadeOut();
							}, 3000);*/
						},
						complete:{
			
						}
					});
					return true;
				}
	}
	
	function check_username()
	{
			var pattern = new RegExp("@");
			var patt = new RegExp("#");
			
			var username = $('#username').val();
			username = $.trim(username);
				if (username == '') {
					$('#username-info').fadeIn();
					$('#username-info').html('<span style="color:red; padding:2px;">Please provide username</span>');
					/*setTimeout(function() {
					$("#username-info").fadeOut();
					}, 3000);*/
				return false;
				} 
				else if (username.match(/\s/g)){

					//alert("Please Check Your Fields For Spaces");
					$('#username-info').html('<span style="color:red; padding:2px;">Don\'t provide spaces in your username.</span>');
					return false;
				}
				else if(pattern.test(username))
				{
					$('#username-info').html('<span style="color:red; padding:2px;">You can\'t use @ in username.</span>');
					return false;
				}
				else if(patt.test(username))
				{
					$('#username-info').html('<span style="color:red; padding:2px;">You can\'t use # in username.</span>');
					return false;
				}
				else {
					$.ajax({  
						type: "POST",  
						url: "./username_check.php", 
						data:"username="+username,
						success: function(response){
							$('#username-info').fadeIn();
							$('#username-info').html(response);
							/*setTimeout(function() {
							$("#username-info").fadeOut();
							}, 3000);*/
						},
						error:  function(){
							$('#username-info').fadeIn();
							$('#username-info').html("Some error occured");
							/*setTimeout(function() {
							$("#username-info").fadeOut();
							}, 3000);*/
						},
						complete:{
			
						}
					});
					return true;
				}
	}
	
	function check_firstname()
	{
		var fname = $('#firstname').val();
			fname = $.trim(fname);
			if(fname == '')
			{
				$('#firstname-info').html('<span style="color:red; padding:2px;">Please provide your First Name</span>');
				return false;
			}
			else if (fname.match(/\s/g)){

					//alert("Please Check Your Fields For Spaces");
					$('#firstname-info').html('<span style="color:red; padding:2px;">Don\'t provide spaces.Provide right one.</span>');
					return false;
			}
			else
			{
				$('#firstname-info').html('<span class="text-primary">Its fine!</span>');
				return true;
			}
	}
	
	function check_lastname()
	{
		var lname = $('#lastname').val();
			lname = $.trim(lname);
			if(lname == '')
			{
				$('#lastname-info').html('<span style="color:red; padding:2px;">Please provide your Last Name</span>');
				return false;
			}
			else if (lname.match(/\s/g)){

					//alert("Please Check Your Fields For Spaces");
					$('#lastname-info').html('<span style="color:red; padding:2px;">Don\'t provide spaces.Provide right one.</span>');
					return false;
			}
			else
			{
				$('#lastname-info').html('<span class="text-primary">Its fine!</span>');
				return true;
			}
	}
	
	function check_password()
	{
		var pass = $('#password').val();
			pass = $.trim(pass);
			if(pass == '')
			{
				$('#password-info').html('<span style="color:red; padding:2px;">Please provide password,Don\'t use spaces</span>');
				return false;
			}
			else
			{
				$('#password-info').html('<span class="text-primary">Password is fine!</span>');
				return true;
			}
	}
			
	
		$("#register").click(function(e){
			e.preventDefault();
						
					if(check_email() && check_username() && check_firstname() && check_lastname() && check_password())
					{
						var d = $('#reg-form').serialize();
						$.ajax({
							url: "./signup.php",
							method: "POST",
							data: d,
							success: function(data) {
								$('#sign-up').hide();
								$('#success').show();
								$('#success').html('<h3 style="color:#78ffee;">' + data + '</h3>');
							},
							error: function() {
								alert('There is some problem we are facing.');
							},
							complete: function() {
							}
						});
				 	}
					else
					{
						$('#email-info').html('<span style="color:red; padding:2px;">Please provide your email id</span>');
						$('#username-info').html('<span style="color:red; padding:2px;">Please provide username</span>');
					}
		});
		
		$("#login").click(function(e){
			e.preventDefault();
						var logu = $("#loguser").val();
						var logp = $("#logpass").val();
					if(logu == '' && logp == '')
					{
						$('#login-info').html('<span style="color:red; padding:2px;">Please provide both fields.</span>');
						return false;
					}
					else
					{
						var logd = $('#login-form').serialize();
						$.ajax({
							url: "./signin.php",
							method: "POST",
							data: logd,
							success: function(data) {
								$('#login-info').show();
								$('#login-info').html('<span style="color:red; padding:2px;">' + data + '</span>');
							},
							error: function() {
								alert('There is some problem we are facing.');
							},
							complete: function() {
							}
						});
						return true;
					}
				 	
		});
	
	