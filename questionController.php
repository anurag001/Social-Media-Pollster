<?php
include_once('dbcon.php');

class questionController
{

	public function time_elapsed_string($datetime, $full = false) 
	{
		$now = new DateTime;
		$ago = new DateTime($datetime);
		$diff = $now->diff($ago);

		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;

		$string = array(
			'y' => 'year',
			'm' => 'month',
			'w' => 'week',
			'd' => 'day',
			'h' => 'hour',
			'i' => 'minute',
			's' => 'second',
		);
		foreach ($string as $k => &$v) 
		{
			if ($diff->$k) 
			{
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
			} else 
			{
				unset($string[$k]);
			}
		}

		if (!$full) $string = array_slice($string, 0, 1);
		return $string ? implode(', ', $string) . ' ago' : 'just now';
	}

	public function questionLoad($questionId)
	{
		global $pdo;	
		$query = $pdo->prepare("select * from feed where id=? ");
		$query->bindParam(1,$questionId);
		if($query->execute())
		{
			$json = array();
			$row = $query->fetch(PDO::FETCH_OBJ);
			
			$json = array(
				"id" => $row->id,
				"question" => $row->question,
				"question_pic" => $row->question_pic,
				"question_pic_ext" => $row->question_pic_ext,
				"question_by" => $row->question_by,
				"yes" => $row->yes,
				"no" => $row->no,
				"male_yes" => $row->male_yes,
				"male_no" => $row->male_no,
				"opinion" => $row->opinion,
				"time" => $row->time
			);
			
			$jsonstring = json_encode($json);
 			return $jsonstring;
		}	
	}

	public function yesnoCheck($user_id,$question_id)
	{
		global $pdo;
		$checkQuery = $pdo->prepare("select status_id from yesno where user_id=? and question_id=?");
		$checkQuery->bindParam(1,$user_id);
		$checkQuery->bindParam(2,$question_id);
		$checkQuery->execute();
		if($checkQuery->rowCount()>0)
		{
			$row = $checkQuery->fetch(PDO::FETCH_OBJ);
			//1-yes
			//2-no
			return $row->status_id;
		}
		else
		{
			return 0;
		}
	}

	public function checkLike($opinionId)
	{
		global $pdo;
		@session_start();
		if(!empty($_SESSION["user_id"]))
		{
			$user_id = $_SESSION["user_id"];
		}

		$query = $pdo->prepare("select * from likes where like_by=? and opinion_id=?");
		$query->bindParam(1,$user_id);
		$query->bindParam(2,$opinionId);
		$query->execute();
		if($query->rowCount()>0)
		{
			return 1;
		}
		else
		{
			return 0;
		}
		
	}

	public function opinionSubmit($questionId,$opinion)
	{
		global $pdo;
		global $user_id;
		
		$opinion = htmlspecialchars($opinion);
		$query = $pdo->prepare("select firstname,profile_pic,profile_pic_ext from user where user_id=?") ;
		$query->bindParam(1,$user_id);
		$query->execute();
		$userData = $query->fetch(PDO::FETCH_OBJ);
		$name = $userData->firstname;
		$profile_pic = $userData->profile_pic;
		$profile_pic_ext = $userData->profile_pic_ext;

		$time=time();
		$query = $pdo->prepare("insert into opinion(opinion_by,question_id,opinionist,opinionist_pic,opinionist_pic_ext,opinion,time) values(?,?,?,?,?,?,?)");
		$query->bindParam(1,$user_id);
		$query->bindParam(2,$questionId);
		$query->bindParam(3,$name);
		$query->bindParam(4,$profile_pic);
		$query->bindParam(5,$profile_pic_ext);
		$query->bindParam(6,$opinion);
		$query->bindParam(7,$time);
		$query->execute();

		$opinion = $pdo->prepare("update feed set opinion=opinion+1 where id=?");
		$opinion->bindParam(1,$questionId);
		$opinion->execute();
				
	}

	public function opinionLoad($questionId)
	{
		global $pdo;
		global $user_id;
		$query = $pdo->prepare("select * from opinion where question_id =? order by likes desc,id desc");
		$query->bindParam(1,$questionId);
		if($query->execute())
		{
			$json = array();
			$k=0;
			while($row = $query->fetch(PDO::FETCH_OBJ))
			{
				$json[$k] = array(
					"id" => $row->id,
					"question_id" => $row->question_id,
					"opinion_by" => $row->opinion_by,
					"opinion" => $row->opinion,
					"opinionist" => $row->opinionist,
					"opinionist_pic" => $row->opinionist_pic,
					"opinionist_pic_ext" => $row->opinionist_pic_ext,
					"time" => $row->time,
					"likes" => $row->likes
				);
				$k++;
			}
			$jsonstring = json_encode($json);
 			return $jsonstring;
		}		
	}

	public function opinionView($questionId)
	{
		$data = $this->opinionLoad($questionId);
		$data = json_decode($data);
		session_start();
		if(!empty($_SESSION["user_id"]))
		{
		 	$user_id=$_SESSION["user_id"];
		}

		foreach ($data as $opinion) 
		{
			$path = "uploads/".$opinion->opinion_by."/";


		echo'<div class="comments" id="opinionSet'.$opinion->id.'">
				<div class="comments">
					<div class="comments-profile-pic">';
?>
						<img src="<?php 
							if(is_null($opinion->opinionist_pic))
							{
								echo 'img/profile.svg'; 
							} 
							else
							{
								echo $path.$opinion->opinionist_pic.".".$opinion->opinionist_pic_ext;
							}
						?>" class="img-rounded">
<?php
				echo'</div>
					<div class="comment-text-container">
						<div>
							<a href="./profile.php?id='.htmlspecialchars($opinion->opinion_by).'"> '.htmlspecialchars($opinion->opinionist).'</a>
						</div>
						<div class="comment-time">
							<span>'.$this->time_elapsed_string('@'.$opinion->time).'</span>
						</div>';
					if(!empty($user_id) && $user_id == $opinion->opinion_by)
					{
					
						echo'<div class="comment-delete"><i class="fa fa-remove" onclick="opinionRemove('.$opinion->question_id.','.$opinion->opinion_by.','.$opinion->id.')"></i></div>';
					}
                 	echo'<div class="comment-text">
                            <pre>'.htmlspecialchars($opinion->opinion).'</pre>
                        </div>';
                        if(!empty($user_id))
					{
						$checkLikeFlag = $this->checkLike($opinion->id);
?>
						<div class="comment-likes"><i style="cursor:pointer;" class="fa fa-thumbs-up <?php if($checkLikeFlag==1){echo 'like';}?> " id="likeBtn<?php echo $opinion->id;?>" onclick="checkLike(<?php echo $opinion->id;?>)"></i>&nbsp;<span id="like<?php echo $opinion->id;?>"><?php echo $opinion->likes;?></span></div>
<?php
					 }
					else
					{
						echo'<div class="comment-likes"><i style="cursor:pointer;" class="fa fa-thumbs-up" id="likeBtn'.$opinion->id.'"></i>&nbsp;<span id="like'.$opinion->id.'">'.$opinion->likes.'</span></DIV>';
					}
				echo'</div>
				</div>
			</div>';
				
		}
?>

<script type="text/javascript">
	
	function opinionRemove(questionId,opinionBy,opinionId)
	{
		if(confirm("Do you want to delete your Opinion?")==true)
		{
			var formData = "opinionId="+opinionId+"&questionId="+questionId+"&opinionBy="+opinionBy;
			$.ajax({
				type:"POST",
				url:"./removeOpinion.php",
				data:formData,
				beforeSend:function()
				{
				},
				success: function()
				{
					$("#opinionSet"+opinionId).fadeOut("slow");
					var opinionCount = $("#opinion"+questionId).html();
					opinionCount = opinionCount - 1;
					$("#opinion"+questionId).html(opinionCount);
				},
				error:function()
				{
					alert("Unable to send request due to Poor Internet Connection");
				},
				complete:function()
				{
				}
			});
		}
	}

	var likeFlag=0;

	function checkLike(opinionId)
	{
		$.ajax({
			type:"post",
			url:"./checkLike.php",
			data:"opinionId="+opinionId,
			success: function(data){
				likeFlag=data;
				opinionLike(opinionId,likeFlag);
			},
			error:function()
			{
				alert("Unable to send request due to Poor Internet Connection");
			}
		});
	}

	function opinionLike(opinionId,likeFlag)
	{
		var formData = "opinionId="+opinionId+"&likeFlag="+likeFlag;
		$.ajax({
			type:"POST",
			url:"./opinionLike.php",
			data:formData,
			beforeSend:function()
			{
			},
			success: function()
			{
				var likeCount = parseInt($("#like"+opinionId).html());
				if(likeFlag==0)
				{
					likeCount = likeCount + 1;
					$("#likeBtn"+opinionId).addClass('like');
				}
				else
				{
					likeCount = likeCount - 1;
					$("#likeBtn"+opinionId).removeClass('like');
				}
				$("#like"+opinionId).html(likeCount);
			},
			error:function()
			{
				alert("Unable to send request due to Poor Internet Connection");
			},
			complete:function()
			{
			}
		});
		
	}

	

</script>

<?php
		
	}

}

$questionObject = new questionController();
?>