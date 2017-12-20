<?php
include_once('dbcon.php');
// if(empty($_SESSION["user_id"]))
// {
// 	echo '<script>window.location.href="./main.php";</script>';
// }
// $user_id = $_SESSION["user_id"];

class feedController
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
		return $string ? implode(',', $string) . ' ago' : 'just now';
	}

	public function feedLoad()
	{
		global $pdo;	
		if(!empty($_SESSION["user_id"]))
		{
			$user_id = $_SESSION["user_id"];
		}
		//user interest
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
		
		$json = array();
		$k=0;

		if($index>0)
		{
			for($interest_iter=0;$interest_iter<$index;$interest_iter++)
			{
				$query = $pdo->prepare("select * from feed where category_id=? order by id desc");
				$query->bindParam(1,$interests[$interest_iter]);
				if($query->execute())
				{
					while($row = $query->fetch(PDO::FETCH_OBJ))
					{
						$json[$k] = array(
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
						$k++;
					}
				}
			}
			$jsonstring = json_encode($json);
			return $jsonstring;
		}
		else
		{
			$query = $pdo->prepare("select * from feed order by id desc");
			if($query->execute())
			{
				while($row = $query->fetch(PDO::FETCH_OBJ))
				{
					$json[$k] = array(
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
					$k++;
				}
			}
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
		global $user_id;
		
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
		$query = $pdo->prepare("select firstname,profile_pic,profile_pic_ext from user where user_id=?");
		$query->bindParam(1,$user_id);
		$query->execute();
		$userData = $query->fetch(PDO::FETCH_OBJ);
		$name = $userData->firstname;
		$profile_pic = $userData->profile_pic;
		$profile_pic_ext = $userData->profile_pic_ext;
		$time=time();
		$query = $pdo->prepare("insert into opinion(opinion_by,opinionist,opinionist_pic,opinionist_pic_ext,question_id,opinion,time) values(?,?,?,?,?,?,?)");
		$query->bindParam(1,$user_id);
		$query->bindParam(2,$name);
		$query->bindParam(3,$profile_pic);
		$query->bindParam(4,$profile_pic_ext);
		$query->bindParam(5,$questionId);
		$query->bindParam(6,$opinion);
		$query->bindParam(7,$time);
		if($query->execute())
		{

			$opinion = $pdo->prepare("update feed set opinion=opinion+1 where id=?");
			$opinion->bindParam(1,$questionId);
			$opinion->execute();
		}
				
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
		global $user_id;
		foreach ($data as $opinion) 
		{
			$path = "uploads/".$opinion->opinion_by."/";


		echo'<div class="comments" id="opinionSet'.$opinion->id.'">
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
					<div class="sender-name">
						<a href="./profile.php?id='.htmlspecialchars($opinion->opinion_by).'"> '.htmlspecialchars($opinion->opinionist).'</a><br>
					</div>
					<div class="comment-time">
						<span>'.$this->time_elapsed_string('@'.$opinion->time).'</span>
					</div>
					<div class="comment-delete">';
						if($user_id == $opinion->opinion_by)
						{
					
						echo'<i class="fa fa-remove" onclick="opinionRemove('.$opinion->question_id.','.$opinion->opinion_by.','.$opinion->id.')"></i>';
						}
				echo'</div>
					<div class="comment-text">
						<pre>'.htmlspecialchars($opinion->opinion).'</pre>
					</div>
					<div class="comment-likes">';

					$checkLikeFlag = $this->checkLike($opinion->id);
					if(!empty($user_id))
					{
?>
						<i style="cursor:pointer;" class="fa fa-thumbs-up <?php if($checkLikeFlag==1){echo 'like';}?>" id="likeBtn<?php echo $opinion->id;?>" onclick="checkLike(<?php echo $opinion->id;?>)"></i>&nbsp;<span id="like<?php echo $opinion->id;?>"><?php echo $opinion->likes;?></span>
<?php
					}
					else
					{
						echo'<i class="fa fa-thumbs-up"  id="likeBtn'.$opinion->id.'"></i>&nbsp;<span id="like'.$opinion->id.'">'.$opinion->likes.'</span>';
					}

				echo'</div>
				</div>						
			</div>';

		}
		
	}


	public function feedView()
	{
		$data = $this->feedLoad();
		$data = json_decode($data);
		global $user_id;
		
		foreach ($data as $item) 
		{
			echo'<div class="post-container" id="'.$item->id.'">
					<div class="post-question" >
						<span class="content-wrap-view"><b><a  href="question.php?qid='.$item->id.'">'.htmlspecialchars($item->question).'</a></b></span>
					</div>';
				if(!empty($item->question_pic))
				{
					$picture = "uploads/".$item->question_by."/".$item->question_pic.".".$item->question_pic_ext; 
					echo'<div class="post-image">
							<img src="'.$picture.'">
						</div>';
				}
					$maleYes = $item->male_yes;
					$femaleYes = $item->yes - $maleYes;
					$maleNo = $item->male_no;
					$femaleNo = $item->no - $maleNo;
					$flag = $this->yesnoCheck($user_id,$item->id);

?>
					<div class="poll-button-container">
						<button id="yesBtn<?php echo $item->id; ?>" onclick="yesnoCheck(<?php echo $item->id.",";?>'yes')" class="yes btn <?php if($flag==1){echo 'btn-success';} ?>">Yes</button>
						<button id="noBtn<?php echo $item->id; ?>" onclick="yesnoCheck(<?php echo $item->id.",";?>'no')" class="no btn <?php if($flag==2){echo 'btn-danger';} ?>">No</button>
					</div>
<?php
				echo'<div class="post-details">
						<div class="yes-count">Yes : <span id="yes'.$item->id.'">'.$item->yes.'</span></div>
						<div class="no-count">No : <span id="no'.$item->id.'">'.$item->no.'</span></div>
						<div class="comment-count" style="cursor:pointer;" onclick="opinionView('.$item->id.')"><i class="fa fa-comment-o"></i> : <span id="opinion'.$item->id.'">'.$item->opinion.'</span></div>
						<div id="menu'.$item->id.'" class="triple-dot-menu-container" onblur="menuBlur(this)" onfocus="menuFocus(this)" tabindex="-1">
							<div id="triple_dot'.$item->id.'" class="triple-dot">
								<span></span>
								<span></span>
								<span></span>
							</div>
							<div id="triple_dot_menu'.$item->id.'" class="triple-dot-menu">';
						if($user_id == $item->question_by)
						{

							echo'<div class="edit-question" data-toggle="modal" data-target="#EditQuestionModal'.$item->id.'"><i class="fa fa-pencil"></i>Edit</div>
								<div class="delete-question" onclick="removeQuestion('.$item->id.','.$item->question_by.')"><i class="fa fa-close"></i>Delete</div>';
						}

							echo'<div class="fb-share-question" onclick="shareFB('.$item->id.')"><i class="fa fa-facebook"></i>Share on FB</div>
								<div class="twitter-share-question">
									<a href="https://twitter.com/share"
										data-text="custom share text"
										data-url="question.php?qid='.$item->id.'"
										data-hashtags="yesyano"
										data-via="yesyano"
										data-related="'.$item->question.'"><i class="fa fa-twitter"></i>Share on Twitter</a>
								</div>
								<div class="report-question"><a href="report.php?qid='.$item->id.'" target="_blank"><i class="fa fa-ban"></i>Report</a></div>';
						echo'</div>
						</div>
					</div>';

				echo'<div class="question-comments-container">
						<div class="comments-container" id="opinionView'.$item->id.'">
							<form id="opinionForm'.$item->id.'" method="post">
								<textarea name="opinion_text" id="opinion-text'.$item->id.'" placeholder="Write your opinion.." rows="4" required></textarea>
								<div class="comment-post-button">
									<button id="opinionBtn'.$item->id.'" class="btn btn-primary" onclick="opinionSubmit('.$item->id.')">Give Opinion</button>
								</div>
							</form>
						</div>
						<div class="comments-container-text" id="opinionViewList'.$item->id.'">
						</div>
					</div>
				</div>';
						
			if($user_id == $item->question_by)
			{
				//Edit Question Modal
			echo'<div class="modal fade" id="EditQuestionModal'.$item->id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">Edit your Question</h4>
							</div>
							<div class="modal-body">
								<form method="post" id="editQuestionForm'.$item->id.'">
									<textarea id="question" name="question" class="form-control" required>'.htmlspecialchars($item->question).'</textarea>
									<input type="hidden" name="question_by" value="'.$item->question_by.'">
									<input type="hidden" name="question_id" value="'.$item->id.'">
									<input type="submit" onclick="editQuestion('.$item->id.')" class="btn btn-primary" id="editBtn'.$item->id.'" value="Edit">
								</form>
								</br>
								<div id="editQuestionInfo'.$item->id.'"></div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>';
			}
			
		}
?>
	<script type="text/javascript">

		var number=0;
		function yesnoCheck(questionId, state)
		{
			$.ajax({
				type:"post",
				url:"./yesnoCheck.php",
				data:"questionId="+questionId,
				success: function(data){
					number=data;
					yesno(questionId,state);
				},
				error:function()
				{
					alert("Unable to send request due to Poor Internet Connection");
				}
			});
		}

		function yesno(id,state)
		{
			$("#yesBtn"+id).addClass('disabled');
			$("#noBtn"+id).addClass('disabled');
			var bool = number;
			$.ajax({
				type:"POST",
				url:"./yesno.php",
				data:"id="+id+"&bool="+bool+"&state="+state,
				beforeSend:function()
				{
				},
				success: function(){

					var yes = $("#yes"+id).html();
					var no = $("#no"+id).html();

					if(bool==0)
					{
						if(state=="yes")
						{
							yes++;
							$("#yesBtn"+id).addClass('btn-success');
						}
						else if(state=="no")
						{
							no++;
							$("#noBtn"+id).addClass('btn-danger');
							
						}
					}
					else
					{
						if(bool==1)
						{
							if(state=="no")
							{
								no++;
								yes--;
								$("#yesBtn"+id).removeClass('btn-success');
								$("#noBtn"+id).addClass('btn-danger');
								
							}
							else
							{
								yes--;
								$("#yesBtn"+id).removeClass('btn-success');
							}
						}
						else if(bool==2)
						{
							if(state=="yes")
							{
								yes++;
								no--;
								$("#noBtn"+id).removeClass('btn-danger');
								$("#yesBtn"+id).addClass('btn-success');
								
							}
							else
							{
								no--;
								$("#noBtn"+id).removeClass('btn-danger');
							}
						}
					}
					$("#yesBtn"+id).removeClass('disabled');
					$("#noBtn"+id).removeClass('disabled');
					$("#yes"+id).html(yes);
					$("#no"+id).html(no);

				},
				error: function(data)
				{
					alert("Unable to send request due to Poor Internet Connection");
				},
				complete:function()
				{
				}
			});
		}

		function opinionView(questionId)
		{
			$.ajax({
				type:"post",
				url:"./opinionView.php",
				data:"questionId="+questionId,
				beforeSend:function()
				{
				},
				success: function(data)
				{
					$("#opinionViewList"+questionId).html(data);
				},
				error:function(data)
				{
					alert(data);
					alert("Unable to send request due to Poor Internet Connection");
				},
				complete:function()
				{
				}
			});
		}

		
		function opinionSubmit(questionId)
		{
				$("#opinionBtn"+questionId).addClass('disabled');
				var opinion = $("#opinion-text"+questionId).val();
				if(opinion!="" && opinion.length>0)
				{
					$.ajax({
						type:"post",
						url:"./opinionSubmit.php",
						data:"opinion="+opinion+"&question_id="+questionId,
						cache:false,
						processData:false,
						async:false,
						beforeSend:function()
						{
						},
						success: function(data)
						{
							$("#opinionBtn"+questionId).removeClass('disabled');
							$("#opinionForm"+questionId).find('input[name="opinion"]').val("");
							var opinionCount = parseInt($("#opinion"+questionId).html());
							opinionCount +=1;
							$("#opinion"+questionId).html(opinionCount);
							$("#opinion-text"+questionId).val("");
						},
						error:function(data)
						{
							alert(data);

						},
						complete:function()
						{
							opinionView(questionId);
						}
					});
				}
				else
				{
					alert("Please give your opinion");
					$("#opinionBtn"+questionId).removeClass('disabled');
				}
		}

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
						console.log(opinionCount);
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

		function editQuestion(questionId)
		{
			$("#editQuestionForm"+questionId).on("submit",function(e){
				e.preventDefault();
				$("#editBtn"+questionId).addClass('disabled');
				var formData = $(this).serialize();
				$.ajax({
					type:"POST",
					url:"./editQuestion.php",
					data:formData,
					beforeSend:function()
					{
					},
					success: function(data)
					{
						$("#editBtn"+questionId).removeClass('disabled');
						$("#editQuestionInfo"+questionId).html(data);
					},
					error:function()
					{
						alert("Unable to send request due to Poor Internet Connection");
					},
					complete:function()
					{
					}
				});
			});
		}

		function removeQuestion(questionId,questionBy)
		{
			if(confirm("Do you want to delete this Question?")==true)
			{
				var formData = "questionId="+questionId+"&questionBy="+questionBy;
				$.ajax({
					type:"POST",
					url:"./removeQuestion.php",
					data:formData,
					beforeSend:function()
					{
					},
					success: function(data)
					{
						$("#"+questionId).fadeOut("slow");
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
				cache:false,
				async:false,
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

		

		function shareFB(questionId)
		{
				FB.ui({
					method: 'share',
					href: './question.php?qid='+questionId,
				}, function(response){});
			
		}

	</script>
<?php

	}


}
$feedObject = new feedController();
