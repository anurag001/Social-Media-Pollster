<?php

	session_start();
	if(empty($_SESSION["user_id"]))
	{
		echo "<script>alert('You are not logged in');</script>";
	}
	else
	{
		session_destroy();
		$_SESSION["userid"]="";
		$_SESSION["gender"]="";

	}
	echo '<script>window.location.href = "./main.php";</script>';
	
?>
