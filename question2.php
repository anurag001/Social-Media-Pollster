<?php
	include_once('dbcon.php');
	if(!is_numeric($_GET["qid"]) || empty($_GET["qid"]))
	{
		echo '<script>window.location.href="./error.php";</script>';
		die();
	}
	$questionId = $_GET["qid"];
	$sessionFlag=0;
	session_start();
	if(!empty($_SESSION["user_id"]))
	{
		$user_id = $_SESSION["user_id"];
		$sessionFlag=1;
	}
	else
	{
		$deviceId = $_SERVER['HTTP_USER_AGENT'];
		$anonym = $pdo->prepare("select * from anonymous_user where device_id=?");
		$anonym->bindParam(1,$deviceId);
		$anonym->execute();
		if($anonym->rowCount()==0)
		{
		
				echo '
				<!-- Modal -->
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="false">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				          <span aria-hidden="true">&times;</span>
				        </button>
				      </div>
				      <div class="modal-body">
				        It seems you are anonymous user.If you are not registered,we want some information.We are glad if you will provide these.

				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				        <button type="button" class="btn btn-primary">Save changes</button>
				      </div>
				    </div>
				  </div>
				</div>';
		}

	}


	include_once("questionController.php");
	$data = $questionObject->questionLoad($questionId);
	$data = json_decode($data);
	
	$id = $data->id;
	$question = $data->question;
	$question_pic = $data->question_pic;
	$question_pic_ext = $data->question_pic_ext;
	$question_by = $data->question_by;
	$yes = $data->yes;
	$no = $data->no;
	$maleYes = $data->male_yes;
	$maleNo = $data->male_no;
	$opinion = $data->opinion;
	$time = $data->time;

?>
<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?php echo $question; ?></title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="https://use.fontawesome.com/1685ebbb24.js"></script>
		<link href="./css/style.css" rel="stylesheet">
		<link href="./css/style-home.css" rel="stylesheet">
		<script type="text/javascript" src="./js/script-home.js"></script>
		<style>
			.like{
				color:#108fdd;
			}
			pre{
			    white-space: pre-wrap;       /* Since CSS 2.1 */
			    white-space: -moz-pre-wrap;  /* Mozilla, since 1999 */
			    white-space: -pre-wrap;      /* Opera 4-6 */
			    white-space: -o-pre-wrap;    /* Opera 7 */
			    word-wrap: break-word;       /* Internet Explorer 5.5+ */
			}
			.content-wrap-view{
			    white-space: pre-wrap;       /* Since CSS 2.1 */
			    white-space: -moz-pre-wrap;  /* Mozilla, since 1999 */
			    white-space: -pre-wrap;      /* Opera 4-6 */
			    white-space: -o-pre-wrap;    /* Opera 7 */
			    word-wrap: break-word;       /* Internet Explorer 5.5+ */
			}

		</style>
	</head>
	<body>
		
		<div class="header">		
			<a href="./logout.php" class="btn btn-danger" id="logout">Logout</a>		
		</div>
		<br>

<?php

		echo "<div class='content-wrap-view'><b>".htmlspecialchars($question)."</b></div><br>"; 
		if(!empty($question_pic))
		{
			$picture = "uploads/".$question_by."/".$question_pic.".".$question_pic_ext; 
			echo'<div class="post-image">
					<img src="'.$picture.'">
				</div><br>';
		}
		
		if($sessionFlag==1)
		{
			$flag = $questionObject->yesnoCheck($user_id,$id);
?>
			<br>
			<button id="yesBtn<?php echo $id; ?>" onclick="yesnoCheck(<?php echo $id.",";?>'yes')" class="btn <?php if($flag==1){echo 'btn-success';} ?>">Yes</button>
			<button id="noBtn<?php echo $id; ?>" onclick="yesnoCheck(<?php echo $id.",";?>'no')" class="btn <?php if($flag==2){echo 'btn-danger';} ?>">No</button>

<?php
		}
					
				
		echo'<div class="post-likes">
				<i class="yes">Yes <span id="yes'.$id.'">'.$yes.'</span></i>
				<i class="no">No <span id="no'.$id.'">'.$no.'</i>
				<i class="fa fa-comments-o"> <span id="opinion'.$id.'">'.$opinion.'</span></i>';
			if($sessionFlag==1 && $user_id == $question_by)
			{
			echo'<i class="fa fa-pencil-square-o" data-toggle="modal" data-target="#EditQuestionModal'.$id.'"></i>
				<i class="fa fa-times" onclick="removeQuestion('.$id.','.$question_by.')"></i>
				<i class="fa fa-facebook-square"></i>';
			}
		echo'</div>';
						
						
		if($sessionFlag==1 && $user_id == $question_by)
		{
			//Edit Question Modal
			echo'<div class="modal fade" id="EditQuestionModal'.$id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">Edit your Question</h4>
							</div>
							<div class="modal-body">
								<form method="post" id="editQuestionForm'.$id.'">
									<textarea id="question" name="question" class="form-control" required>'.htmlspecialchars($question).'</textarea>
									<input type="hidden" name="question_by" value="'.$question_by.'">
									<input type="hidden" name="question_id" value="'.$id.'">
									<input type="submit" onclick="editQuestion('.$id.')" class="btn btn-primary" id="editBtn'.$id.'" value="Edit">
								</form>
								</br>
								<div id="editQuestionInfo'.$id.'"></div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>';
		}

?>
	<br><hr>
	<div class="question-comments-container">
		<div class="comments-container" id="opinionView22">
<?php
                            if($sessionFlag==1)
                            {
                            echo'<form id="opinionForm'.$id.'" method="post">
                                <textarea name="opinion_text" id="opinion-text'.$id.'" placeholder="Write your opinion.." rows="4" required></textarea>
                                <button id="opinionBtn'.$id.'" class="btn btn-primary" onclick="opinionSubmit('.$id.')">Give Opinion</button>
                                </form>';
                            }
?>
        </div>
        <div class="comments-container-text" id="opinionView<?php echo $id;?>">
        	
        </div>
    </div>
	</body>
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
					error: function(data){
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
					type:"POST",
					url:"./questionOpinionView.php",
					data:"questionId="+questionId,
					beforeSend:function()
					{
					},
					success: function(data)
					{
						$("#opinionView"+questionId).html(data);
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

			function editQuestion(questionId)
			{
				$("#editQuestionForm"+questionId).on("submit",function(e){
					e.preventDefault();
					$("#editBtn"+questionId).addClass('disabled');
					var formData = $(this).serialize();
					//console.log(formData);
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
							alert("Your question is deleted");
							window.location.href="./home.php";
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
			window.onload = function(){
				opinionView(<?php echo $id;?>);
			};
	</script>
</html>