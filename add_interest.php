<?php
	session_start();
	if(empty($_SESSION["user_id"]))
	{
		echo '<script>window.location.href="./main.php";</script>';
	}
	$user_id = $_SESSION["user_id"];
	include_once('dbcon.php');
	if(!empty($_POST["interest_id"]))
	{
		$query = $pdo->prepare("insert into user_interest(user_id,user_interest_id) values(?,?)");
		$query->bindParam(1,$user_id);
		$query->bindParam(2,$_POST["interest_id"]);
		$query->execute();
	}
?>