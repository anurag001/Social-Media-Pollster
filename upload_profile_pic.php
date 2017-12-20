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
	$flag=0;

		if(isset($_FILES["file"]["name"]) and !empty($_FILES["file"]["name"]))
		{
			
			if((($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")) || ($_FILES["file"]["type"] == "image/png") && ($_FILES["file"]["size"] < 2000000))
			{
				$ext = $_FILES["file"]["type"];
				if($_FILES["file"]["error"]>0)
				{
					$msg =  "Return Code: ".$_FILES["file"]["error"]."<br/><br/>";
				}
				else
				{
					if(file_exists($location.$_FILES["file"]["name"]))
					{
						$msg = $_FILES["file"]["name"]." already exists";
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
						$target = $location.$name;
						
						if(move_uploaded_file($source,$target))
						{
							$feedQuery = $pdo->prepare("update user	set profile_pic=?,profile_pic_ext=? where user_id=?");
							$feedQuery->bindParam(1,$name);
							$feedQuery->bindParam(2,$extension);
							$feedQuery->bindParam(3,$id);
							if($feedQuery->execute())
							{
								$flag=1;
								$msg = '<center><span style="color:green;font-weight:bold;" class="text-center">Uploaded successfully</span></center>';
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
							
							//Delete original image file
							unlink($filename);
							//Destroy image src							
							imagedestroy($src);
					//---------------------------------------------

						}
						else
						{
							$msg = '<center><span style="font-weight:bold;color:red;" class="text-center">Error in uploading image.Please try again.</span></center>';
						}
							
					}
				}
			}
			else
			{
				$msg = '<center><span style="font-weight:bold;color:red;" class="text-center">Only jpeg/jpg/png files are allowed and size should be less than 2 Mb</span></center>';
			}
		}
		
		if($flag==1)
		{
			$msg = $msg."+".$filename.$extension;
			echo $msg;
		}
		else
		{
			echo $msg;
		}
	
?>