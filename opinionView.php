<?php
	include_once('dbcon.php');
	session_start();
	if(empty($_SESSION["user_id"]))
	{
		echo '<script>window.location.href="./main.php";</script>';
	}
	$user_id = $_SESSION["user_id"];

	include_once('feedController.php');
	if(!empty($_POST["questionId"]))
	{
		$questionId = $_POST["questionId"];
		$feedObject->opinionView($questionId);
	}
	
?>