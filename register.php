<?php

	include_once("accountController.php");
	if(!empty($_POST["email"]) && !empty($_POST["firstname"]) && !empty($_POST["lastname"]) && !empty($_POST["password"]))
	{
		$email = htmlspecialchars($_POST["email"]);
		$firstname = htmlspecialchars($_POST["firstname"]);
		$lastname = htmlspecialchars($_POST["lastname"]);
		$gender = htmlspecialchars($_POST["gender"]);
		$password = htmlspecialchars($_POST["password"]);

		if($gender == "male" or $gender=="female")
		{
			$accountObject->register($email,$firstname,$lastname,$password,$gender);
		}
		else
		{
			$msg ='<span style="color:red;"><b>Wrong input of gender value</b></span>';
		}
	}

?>