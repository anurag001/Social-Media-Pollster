<?php

	session_start();
	if(empty($_SESSION["user_id"]))
	{
		echo '<script>window.location.href="./main.php";</script>';
	}
	$user_id = $_SESSION["user_id"];
	$path = 'uploads/'.$user_id.'/'; 
	
	include_once("profileController.php");
	$data = profileDetails($user_id);
	$data = json_decode($data);
	// echo gettype($data);
	//json_decode converts string to object
	
	if (is_object($data))
	{
		$email = $data->email;
		$firstname = $data->firstname;
		$lastname = $data->lastname;
		$organisation = $data->organisation;
		$lives_in = $data->lives_in;
		$status = $data->status;
		$since = $data->since;
		$last_seen = $data->last_seen;
		$profile_pic = $data->profile_pic;
		$pic_ext = $data->pic_ext;
	}
	
?>
<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Yon | Edit Profile</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="https://use.fontawesome.com/1685ebbb24.js"></script>
		<link href="./css/style.css" rel="stylesheet">
		<link href="./css/style-home.css" rel="stylesheet">
		<script type="text/javascript" src="./js/script-home.js"></script>
						
	</head>
	<body>

		<div class="container">
			<div class="row">	
				
				<div class="col-lg-6">
					<div class="panel panel-primary">
						<div class="panel-heading">
							Edit Profile Picture
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-sm-12">
									<div id="show-img" class="profile-pic">
										<img src="<?php 
											if(is_null($profile_pic))
											{
												echo 'img/profile.svg'; 
											} 
											else
											{
												echo $path.$profile_pic.".".$pic_ext;
											}
										 ?>" class="img-rounded" alt="profile pic">
									</div>
								</div>
							</div>
							</br></br>
							<form enctype="multipart/form-data" method="post" id="profile-pic-form" >
								<div class="row">
									<div class="col-sm-12">
										<input type="file" id="image" name="file" class="form-control" required="required">
									</div>
								</div>
								</br>
								<div class="row">
									<div class="col-sm-12">
										<button type="submit" class="btn btn-primary btn-block" id="profile-pic-btn">Upload Image</button>
									</div>
								</div>
								</br>
								<div class="row">
									<div class="col-sm-12">
										<div id="upload-pic-info"></div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
							
				<div class="col-lg-6">
					<div class="panel panel-primary">
						<div class="panel-heading">
							Edit Profile
						</div>
						<div class="panel-body">
								
								<form method="post" id="updatebioform" name="update_form">
									<div class="row">
										<div class="col-sm-5"> 
											<legend>Name</legend>
											<legend>Email</legend>
											<legend>Organisation</legend>
											<legend>Lives In</legend>
											<legend>Status</legend>
										</div>
										<div class="col-sm-7">
											 <legend><?php echo $firstname; ?> <?php echo $lastname; ?></legend>
											 <legend><?php echo $email;?></legend>
											 <legend><input type="text" class="form-control" name="organisation" value="<?php echo $organisation ;?>" required="required" placeholder="Organisation"></legend>
											 <legend><input type="text" class="form-control" name="lives_in" value="<?php echo $lives_in ;?>" required="required" placeholder="Lives in"></legend>
											 <legend><input type="text" class="form-control" name="status" value="<?php echo $status ;?>" required="required" placeholder="Status"></legend>
										</div>   
									</div>
									<div class="row">
										<div class="col-sm-12">
											 <button type="submit" class="btn btn-primary btn-block" id="update-btn" name="update">Update Bio</button>
										</div>
									</div>
								</form>
							 
								<div class="row">
									<div class="col-sm-12">
										<div id="update-info" class="text-center"></div>
									</div>
								</div>
						</div>
					</div>
				</div>
					
			</div>
		</div>

		<script>
			
			$('#updatebioform').on('submit',function(e){

				e.preventDefault();
				var url = "./editBio.php";
				var data = $(this).serialize();
				$.ajax({
					type:"POST",
					url:url,
					data:data,
					success: function(data){
						$("#update-info").html(data);
						setTimeout(function(){ 
							$("#update-info").html(""); 
						}, 3000);
					},
					error: function(){
						$("#update-info").html('Technical error due to poor internet connection');
					}
				});

			});

			$('#profile-pic-form').on('submit',function(e){

				e.preventDefault();
				var url = "./upload_profile_pic.php";
				var formData = new FormData($(this)[0]);
				$.ajax({
					type:"POST",
					url:url,
					data:formData,
					contentType:false,
					cache:false,
					processData:false,
					async:false,
					beforeSend:function()
					{
						$("#upload-pic-info").html('Loading...');
					},
					success: function(data){
						if(/\+/g.test(data))
						{
							var imgArray = data.split("+");
							$("#upload-pic-info").html(imgArray[0]);
							$("#show-img").html('<img src="'+imgArray[1]+'" class="img-rounded" alt="profile pic">');
						}
						else
						{
							$("#upload-pic-info").html(data);
						} 
					},
					error: function(data){
						$("#upload-pic-info").html('Error due to poor internet connection');
					}
				});

			});

		</script>
		</body>
</html>