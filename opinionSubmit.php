<?php
	include_once('dbcon.php');
	session_start();
	if(empty($_SESSION["user_id"]))
	{
		echo '<script>window.location.href="./main.php";</script>';
	}
	$user_id = $_SESSION["user_id"];

	include_once('feedController.php');
	if(!empty($_POST["opinion"]) && !empty($_POST["question_id"]))
	{
		$opinion = htmlspecialchars($_POST["opinion"]);
		$questionId = htmlspecialchars($_POST["question_id"]);
		$feedObject->opinionSubmit($questionId,$opinion);
	}

?>