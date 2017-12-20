<?php
		
	session_start();
	if(empty($_SESSION["user_id"]))
	{
		echo '<script>window.location.href="./main.php";</script>';
	}
	$user_id = $_SESSION["user_id"];
	if(empty($_GET["id"]))
	{
		die();
	}
	$profileId = $_GET["id"];
	$path = 'uploads/'.$profileId.'/'; 
?>
<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Yon | Profile</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="https://use.fontawesome.com/1685ebbb24.js"></script>
		<link href="./css/style.css" rel="stylesheet">
		<link href="./css/style-home.css" rel="stylesheet">
		<script type="text/javascript" src="./js/script-home.js"></script>
	</head>
	<body>
	<div class="header">
				
	
						
				<button class="btn btn-danger" id="logout">Logout</button>
					 

		 
	</div>
<?php
			
			
	if((is_numeric($profileId)==false) or ($user_id==$profileId) )
	{
			//echo '<script>confirm("Oops! Invalid Profile id");</script>';
			echo '<script>window.location.href="./home.php";</script>';

	}
	
	include_once("profileController.php");
	$data = profileDetails($profileId);
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
								
?>
					
		<div class="main-container positioner">

			<div class="profile-info col-lg-3 col-md-3 col-sm-4">
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
						<span class="work"><i class="fa fa-briefcase"></i><?php echo $organisation ;?></span>
						<span class="loc"><i class="fa fa-globe"></i><?php echo $lives_in; ?></span>
						<span class="status"><i class="fa fa-book"></i><?php echo $status; ?></span>
						<span class="since"><i class="fa fa-calendar"></i><?php echo $since; ?></span>
						<span class="since"><i class="fa fa-calendar"></i><?php echo  $last_seen; ?></span>

						<div id="extra-details">
							<a href="" id="followers"><strong>Followers</strong> 86.4M</a>
							<a href="" id="following"><strong>Following</strong>1.2K</a>
							<a href="/edit" ><strong>Edit profile</strong></a>
							<a href="/topics"><strong>My Topics</strong></a>
						</div>
								
					</div>
				</div>

			</div>



					<div class="post-app-wrapper col-lg-9 col-md-9 col-sm-8">

						<div class="topics-trending-container col-lg-8">
							<div class="topics">
								<div class="heading">
									Topics
									<a href="" class="info"><i class="fa fa-angle-right"></i></a>
								</div>
								<div class="topics-images">
									<img src="https://music.unca.edu/sites/default/files/styles/promoted_content_500x500/public/isis-uncasheville.jpg?itok=f8nJFuYe">
									<div class="text">
										<span>Music</span>
									</div>
								</div>
								<div class="topics-images">
									<img src="https://cdn.pastemagazine.com/www/articles/2017/02/20/July%20Talks17_Lead.jpg">
									<div class="text">
										<span>Singing</span>
									</div>
								</div>
								<div class="topics-images">
									<img src="https://www.unis.org/uploaded/04_ARTS/2015-2016/Private-Music-Lesson.jpg">
									<div class="text">
										<span>Violin</span>
									</div>
								</div>
								<div class="topics-images">
									<img src="https://www.tcs.on.ca/sites/default/files/images/senior-school/athletics/soccer-boys_04.jpg">
									<div class="text">
										<span>Football</span>
									</div>
								</div>
							</div>


							<div class="trending">
								<div class="heading">
									Trending
									<a href="" class="info"><i class="fa fa-angle-right"></i></a>
								</div>
								<div class="trending-links-container">
									<div class="trending-items"><a href="">#vamos_leo</a></div>
									<div class="trending-items"><a href="">#visca_el_barca</a></div>
									<div class="trending-items"><a href="">#allin_or_nothing</a></div>
									<div class="trending-items"><a href="">#dailycssimages</a></div>
									<div class="trending-items"><a href="">#qwertyuiop</a></div>
								</div>
							</div>


						</div>

						


						<div class="posts col-lg-8">
							<div class="post-status">
								<form method="post" autocomplete="off" id="ask-question-form">
									<textarea class="form-control" id="ask-question" name="ask_question"  rows="5" placeholder="Ask to <?php echo $firstname;?>" required="required"></textarea>
									<input type="hidden" class="btn btn-primary" value="<?php echo $profileId;?>" name="ask_to" id="ask-to">
									<input type="hidden" class="btn btn-primary" value="<?php echo $user_id;?>" name="ask_by" id="ask-by">
									<label>Anonymous:<input type="checkbox" id="anonymous-check"></label>
									<input type="submit" class="btn btn-primary" value="Ask Question" id="ask-btn">
									<br>
									<div id="ask-question-info"></div>
								</form>
							</div>

							<div class="post-container">
								<div class="timeline-user-data">
									<div class="user-pic">
										<a href="">
											<img src="https://lh3.googleusercontent.com/-yVdY59p1Jhg/VywOkS9heVI/AAAAAAAAA68/DMAsybYbqGc/Cristiano-Ronaldo-dp-profile-pics-1427.jpg">
										</a>
									</div>
									<div class="name-uname">
										<a href="">Cristiano Ronaldo</a><br>
										<a href="">@cr7_cristiano</a><br>
										<span>4h</span>
									</div>
								</div>

								<div class="post-data">
									<div class="post-text">
										Lorem ipsum dolor sit amet, consectetur adipiscing elit,
										sed do eiusmod <a href="">tempor incididunt</a> ut labore et dolore magna
										 aliqua.
									 </div>
									<div class="post-image">
										<img src="http://i4.mirror.co.uk/incoming/article9827803.ece/ALTERNATES/s615/Real-Madrid-CF-v-SSC-Napoli-UEFA-Champions-League-Round-of-16-First-Leg.jpg">
									</div>
									<div class="post-video"></div>
									<div class="post-likes">
										<i class="fa fa-thumbs-up"></i>
										<i class="fa fa-mail-reply"></i>
										<i class="fa fa-retweet"></i>
									</div>
								</div>

							</div>

							<div class="post-container">
								<div class="timeline-user-data">
									<div class="user-pic">
										<a href="">
											<img src="https://lh3.googleusercontent.com/-yVdY59p1Jhg/VywOkS9heVI/AAAAAAAAA68/DMAsybYbqGc/Cristiano-Ronaldo-dp-profile-pics-1427.jpg">
										</a>
									</div>
									<div class="name-uname">
										<a href="">Cristiano Ronaldo</a><br>
										<a href="">@cr7_cristiano</a><br>
										<span>4h</span>
									</div>
								</div>

								<div class="post-data">
									<div class="post-text">
										Lorem ipsum dolor sit amet, consectetur adipiscing elit,
										sed do eiusmod <a href="">tempor incididunt</a> ut labore et dolore magna
										 aliqua.
									 </div>
									<div class="post-image">
									</div>
									<div class="post-video">
										<iframe src="https://www.youtube.com/embed/4V8DEp5VH6w" frameborder="0" allowfullscreen></iframe>
									</div>
									<div class="post-likes">
										<i class="fa fa-thumbs-up active"></i>
										<i class="fa fa-mail-reply"></i>
										<i class="fa fa-retweet"></i>
									</div>
								</div>

							</div>

							<div class="post-container">
								<div class="timeline-user-data">
									<div class="user-pic">
										<a href="">
											<img src="https://lh3.googleusercontent.com/-yVdY59p1Jhg/VywOkS9heVI/AAAAAAAAA68/DMAsybYbqGc/Cristiano-Ronaldo-dp-profile-pics-1427.jpg">
										</a>
									</div>
									<div class="name-uname">
										<a href="">Cristiano Ronaldo</a><br>
										<a href="">@cr7_cristiano</a><br>
										<span>4h</span>
									</div>
								</div>

								<div class="post-data">
									<div class="post-text">
										Lorem ipsum dolor sit amet, consectetur adipiscing elit,
										sed do eiusmod <a href="">tempor incididunt</a> ut labore et dolore magna
										 aliqua.
									 </div>
									<div class="post-image"></div>
									<div class="post-video"></div>
									<div class="post-likes">
										<i class="fa fa-thumbs-up"></i>
										<i class="fa fa-mail-reply"></i>
										<i class="fa fa-retweet"></i>
									</div>
								</div>

							</div>

							<div class="loader">
								<div></div>
							</div>

						</div>
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

	</body>

<script type="text/javascript">


	$("#ask-question-form").on("submit",function(e){
		e.preventDefault();
		var flag=0;
		if($("#anonymous-check").prop("checked")==true)
		{
			flag=1;
		}
		var question=$("#ask-question").val();
		var profilePic = <?php echo $profile_pic.'.'.$pic_ext; ?>;
		var profilePicExt = <?php echo $pic_ext; ?>;
		var name = <?php echo $firstname; ?>;
		var url = "./fanQuestionSubmit.php";
		formData="ask_question="+question+"&ask_to="+<?php echo $profileId;?>+"&anonymous="+flag+"&name="+name+"&profile_pic="+profilePic+"&pic_ext="+profilePicExt;
		$.ajax({
			type:"POST",
			url:url,
			data:formData,
			beforeSend:function()
			{
				$("#ask-question-info").html("");
			},
			success: function(data){
				$("#ask-question-info").html(data);
				$("#ask-question").val("");
				
				setTimeout(function(){
				 	$("#ask-question-info").html(""); 
				}, 3000);
			},
			error: function(data){
				$("#question-info").html('<span style="color:red;"><b>Error in connecting to server! Please try after sometime</b></span>');
			},
			complete:function()
			{
				
			}
		});
	});

</script>
</html>
