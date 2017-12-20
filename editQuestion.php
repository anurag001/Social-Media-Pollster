<?php
	include_once('dbcon.php');
	session_start();
	if(empty($_SESSION["user_id"]))
	{
		echo '<script>window.location.href="./main.php";</script>';
	}
	$user_id = $_SESSION["user_id"];
	if(!empty($_POST["question_by"]) && !empty($_POST["question"]) && !empty($_POST["question_id"]))
	{
		$question_by = htmlspecialchars($_POST["question_by"]);
		$question = htmlspecialchars($_POST["question"]);
		$question_id = htmlspecialchars($_POST["question_id"]);
		global $pdo;

		if($question_by==$user_id)
		{
			$query = $pdo->prepare("update feed set question=? where id=?");
			$query->bindParam(1,$question);
			$query->bindParam(2,$question_id);
			if($query->execute())
			{
				echo '<center><span style="color:green;font-weight:bold;">Question is edited successfully.</span></center>';
			}
			else
			{
				echo '<center><span style="color:red;font-weight:bold;">Question is not edited.</span></center>';
			}
		}
		else
		{
			echo '<center><span style="color:red;font-weight:bold;">No permission to edit this Question</span></center>';
		}
	}
	else
	{
		echo '<script>window.location.href="./error.php";</script>';
	}
?>

