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

    include_once("profileController.php");
    $data = profileDetails($user_id);
    $data = json_decode($data);
    // echo gettype($data);
    //json_decode converts string to object
    
    if (is_object($data))
    {
        $firstname = $data->firstname;
        $lastname = $data->lastname;
        $organisation = $data->organisation;
        $lives_in = $data->lives_in;
        $status = $data->status;
        $since = $data->since;
        $last_seen = $data->last_seen;
        $profile_pic = $data->profile_pic;
        $pic_ext = $data->pic_ext;
    }

?>
<!DOCTYPE html>
    <html lang="en-US">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Yon | Home</title>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
            <script src="https://use.fontawesome.com/1685ebbb24.js"></script>
            <link href="./css/style.css" rel="stylesheet">
            <link href="./css/style-question.css" rel="stylesheet">
            <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.min.js"></script>
            <!--<link href="./css/style-home.css" rel="stylesheet">-->
        </head>
        
        
        <body onload="getData()">
            <?php include "header.php";?>
            
            <div class="question-main-container positioner">
                <div class="extra-padding col-lg-1"></div>
                
                <div class="question-display-container col-lg-7">
                    
                    <div class="question-container">    
                        <div class="question-text">
<?php
                            echo "<div class='content-wrap-view'><b>".htmlspecialchars($question)."</b></div>";
?>
                        </div>
<?php
                            if(!empty($question_pic))
                            {
                                $picture = "uploads/".$question_by."/".$question_pic.".".$question_pic_ext; 
                                echo'<div class="question-image">
                                        <img src="'.$picture.'">
                                    </div><br>';
                            }
?>
                        
                        <div class="poll-button-container">
 <?php             
                            if($sessionFlag==1)
                            {
                                $flag = $questionObject->yesnoCheck($user_id,$id);
?>
                                <br>
                            <button id="yesBtn<?php echo $id; ?>" onclick="yesnoCheck(<?php echo $id.",";?>'yes')" class="btn <?php if($flag==1){echo 'btn-success';} ?>">Yes</button>
                            <button id="noBtn<?php echo $id; ?>" onclick="yesnoCheck(<?php echo $id.",";?>'no')" class="btn <?php if($flag==2){echo 'btn-danger';} ?>">No</button>
<?php
                            }
?>
                        </div>
                        
<?php 
                    echo'<div class="post-details">
                            <i class="yes">Yes <span id="yes'.$id.'">'.$yes.'</span></i>
                            <i class="no">No <span id="no'.$id.'">'.$no.'</i>
                            <i class="fa fa-comment-o"> <span id="opinion'.$id.'">'.$opinion.'</span></i>'; ?>
                            <div class="triple-dot-menu-container" onblur="menuBlur(this)" onfocus="menuFocus(this)" tabindex="-1">
                                <div class="triple-dot">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                                <div class="triple-dot-menu">
<?php
                            if($sessionFlag==1 && $user_id == $question_by)
                            {
                                echo'<i class="fa fa-pencil-square-o" data-toggle="modal" data-target="#EditQuestionModal'.$id.'"></i>
                                     <i class="fa fa-times" onclick="removeQuestion('.$id.','.$question_by.')"></i>';
                            }
                            

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
                                <div class="fb-share-question"><i class="fa fa-facebook"></i>Share on FB</div>
                                <div class="twitter-share-question">
                                    <a href="https://twitter.com/share" data-text="custom share text" data-url="" data-hashtags="yesyano" data-via="yesyano" data-related="Are girls always seek for attention?"><i class="fa fa-twitter"></i>Share on Twitter</a>
                                </div>
                                <div class="report-question"><a href="report.php?qid=22" target="_blank"><i class="fa fa-ban"></i>Report</a></div></div>
                            </div>
                        </div>
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
                    </div>
                </div>

                    <div class="extra-padding col-lg-1"></div>
                    
                    <div class="stats-small-container col-lg-4">
                        <div class="stats-image">
                            <canvas id="myChart"></canvas>
                        </div>
                        <div class="stats-button">
                            <button class="btn btn-success show-stats">View full stats</button>
                        </div>
                    </div>
                    
                    <div class="more-stats">
                        <div class="more-stats-body">
                            <div class="canvas-container">
                                <canvas id="myChart2"></canvas>
                            </div>
                        </div>
                        <div class="stats-close"><i class="fa fa-close"></i></div>
                    </div>

            

        </body>
        <script>
                
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
                getData();
            };

                

                function menuFocus(obj)
                {
                    $("#"+obj.id).find(".triple-dot-menu").show(200);
                }

                function menuBlur(obj)
                {
                    setTimeout(function(){
                    $("#"+obj.id).find(".triple-dot-menu").hide(200);
                    $(this).parent().blur();}, 500);
                }

                
                
                $(".triple-dot-menu").click(function(){
                    setTimeout(function(){$(this).hide(200);
                    $(this).parent().blur();}, 200);
                });

       
                            
                function getData()
                {
                    var qid = <?php echo $_GET['qid'] ?>;
                    console.log(qid + " reached myFUnc");
                        $.ajax({
                        url:"./questionDetails.php?question_id="+qid,
                        beforeSend:function()
                        {
                        },
                        success: function(data){
                            obj = JSON.parse(data);
                            console.log(data);
                            drawChart(obj);
                        },
                        error: function(data){

                        },
                        complete:function()
                        {
                        }
                     })
                }
                
                
                function drawChart(obj)
                {
                    console.log("chsrt");
                    var yes = obj[0].yes_count;
                    var no = obj[0].no_count;
                    var ctx = document.getElementById("myChart").getContext('2d');
                    var data = {
                        datasets: [{
                            data: [yes, no],
                            backgroundColor: [
                                    'rgba(255,99,132,1)',
                                    'rgba(54, 162, 235, 1)'
                                ],
                                borderColor: [
                                    'rgba(255,99,132,1)',
                                    'rgba(54, 162, 235, 1)'
                                ],
                                borderWidth: 1
                        }],

                        // These labels appear in the legend and in the tooltips when hovering different arcs
                        labels: [
                            'Yes',
                            'No'
                        ]
                    };
                    var myDoughnutChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: data
                    });
                    
                    moreStats(obj);
                }
                
                
               </script>
            
            <script>
                
                
                function moreStats(obj)
                {
                    var m_yes = obj[0].male_yes_count;
                    var m_no = obj[0].male_no_count;
                    var f_yes = obj[0].yes_count - m_yes;
                    var f_no = obj[0].no_count - m_no;
                    
                    
                    var ctx = document.getElementById("myChart2").getContext('2d');
                    var data = {
                        datasets: [{
                            data: [m_yes, m_no, f_yes, f_no],
                            backgroundColor: [
                                    'rgba(255,99,132,1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)'
                                ],
                                borderColor: [
                                    'rgba(255,99,132,1)',
                                    'rgba(54, 162, 235, 1)',
                                    'rgba(75, 192, 192, 1)',
                                    'rgba(153, 102, 255, 1)'
                                ],
                                borderWidth: 1
                        }],

                        // These labels appear in the legend and in the tooltips when hovering different arcs
                        labels: [
                            'Male Yes',
                            'Male No',
                            'Female Yes',
                            'Female No'
                        ]
                    };
                    var myDoughnutChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: data
                    });
                    
                }
                
                
                $(".show-stats").click(function(){
                    $(".more-stats").fadeIn(300);
                });
                
                $(".stats-close").click(function(){
                    $(".more-stats").fadeOut(300);
                });
            </script>
    </html>
