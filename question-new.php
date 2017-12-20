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
                            <?php if($sessionFlag==1)
                                {
                                    $flag = $questionObject->yesnoCheck($user_id,$id);
                            ?>
                            <button id="yesBtn<?php echo $id; ?>" onclick="yesnoCheck(<?php echo $id.",";?>'yes')" class="btn <?php if($flag==1){echo 'btn-success';} ?>">Yes</button>
                            <button id="noBtn<?php echo $id; ?>" onclick="yesnoCheck(<?php echo $id.",";?>'no')" class="btn <?php if($flag==2){echo 'btn-danger';} ?>">No</button>
                            <?php } ?>
                            
                        </div>
                        
                       <?php echo '<div class="post-details">
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
                                    <div class="fb-share-question"><i class="fa fa-facebook"></i>Share on FB</div>
                                    <div class="twitter-share-question">
                                        <a href="https://twitter.com/share" data-text="custom share text" data-url="" data-hashtags="yesyano" data-via="yesyano" data-related="Are girls always seek for attention?"><i class="fa fa-twitter"></i>Share on Twitter</a>
                                    </div>
                                    <div class="report-question"><a href="report.php?qid=22" target="_blank"><i class="fa fa-ban"></i>Report</a></div></div>
                            <?php echo "</div>" ?>
                        </div>
                        <div class="question-comments-container">
                            <div class="comments-container" id="opinionView22">
                                <form method="post">
                                    <textarea name="opinion_text" placeholder="Write your opinion.." rows="4" required=""></textarea>
                                    <div class="comment-post-button">
                                        <button class="btn btn-primary">Give Opinion</button>
                                    </div>
                                </form>
                            </div>
                            <div class="comments-container-text">
                                <div class="comments" id="opinionSet35">
				                    <div class="comments-profile-pic">
                                        <img src="uploads/23/150179565237693cfc748049e45d87b8c7d8b9aacd.jpg" class="img-rounded">
                                    </div>
                                    <div class="comment-text-container">
                                        <div class="sender-name">
                                            <a href="./profile.php?id=23"> Emma</a><br>
                                        </div>
                                        <div class="comment-time">
                                            <span>just now</span>
                                        </div>
                                        <div class="comment-delete"><i class="fa fa-remove" onclick="opinionRemove(21,23,35)"></i></div>
                                        <div class="comment-text">
                                            <pre>asd</pre>
                                        </div>
                                        <div class="comment-likes"><i style="cursor:pointer;" class="fa fa-thumbs-up " id="likeBtn35" onclick="checkLike(35)"></i>&nbsp;<span id="like35">0</span>
                                        </div>
                                    </div>						
			                     </div>
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
                
            </div>
            </body>
            <script>
                
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
