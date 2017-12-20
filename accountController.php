<?php

include_once('dbcon.php');

class registerController 
{

	public function register($email,$fname,$lname,$pass,$gender)
	{
		global $pdo;
		$email = trim(htmlspecialchars($email));
		$email = filter_var($email, FILTER_SANITIZE_EMAIL);
		$regex = "^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$^";
		
		if (preg_match($regex, $email))
		{
			$emailQuery=$pdo->prepare("select email from user where email = ?");
			$emailQuery->bindParam(1,$email);
			$emailQuery->execute();
			if($emailQuery->rowCount()>0)
			{
				 $msg ='<span style="color:red;"><b>Email id is already in use</b></span>';
			}
			else
			{
				$fname = trim(htmlspecialchars($fname));
				if(preg_match('/^[a-zA-Z]*$/',$fname))
				{

					$lname = trim(htmlspecialchars($lname)); 
					if(preg_match('/^[a-zA-Z]*$/',$lname))
					{
						$pass = trim(htmlspecialchars($pass));
						if(preg_match('/^[a-zA-Z0-9]*$/',$pass))
						{

							$pass = md5($pass);
							$since = date("Y-m-d h:i:s");
							$sex=0;
							if($gender=="male")
							{
								$sex=0;
							}
							else if($gender=="female")
							{
								$sex=1;
							}
							$insertQuery = $pdo->prepare("insert into user
								(email,firstname,lastname,password,gender,since,last_seen) values(?,?,?,?,?,?,?)");
							$insertQuery->bindParam(1, $email);
							$insertQuery->bindParam(2, $fname);
							$insertQuery->bindParam(3, $lname);
							$insertQuery->bindParam(4, $pass);
							$insertQuery->bindParam(5, $sex);
							$insertQuery->bindParam(6, $since);
							$insertQuery->bindParam(7, $since);
							
							if($insertQuery->execute())
							{
								$lastId=$pdo->lastInsertId();
								$path = "./uploads/".$lastId."/";
								mkdir($path);
								$msg ='<span style="color:green;"><b>User is registered successfully</b></span>';
							}
							
						}
						else
						{
							 $msg ='<span style="color:red;"><b>Password should be alphanumeric only</b></span>';
						}
						
					}
					else
					{
						 $msg ='<span style="color:red;"><b>Lastname should not contain any space and it should be a single word</b></span>';
					}

				}
				else
				{
					$msg ='<span style="color:red;"><b>Firstname should not contain any space and it should be a single word</b></span>';
				}

			}


		}
		else
		{
			$msg ='<span style="color:red;"><b>Email format is invalid</b></span>';
		}
		
		echo $msg;

	}

	public function signin($logemail,$logpass)
	{
		global $pdo;
		$logemail = trim(htmlspecialchars($logemail));
		$logpass = htmlspecialchars($logpass);
		$logemail = filter_var($logemail, FILTER_SANITIZE_EMAIL);
		$regex = "^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$^";
		
		$token = md5(0);
		if (preg_match($regex, $logemail))
		{
			$logpass = md5($logpass);
			$query = $pdo->prepare("select user_id,gender from user where email=? and password=?");
			$query->bindParam(1,$logemail);
			$query->bindParam(2,$logpass);
			$query->execute();
			if($query->rowCount()>0)
			{
				$row = $query->fetch(PDO::FETCH_OBJ);
				session_start();
				$_SESSION["user_id"] = $row->user_id;
				$_SESSION["gender"] = $row->gender;
				echo '<script>window.location.href = "./home.php";</script>';
				$msg = '<span style="color:green;"><b>Logging in....</b></span>';
				$token = md5(1);

			}
			else
			{
				$msg ='<span style="color:red;"><b>Invalid Credentials</b></span>';
			}
		}
		else
		{
			$msg ='<span style="color:red;"><b>Email format is invalid</b></span>';
		}

		echo $msg;

	}
   
}

$accountObject = new registerController();
