<?php

	include_once("accountController.php");
	if(!empty($_POST["logemail"]) && !empty($_POST["logpass"]))
	{
		$email = $_POST["logemail"];
		$password = $_POST["logpass"];
		$accountObject->signin($email,$password);
	}

?>