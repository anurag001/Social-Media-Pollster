<?php
	session_start();
	if(empty($_SESSION["user_id"]))
	{
		echo '<script>window.location.href="./main.php";</script>';
	}
	$user_id = $_SESSION["user_id"];
	$path = "uploads/".$user_id."/"; 
	
	include_once("profileController.php");
	$data = profileDetails($user_id);
	$data = json_decode($data);
	// echo gettype($data);
	//json_decode converts string to object
	
	if (is_object($data))
	{
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
	

include "header.php";			
?>

<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Yon | Home</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="https://use.fontawesome.com/1685ebbb24.js"></script>
		<link href="./css/style.css" rel="stylesheet">
		<link href="./css/style-home.css" rel="stylesheet">
		<script type="text/javascript" src="./js/script-home.js"></script>
		<style>
		pre{
		    white-space: pre-wrap;       /* Since CSS 2.1 */
		    white-space: -moz-pre-wrap;  /* Mozilla, since 1999 */
		    white-space: -pre-wrap;      /* Opera 4-6 */
		    white-space: -o-pre-wrap;    /* Opera 7 */
		    word-wrap: break-word;       /* Internet Explorer 5.5+ */
		}
		.content-wrap-view{
		    white-space: pre-wrap;       /* Since CSS 2.1 */
		    white-space: -moz-pre-wrap;  /* Mozilla, since 1999 */
		    white-space: -pre-wrap;      /* Opera 4-6 */
		    white-space: -o-pre-wrap;    /* Opera 7 */
		    word-wrap: break-word;       /* Internet Explorer 5.5+ */
		}
		</style>
	</head>
	<body>
	<script>
		window.fbAsyncInit = function() {
			FB.init({
				appId      : '335776676873899',
				xfbml      : true,
				version    : 'v2.10'
			});
			FB.AppEvents.logPageView();
		};

		(function(d, s, id){
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) {return;}
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>

	<div class="main-container positioner">
		
		<div class="profile-trending-info col-lg-3 col-md-3 col-sm-4">
			<div class="profile-wrapper">
				<div class="cover">
					<div class="profile-pic">
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
				<div class="user-data">
					<span class="name"><?php echo $firstname; ?> <?php echo $lastname; ?></span>
					<div class="other-details-container">
						<div class="gender other-details">
							<div class="icon">
								<i class="fa fa-female" style="color: #BBBBBB;"></i>
							</div>
							<div class="detail-value">F</div>
						</div>
						<div class="asked other-details">
							<div class="icon">
								<i class="fa fa-question" style="color: #E3A4A4;"></i>
							</div>
							<div class="detail-value">24</div>
						</div>
						<div class="answered other-details">
							<div class="icon">
								<i class="fa fa-check" style="color: #AAECA0;"></i>
							</div>
							<div class="detail-value">389</div>
						</div>
					</div>
					<div id="extra-details">
						<a href="./edit.php" ><strong>Edit profile</strong></a>
						<br>
						<a href="./interest.php" ><strong>Choose Interests</strong></a>
					</div>
				</div>
			</div>
			
			<div class="trending-wrapper">
				<div class="trending-header">
					<div class="trending-header-text">
						Trending
					</div>
					<div class="trending-right-icon">
						<i class="right-icon fa fa-chevron-right"></i>
					</div>
				</div>
				<div class="hr" style="width: calc(100% - 40px); height: 2px; margin: auto; background: #ececec;"></div>
				
				<div class="trending-questions-container" id="trending-view">
					
				</div>
			</div>
			
			<div class="apps" style="padding: 0;">
				<div class="apps-container">
					<div class="app-image">
						<img src="./img/artboard_24.jpg">
					</div>
					<div class="app-desc">
						Want to ask something? You are just a click away.
					</div>
					<div class="app-button">
					<!-- Modal caller -->
						<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#QuestionModal">
						Ask Question
						</button>
					</div>
				</div>
			</div>

		</div>


		<div class="post-app-wrapper col-lg-9 col-md-9 col-sm-8">
			
			<div class="apps col-lg-4">
				<div class="apps-container">
					<div class="app-image">
						<img src="./img/artboard_24.jpg">
					</div>
					<div class="app-desc">
						Want to ask something? You are just a click away.
					</div>
					<div class="app-button">
					<!-- Modal caller -->
						<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#QuestionModal">
						Ask Question
						</button>
					</div>
				</div>
			</div>
				
			<!-- Post Questions Modal Box-->
			<div class="modal fade" id="QuestionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="myModalLabel">Write your Question</h4>
						</div>
						<div class="modal-body">
							<form enctype="multipart/form-data" method="post" id="question-form">
								<textarea id="question" name="question" class="form-control" placeholder="What's in your mind." required></textarea>
								<br>
								<input type="file" name="file" id="question-pic"class="form-control">
								<br>
								<input type="hidden" name="question_by" value="<?php echo $user_id; ?>">
								<input type="submit" class="btn btn-primary" value="Submit">
							</form>
							<br>
							<div id="question-info"></div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
			<!--End Modal-->

			<div class="posts col-lg-8" id="feed-display">
			</div>


		</div>

	</div>

	</body>
	<script type="text/javascript">

		$("#question-form").on("submit",function(e){
			e.preventDefault();
			var url = "./feedSubmit.php";
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
					$("#question-info").html('Loading...');
				},
				success: function(data){
					$("#question-info").html(data);
					$("#question").val("");
					$("#question-pic").val("");
					setTimeout(function(){
						$("#question-info").html(""); 
					}, 3000);
				},
				error: function(data){
					$("#question-info").html('<span style="color:red;"><b>Error in connecting to server! Please try after sometime</b></span>');
				},
				complete:function()
				{
					pullFeed();
				}
			});
		});
		
		function pullFeed()
		{
			$.ajax({
				type:"POST",
				url:"./feed.php",
				beforeSend:function()
				{
					$("#feed-display").html('<div class="loader"><div></div></div>');
				},
				success: function(data){
					$("#feed-display").html(data);
				},
				error: function(data){
					$("#question-info").html('<span style="color:red;"><b>Error in connecting to server</b></span>');
				},
				complete:function()
				{
				}
			});
		}

		function pullTrending()
		{
			$.ajax({
				type:"POST",
				url:"./trending.php",
				beforeSend:function()
				{
					$("#trending-view").html('<div class="loader"><div></div></div>');
				},
				success: function(data){
					$("#trending-view").html(data);
				},
				error: function(data){
					$("#trending-view").html('<span style="color:red;"><b>Error in connecting to server</b></span>');
				},
				complete:function()
				{
				}
			});
		}
		window.onload = function(){
			pullFeed();
			pullTrending();
		};
		
		function menuFocus(obj)
		{
			$("#"+obj.id).find(".triple-dot-menu").show(200);
		}

		function menuBlur(obj)
		{
			setTimeout(function(){
			$("#"+obj.id).find(".triple-dot-menu").hide(200);
			$(this).parent().blur();}, 500);
		}

		
		
		$(".triple-dot-menu").click(function(){
			setTimeout(function(){$(this).hide(200);
			$(this).parent().blur();}, 200);
		});
		
	</script>
</html>
