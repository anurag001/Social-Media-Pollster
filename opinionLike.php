<?php

	include_once('dbcon.php');
	session_start();
	if(empty($_SESSION["user_id"]))
	{
		echo '<script>window.location.href="./main.php";</script>';
	}
	$user_id = $_SESSION["user_id"];
	
	global $pdo;
	if(empty($_POST["opinionId"]) && empty($_POST["likeFlag"]))
	{
		die();
	}
	$id = $_POST["opinionId"];
	$bool = $_POST["likeFlag"];

	
	if($bool==0)
	{
		$time = time();
		$query = $pdo->prepare("insert into likes(like_by,opinion_id,time) values(?,?,?)");
		$query->bindParam(1,$user_id);
		$query->bindParam(2,$id);
		$query->bindParam(3,$time);
		$query->execute();

		$query = $pdo->prepare("update opinion set likes=likes+1 where id=?");
		$query->bindParam(1,$id);
		$query->execute();

	}
	else if($bool==1)
	{
		
		$query = $pdo->prepare("delete from likes where like_by=? and opinion_id=?");
		$query->bindParam(1,$user_id);
		$query->bindParam(2,$id);
		$query->execute();

		$query = $pdo->prepare("update opinion set likes=likes-1 where id=?");
		$query->bindParam(1,$id);
		$query->execute();
	}



?>