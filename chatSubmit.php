<?php

	include_once('dbcon.php');
	global $pdo;
	if(!empty($_POST["chat_content"]) and !empty($_POST["chat_topic_id"]))
	{
		$time=time();
		$content = $_POST["chat_content"];
		$topicId = $_POST["chat_topic_id"];
		$deviceId =  $_SERVER['HTTP_USER_AGENT'];
		$query = $pdo->prepare("insert into chat(chat_topic_id,chat_content,chat_by,chat_time) values(?,?,?,?)");
		$query->bindParam(1,$topicId);	
		$query->bindParam(2,$content);	
		$query->bindParam(3,$deviceId);	
		$query->bindParam(4,$time);	
		if($query->execute())
		{
			echo "Sent!";
		}
		else
		{
			echo "Not Sent!";
		}
	}

?>