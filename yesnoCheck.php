<?php
	include_once('dbcon.php');
	session_start();
	if(empty($_SESSION["user_id"]))
	{
	echo '<script>window.location.href="./main.php";</script>';
	}
	$user_id = $_SESSION["user_id"];
	if(!empty($_POST["questionId"]))
	{
		$question_id = $_POST["questionId"];
		include_once("feedController.php");
		$bool = $feedObject->yesnoCheck($user_id,$question_id);
		echo $bool;

	}
?>
	

