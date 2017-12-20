<?php
	include_once('dbcon.php');
	session_start();
	if(empty($_SESSION["user_id"]))
	{
		echo '<script>window.location.href="./main.php";</script>';
	}
	$id = $_SESSION["user_id"];
	global $pdo;
	$location='./uploads/'.$id.'/';
	if(!empty($_POST["question"]))
	{
		$feed = trim(htmlspecialchars($_POST["question"]));

		if(isset($_FILES["file"]["name"]) and !empty($_FILES["file"]["name"]) and !empty($feed))
		{
			
			if((($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")) || ($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/gif")&& ($_FILES["file"]["size"] < 2000000))
			{
				$ext = $_FILES["file"]["type"];
				if($_FILES["file"]["error"]>0)
				{
					echo "Return Code: ".$_FILES["file"]["error"]."<br/><br/>";
				}
				else
				{
					if(file_exists($location.$_FILES["file"]["name"]))
					{
						echo $_FILES["file"]["name"]." already exists";
					}
					else
					{
						$source = $_FILES["file"]["tmp_name"];
						$name = time();
						$code = md5($id);
						$name = $name.$code;
						$extension="jpg";
						if($ext == "image/jpeg" || $ext == "image/jpg")
						{
							$extension="jpg";
						}
						else if($ext == "image/png")
						{
							$extension="png";
						}
						else if($ext == "image/gif")
						{
							$extension="gif";
						}
						$target = $location.$name;
						
						if(move_uploaded_file($source,$target))
						{
							$feedQuery = $pdo->prepare("insert into feed
								(question,question_by,question_pic,question_pic_ext,time) values(?,?,?,?,?)");
							$time = time();
							$feedQuery->bindParam(1,$feed);
							$feedQuery->bindParam(2,$id);
							$feedQuery->bindParam(3,$name);
							$feedQuery->bindParam(4,$extension);
							$feedQuery->bindParam(5,$time);
							if($feedQuery->execute())
							{
								echo '<center><span style="color:green;font-weight:bold;" class="text-center">Question is submitted</span></center>';
							}
							
						//-----------------------  RESCALING PICTURE  ----------------------
							
							//Setting header
							if($ext == "image/jpeg" || $ext == "image/jpg")
							{
								header('Content-type: image/jpeg');
							}
							else if($ext == "image/png")
							{
								header('Content-type: image/png');
							}
							else if($ext == "image/gif")
							{
								header('Content-type: image/gif');
							}

							//Required
							$filename = $target;
							$percent = 1.0;
							list($width,$height)=getimagesize($filename);

							// Get new sizes
							$newwidth = $width * $percent;
							$newheight = $height * $percent;
							$extension = ".".$extension;

							// Load
							$thumb = imagecreatetruecolor($newwidth, $newheight);
							if($ext == "image/jpeg" || $ext == "image/jpg")
							{
								$src = imagecreatefromjpeg($filename);
								
								// Resize
								imagecopyresized($thumb, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
								
								// Output and saving
								imagejpeg($thumb, $filename.$extension);

							}
							else if($ext == "image/png")
							{
								$src = imagecreatefrompng($filename);

								// Resize
								imagecopyresized($thumb, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

								// Output and saving
								imagepng($thumb, $filename.$extension);


							}
							else if($ext == "image/gif")
							{
								$src = imagecreatefromgif($filename);

								// Resize
								imagecopyresized($thumb, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

								// Output and saving
								imagegif($thumb, $filename.$extension);


							}
							
							//Delete original image file
							unlink($filename);
							//Destroy image src							
							imagedestroy($src);
						//---------------------------------------------
							
						}
						else
						{
							echo '<center><span class="alert alert-danger text-center">Error in uploading image.Please try again.</span></center>';
						}
							
					}
				}
			}
			else
			{
				echo '<center><span style="color:red;" class="alert">Only jpeg/jpg/png/gif files are allowed and size should be less than 2 Mb</span></center>';
			}
		}
		else if(!empty($feed))
		{
			$feedQuery = $pdo->prepare("insert into feed
								(question,question_by,time) values(?,?,?)");
			$time = time();
			$feedQuery->bindParam(1,$feed);
			$feedQuery->bindParam(2,$id);
			$feedQuery->bindParam(3,$time);
			if($feedQuery->execute())
			{
				echo '<center><span style="color:green;font-weight:bold;" class="text-center">Question is submitted</span></center>';
			}
		}
	}
	else
	{
		echo '<script>window.location.href="./error.php";</script>';
	}
	
?>