<?php

	include_once('dbcon.php');
	function profileDetails($id)
	{
		global $pdo;
		$query=$pdo->prepare("select * from user where user_id = ?");
		$query->bindParam(1,$id);
		$query->execute();
		$json = array();
		if($query->rowCount()>0)
		{
			$row = $query->fetch(PDO::FETCH_OBJ);
			$json = array(
				"firstname" => $row->firstname,
				"lastname" => $row->lastname,
				"organisation" => $row->organisation,
				"lives_in" => $row->lives_in,
				"status" => $row->status,
				"profile_pic" => $row->profile_pic,
				"since" => $row->since,
				"last_seen" => $row->last_seen,
				"email" => $row->email,
				"pic_ext" => $row->profile_pic_ext
			);
			$jsonstring = json_encode($json);
 			return $jsonstring;
		}
		else
		{
			echo '<script>window.location.href="./error.php";</script>';
		}
		

	}

?>
