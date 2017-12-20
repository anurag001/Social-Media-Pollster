<?php
	include_once('dbcon.php');
	session_start();
	if(empty($_SESSION["user_id"]))
	{
		echo '<script>window.location.href="./main.php";</script>';
	}
	$user_id = $_SESSION["user_id"];

	if(!empty($_POST["questionBy"]) && !empty($_POST["questionId"]))
	{
		$question_by = $_POST["questionBy"];
		$question_id = $_POST["questionId"];
		global $pdo;

		if($question_by==$user_id)
		{
			$query = $pdo->prepare("delete from feed where id=?");
			$query->bindParam(1,$question_id);
			$query->execute();
		}
	}
	
	
?>

