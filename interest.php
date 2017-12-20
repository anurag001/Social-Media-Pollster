<?php
	session_start();
	if(empty($_SESSION["user_id"]))
	{
		echo '<script>window.location.href="./main.php";</script>';
	}
	$user_id = $_SESSION["user_id"];
	include_once('dbcon.php');
	global $pdo;
	$query = $pdo->prepare("select * from interest");
	$query->execute();


?>
<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Yon | Interests</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
	<div class="container">
	<h2>Please select your topics of interest : </h2>
<?php
	
	$checkQuery = $pdo->prepare("select * from user_interest where user_id=?");
	$checkQuery->bindParam(1,$user_id);
	$checkQuery->execute();
	$interests = array();
	$index=0;
	if($checkQuery->rowCount()>0)
	{
		while($interest_row = $checkQuery->fetch(PDO::FETCH_OBJ))
		{
			if(!in_array($interest_row->user_interest_id,$interests))
			{
				$interests[$index]=$interest_row->user_interest_id;
				$index++;
			}
		}
	}

	while($row = $query->fetch(PDO::FETCH_OBJ))
	{
		if(in_array($row->interest_id, $interests))
		{
			echo '<label>'.$row->interest_name.'&nbsp;<input type="checkbox" id="'.$row->interest_id.'" onclick="decide('.$row->interest_id.')" checked="checked"></label>';
		}
		else
		{
			echo '<label>'.$row->interest_name.'&nbsp;<input type="checkbox" id="'.$row->interest_id.'" onclick="decide('.$row->interest_id.')" ></label>';
		}
		echo '<br>';
	}

?><br>

	<a href="./home.php" class="btn btn-success">Go back</a>
	</div>
	</body>
	<script type="text/javascript">
		function decide(id)
		{
			if($("#"+id).is(':checked')==true)
			{
				$.ajax({
					type:"POST",
					url:"./add_interest.php",
					data:"interest_id="+id,
					beforeSend:function()
					{
					},
					success: function(data){
					},
					error: function(data){
					},
					complete:function()
					{
					}
				});
			}
			else
			{
				$.ajax({
					type:"POST",
					url:"./remove_interest.php",
					data:"interest_id="+id,
					beforeSend:function()
					{
					},
					success: function(data){
					},
					error: function(data){
					},
					complete:function()
					{
					}
				});
			}
			
		}

	</script>
</html>