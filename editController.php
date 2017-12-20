<?php

class editController
{
	public function editBio($user_id,$organisation,$lives_in,$status)
	{
		global $pdo;
		$organisation = htmlspecialchars($organisation);
		$lives_in = htmlspecialchars($lives_in);
		$status = htmlspecialchars($status);
		$last = date("Y-m-d h:i:s");
				
		$query = $pdo->prepare("update user set organisation=?,lives_in=?,status=?,last_seen=? where user_id=?");
		$query->bindParam(1,$organisation);
		$query->bindParam(2,$lives_in);
		$query->bindParam(3,$status);
		$query->bindParam(4,$last);
		$query->bindParam(5,$user_id);
		if($query->execute())
		{
			$msg ='<center><span style="color:green;"><b>Profile is updated successfully</b></span></center>';

		}
		else
		{
			$msg ='<center><span style="color:red;"><b>Error in updating profile</b></span></center>';
		}
		echo $msg;
	}

}
$editObject = new editController();
