<?php
	include_once('dbcon.php');
	session_start();
	if(empty($_SESSION["user_id"]))
	{
		echo '<script>window.location.href="./main.php";</script>';
	}
	else
	{
		$user_id = $_SESSION["user_id"];
		global $pdo;
		if(!empty($_POST["opinionId"]))
		{
			$opinionId = $_POST["opinionId"];
			$query = $pdo->prepare("select * from likes where like_by=? and opinion_id=?");
			$query->bindParam(1,$user_id);
			$query->bindParam(2,$opinionId);
			$query->execute();
			if($query->rowCount()>0)
			{
				echo 1;
			}
			else
			{
				echo 0;
			}
		}
	}
?>

