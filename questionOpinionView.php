<?php
	include_once('dbcon.php');
	
	include_once('questionController.php');
	if(!empty($_POST["questionId"]))
	{
		$questionId = $_POST["questionId"];
		$questionObject->opinionView($questionId);
	}
	
?>