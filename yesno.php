<?php

	include_once('dbcon.php');
	session_start();
	if(empty($_SESSION["user_id"]) && empty($_SESSION["gender"]))
	{
		echo '<script>window.location.href="./main.php";</script>';
	}
	$user_id = $_SESSION["user_id"];
	$gender = $_SESSION["gender"];

	global $pdo;
	if(empty($_POST["id"]) && empty($_POST["bool"]) && empty($_POST["state"]))
	{
		die();
	}
	$id = htmlspecialchars($_POST["id"]);
	$bool = htmlspecialchars($_POST["bool"]);
	$state = htmlspecialchars($_POST["state"]);

	$flag=0;
	
	if($bool==0)
	{
		//neither yes nor no
		$yes=0;
		$no=0;
		$overall = 0;
		if($state=="yes")
		{
			$yes=1;
			$overall=1;
		}
		else if($state=="no")
		{
			$no=1;
			$overall=2;
		}
		$query = $pdo->prepare("insert into yesno(user_id,question_id,yes,no,status_id) values(?,?,?,?,?)");
		$query->bindParam(1,$user_id);
		$query->bindParam(2,$id);
		$query->bindParam(3,$yes);
		$query->bindParam(4,$no);
		$query->bindParam(5,$overall);
		$query->execute();
	}
	else
	{
		if($bool==1)
		{
			//already yes
			if($state=="yes")
			{
				$yes = 1;
				$no = 0;
				$overall = 1;
				$query = $pdo->prepare("delete from yesno where user_id=? and question_id=?");
				$query->bindParam(1,$user_id);
				$query->bindParam(2,$id);
				$query->execute();
			}	
			else if($state=="no")
			{
				$no=1;
				$yes=0;
				$overall=2;
				$query = $pdo->prepare("update yesno set yes=?,no=?,status_id=? where user_id =? and question_id=?");
				$query->bindParam(1,$yes);
				$query->bindParam(2,$no);
				$query->bindParam(3,$overall);
				$query->bindParam(4,$user_id);
				$query->bindParam(5,$id);
				$query->execute();
			}
		}
		else if($bool==2)
		{
			//already no
			if($state=="no")
			{
				$yes = 0;
				$no = 1;
				$overall = 2;
				$query = $pdo->prepare("delete from yesno where user_id=? and question_id=?");
				$query->bindParam(1,$user_id);
				$query->bindParam(2,$id);
				$query->execute();
			}
			else if($state=="yes")
			{
				$no=0;
				$yes=1;
				$overall=1;
				$query = $pdo->prepare("update yesno set yes=?,no=?,status_id=? where user_id =? and question_id=?");
				$query->bindParam(1,$yes);
				$query->bindParam(2,$no);
				$query->bindParam(3,$overall);
				$query->bindParam(4,$user_id);
				$query->bindParam(5,$id);
				$query->execute();
			}
		}
		
	}

	if($bool==0)
	{
		if($state=="yes")
		{
			if($gender==0)
			{
				$update = $pdo->prepare("update feed set yes=yes+1,male_yes=male_yes+1 where id=?");
			}
			else
			{
				$update = $pdo->prepare("update feed set yes=yes+1 where id=?");
			}

		}
		else if($state=="no")
		{
			if($gender==0)
			{
				$update = $pdo->prepare("update feed set no=no+1,male_no=male_no+1 where id=?");
			}
			else
			{
				$update = $pdo->prepare("update feed set no=no+1 where id=?");
			}
		}
	}
	else
	{
		if($bool==1)
		{
			//already yes
			if($state=="no")
			{
				if($gender==0)
				{
					$update = $pdo->prepare("update feed set yes=yes-1,no=no+1,male_yes=male_yes-1,male_no=male_no+1 where id=?");
				}
				else
				{
					$update = $pdo->prepare("update feed set yes=yes-1,no=no+1 where id=?");
				}
			}
			else
			{
				if($gender==0)
				{
					$update = $pdo->prepare("update feed set yes=yes-1,male_yes=male_yes-1 where id=?");
				}
				else
				{
					$update = $pdo->prepare("update feed set yes=yes-1 where id=?");
				}
			}
		}
		else if($bool==2)
		{
			//already no
			if($state=="yes")
			{
				if($gender==0)
				{
					$update = $pdo->prepare("update feed set yes=yes+1,no=no-1,male_yes=male_yes+1,male_no=male_no-1 where id=?");
				}
				else
				{
					$update = $pdo->prepare("update feed set yes=yes+1,no=no-1 where id=?");
				}
			}
			else
			{
				if($gender==0)
				{
					$update = $pdo->prepare("update feed set no=no-1,male_no=male_no-1 where id=?");
				}
				else
				{
					$update = $pdo->prepare("update feed set no=no-1 where id=?");
				}
				
			}
		}
	}
	
	$update->bindParam(1,$id);
	$update->execute();

?>