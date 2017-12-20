<?php
	include_once('dbcon.php');
	session_start();
	if(empty($_SESSION["user_id"]))
	{
		echo '<script>window.location.href="./main.php";</script>';
	}
	$user_id = $_SESSION["user_id"];

	global $pdo;
	if(!empty($_POST["opinionBy"]) && !empty($_POST["opinionId"]) && !empty($_POST["questionId"]))
	{
		$opinion_by = $_POST["opinionBy"];
		$opinion_id = $_POST["opinionId"];
		$question_id = $_POST["questionId"];

		if($opinion_by==$user_id)
		{
			$query = $pdo->prepare("delete from opinion where id=?");
			$query->bindParam(1,$opinion_id);
			$query->execute();

			$query = $pdo->prepare("update feed set opinion=opinion-1 where id=? ");
			$query->bindParam(1,$question_id);
			$query->execute();
		}
	}
	
	
?>

