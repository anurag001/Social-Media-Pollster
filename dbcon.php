<?php
	try{
		$pdo=new PDO("mysql:host=localhost;dbname=yon",'root','');
	}
	catch(PDOException $ex)
	{
		echo $ex->getMessage();
		die();
	}

?>