<?php
	include_once('dbcon.php');
	if(!empty($_GET["question_id"]))
	{
		$questionId = $_GET["question_id"];
		$query =$pdo->prepare("select * from feed where id = ?");
		$query->bindParam(1,$questionId);
		$query->execute();
		$json = array();
		$iter=0;

		while($row = $query->fetch(PDO::FETCH_OBJ))
		{
			$json[$iter] = array(
				"yes_count" => $row->yes,
				"no_count" => $row->no,
				"male_yes_count" => $row->male_yes,
				"male_no_count" => $row->male_no
			);
			$iter++;
		}
		$jsonstring = json_encode($json);
		echo $jsonstring;
	}

?>