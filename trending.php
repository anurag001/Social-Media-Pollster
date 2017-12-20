<?php

	include_once('dbcon.php');
	global $pdo;
	$trend = array();
	$i=0;
	$query = $pdo->prepare("select * from feed ");
	$query->execute();
	while($row = $query->fetch(PDO::FETCH_OBJ))
	{
		$yes = $row->yes;
		$no = $row->no;
		$opinion = $row->opinion*1.5;
		$total = $yes+$no+$opinion;
		$questionTime = $row->time;
		$currentTime = time();
		$differenceTime = $currentTime - $questionTime;

		$value[$i] = $total;
		$period[$i] = $differenceTime;
		$factor[$i] = $total/$differenceTime;

		$trend[$i] = array(
			"question_id"=>$row->id,
			"value" => $total,
			"period" => $differenceTime,
			"trending_factor" => $factor[$i],
			"question" => $row->question
		);

		$i++;

	}

	function sortByTrending($a, $b)
	{
	    $a = $a['trending_factor'];
	    $b = $b['trending_factor'];

	    if ($a == $b) return 0;
	    return ($a > $b) ? -1 : 1;
	}
	usort($trend, 'sortByTrending');

	

	for($r=0;$r<8;$r++)
	{
		//echo $trend[$r]["value"]." ".$trend[$r]["trending_factor"]."<br>".$trend[$r]["question"]."<br>";
		//$position = strpos($trend[$r]["question"],' ',200);

		echo '<div class="trending-question">';
		echo '<a title="'.$trend[$r]["question"].'" href="question.php?qid='.$trend[$r]["question_id"].'">'.substr($trend[$r]["question"],0,40).'...</a><br>';
		echo '</div>';
	}
	
	
	
?>