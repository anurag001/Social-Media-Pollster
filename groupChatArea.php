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
		<link href="./css/style-home.css" rel="stylesheet">
		<script type="text/javascript" src="./js/script-home.js"></script>
		<style>
		pre{
		    white-space: pre-wrap;       /* Since CSS 2.1 */
		    white-space: -moz-pre-wrap;  /* Mozilla, since 1999 */
		    white-space: -pre-wrap;      /* Opera 4-6 */
		    white-space: -o-pre-wrap;    /* Opera 7 */
		    word-wrap: break-word;       /* Internet Explorer 5.5+ */
		}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="row" style="height:300px;width:100%;overflow:auto;" id="chat-display">

			</div>
			<div class="row">
				<form method="post" id="chat-form">
					<textarea class="form-control" id="chat-content" name="chat_content"></textarea>
					<br>
					<input type="hidden" id="chat-topic-id" name="chat_topic_id" value=1>
					<br>
					<button class="btn btn-info" id="submit">Send</button>
				</form>
				<br>
				<div id="chat-info"></div>
			</div>
		</div>
	</body>
	<script type="text/javascript">

		function pullChat(topicId)
		{
			$.ajax({
				type:"POST",
				url:'./chatView.php',
				data:"topic_id="+topicId,
				beforeSend:function()
				{
					$("#chat-display").html();
				},
				success: function(data){
					$("#chat-display").html(data);
					
				},
				error: function(data){
					$("#chat-info").html('<span style="color:red;"><b>Error in connecting to server! Please try after sometime</b></span>');
				},
				complete:function()
				{
				}
			});
		}

		$("#chat-form").on("submit",function(e){
			e.preventDefault();
			var url = "./chatSubmit.php";
			var formData = new FormData($(this)[0]);
			if($("#chat-content").val()!="")
			{
				var topicId = $("#chat_topic_id").val();
				$.ajax({
					type:"POST",
					url:url,
					data:formData,
					beforeSend:function()
					{
						$("#chat-info").html();
					},
					success: function(data){
						$("#chat-info").html(data);
						$("#chat-content").val("");
						setTimeout(function(){
							$("#chat-info").html(""); 
						}, 3000);
					},
					error: function(data){
						$("#chat-info").html('<span style="color:red;"><b>Error in connecting to server! Please try after sometime</b></span>');
					},
					complete:function()
					{
						pullChat(topicId);
					}
				});

			}
			else
			{
				$("#chat-info").html("Please enter something"); 
				setTimeout(function(){
					$("#chat-info").html(""); 
				}, 3000);
			}
		});

		var topicid = $("#chat-topic-id").val();
		setInterval(function(){	pullChat(topicid); }, 3000);

	</script>
</html>