<!doctype html>
<HTML>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <HEAD>
        <link rel="shortcut icon" href="img/logo.ico" type="image/png" />
        <title>LifeWin - Habits to Success</title>
        <link rel="stylesheet" href="css/jquery-ui.css">
        <script src="js/jquery-2.0.3.min.js"></script>
        <script src="js/jquery-ui.js"></script>
        <script src="js/jquery.ui.touch-punch.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/shield.css">
        <link rel="stylesheet" type="text/css" href="custom.css">
        <script src="js/goal.js"></script>
        <script src="js/stopwatch.js"></script>
		<script type = "text/javascript">
			$(document).ready(function(){
				$('.start_btn').click(function(){
					localStorage.setItem("worktime",$('.work').val());
					localStorage.setItem("resttime",$('.rest').val());
					//var one = JSON.parse(localStorage.getItem("worktime"));
					//var two = JSON.parse(localStorage.getItem("resttime"));
					//console.log(one + " " + two);
				});
			});
		</script>
</head>
<body>
	<div class = "container">
		<div class = "row">
			<div class = "col-md-4" style ="position:relative;margin: 0 auto;float:none">
			<h2 style = "text-align:center;margin-top:20px;">Set your time </h2>
				<h4 style = "position:absolute;right:-120px;top:80px;">Current Time Set is <script>document.write(JSON.parse(localStorage.getItem("worktime")));</script> min(s)</h4><input type = "number" class = "work form-control" placeholder = "Work Time">
				<h4 style = "position:absolute;right:-120px;top:125px;">Current Time Set is <script>document.write(JSON.parse(localStorage.getItem("resttime")));</script> min(s)</h4>
										<input type = "number" class = "rest form-control" placeholder = "Break Time">
										<button title = "" type = "button" class = "btn btn-primary start_btn form-control" style = "left:50%;margin-left:-50px;">Set Times</button>
			</div>
		</div>
	</div>
</body>
</html>		