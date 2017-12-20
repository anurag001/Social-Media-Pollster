<?php

	include_once('dbcon.php');
	global $pdo;
	if(!empty($_POST["topic_id"]))
	{
		
		$query = $pdo->prepare("select * from chat where chat_topic_id=?");
		$query->bindParam(1,$_POST["topic_id"]);	
		if($query->execute())
		{
			while($row = $query->fetch(PDO::FETCH_OBJ))
			{
				echo "<pre>".$row->chat_content."</pre><br><br>";
			}
		}
	}

?>