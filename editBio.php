<?php
	
	include_once('dbcon.php');
	session_start();
	if(empty($_SESSION["user_id"]))
	{
		echo '<script>window.location.href="./main.php";</script>';
	}
	$id = $_SESSION["user_id"];
		
	include_once('editController.php');
	$editObject->editBio($id,htmlspecialchars($_POST["organisation"]),htmlspecialchars($_POST["lives_in"]),htmlspecialchars($_POST["status"]));
	
	
?>