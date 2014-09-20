<?php
include 'authentication.php';
require 'fbconfig.php';
session_start();

//Facebook Login Check. Instructions given at: https://developers.facebook.com/docs/facebook-login/manually-build-a-login-flow/v2.0
//if access is denied, go back to the landing page
if ($_GET["error"] == "access_denied")
    header("Location: /");
else {
//Save the code received from facebook
    $code = $_GET["code"];
//Get access_token from Facebook
//$access_token = readfile("https://graph.facebook.com/oauth/access_token?client_id=834481703238074&redirect_uri=http://lifewin.co/app.php&client_secret=347633e603fd132fd38abaca14034e01&code=$code");
//$access_token= substr((string)$access_token,13,-1);
//echo $access_token;
}
?>
<?php //print_r($_SESSION); ?>
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
        <script src="js/moment.min.js"></script>
        <!--<script src="angularJS/angular.min.js"></script>-->
		<script src="js/shield.js" type = "text/javascript"></script>
        <script type="text/javascript">
        
        
        $('.progress_div').show();
            $(document).ready(function() {
                $('[title]').tooltip();
				 $('#sidebar .nav li').click(function(e) {
					$('#sidebar .nav li').removeClass('active');
						var $this = $(this);
						if (!$this.hasClass('active')) {
							$this.addClass('active');
					}
				});			
            });
            $(document).on('click', '.stop_fix', function() {
                $('.icon-stopwatch').removeClass('running');
                $('.icon-clock').removeClass('running');
            });
			$(document).on('click', '.icon-stopwatch', function() {
                $(this).addClass('running');
                $(".colorchange").css('color', 'rgb(124,175,255)'); 
				$('.progress_div').show();
            });
            $(document).on('click', '.icon-clock', function() {
                $(this).addClass('running');
                $(".colorchange").css('color', 'rgb(124,175,255)'); 
				$('.progress_div').show();
            });

            function alert_sucess(msg) {
                $('.selection-success').html('<div class="alert alert-success">' + msg + '</div>');
                $('.selection-success').fadeIn('slow');
                $('.selection-success').addClass('open');
                setTimeout(function() {
                    $('.selection-success').removeClass('open');
                    $('.selection-success').fadeOut('slow');

                }, 2000);
            }
            function alert_error(msg) {
                $('.selection-error').html('<div class="alert alert-danger">' + msg + '</div>');
                $('.selection-error').fadeIn('slow');
                $('.selection-error').addClass('open');
                setTimeout(function() {
                    $('.selection-error').removeClass('open');
                    $('.selection-error').fadeOut('slow');

                }, 2000);
            }
        </script>
        <script>
            if (localStorage.getItem("list") === null) {
                localStorage.setItem("background", bg1);
            }
            if (localStorage.getItem("background") == bg1) {
                document.getElementById("maincontentofwebsite").style.background = "url(img/bg1.jpg)";
            }
            if (localStorage.getItem("background") == bg2) {
                document.getElementById("maincontentofwebsite").style.background = "url(img/bg2.jpg)";
            }
            if (localStorage.getItem("background") == bg3) {
                document.getElementById("maincontentofwebsite").style.background = "url(img/bg3.jpg)";
            }
            if (localStorage.getItem("background") == bg4) {
                document.getElementById("maincontentofwebsite").style.background = "url(img/bg4.jpg)";
            }
            if (localStorage.getItem("background") == bg5) {
                document.getElementById("maincontentofwebsite").style.background = "url(img/bg5.jpg)";
            }
            if (localStorage.getItem("background") == bg6) {
                document.getElementById("maincontentofwebsite").style.background = "url(img/bg6.jpg)";
            }
        </script>
		<script>
			$(document).ready(function(){
				  var timer = null,
            startTime = null,
            progress = $("#progress").shieldProgressBar({
                min: 0,
                max: 1500,
                value: 1500,
                layout: "circular",
                layoutOptions: {
                    circular: {
                        width: 10,
                        borderWidth: 0,
                        color: "#f37a5d"
                    }
                },
                text: {
                    enabled: true,
                    template: '<span style="font-size:20px;">{0:n}</span>'
                },
                reversed: true,
            }).swidget();
        $(".icon-clock").shieldButton({
            events: {
                click: function () {
                    clearInterval(timer);
                    startTime = Date.now();
                    timer = setInterval(updateProgress, 100);
                    $(".colorchange").css('color', 'rgb(124,175,255)'); 
                }
            }
        });
        $(".pause_btn").shieldButton({
            events: {
                click: function () {
                $(".colorchange").css('color', 'rgb(0,0,0)');
                    clearInterval(timer);
                }
            }
        });
        function updateProgress() {
            var remaining = 1500 - (Date.now() - startTime) / 1000;
            progress.value(remaining);
            if (remaining <= 0) {
                clearInterval(timer);
            }
        }

            stopwatch = $("#progress").shieldProgressBar({
                min: 0,
                max: 3600,
                value: 0,
                layout: "circular",
                layoutOptions: {
                    circular: {
                        width: 10,
                        borderWidth: 0,
                        color: "#f37a5d"
                    }
                },
                text: {
                    enabled: true,
                    template: '<span style="font-size:20px;">{0:n}</span>'
                },
            }).swidget();
        $(".icon-stopwatch").shieldButton({
            events: {
                click: function () {
                    clearInterval(timer);
                    startTime = Date.now();
                    timer = setInterval(updatestopwatch, 100);
                    $(".colorchange").css('color', 'rgb(124,175,255)'); 
                }
            }
        });
        $(".pause_btn").shieldButton({
            events: {
                click: function () {
                $(".colorchange").css('color', 'rgb(0,0,0)');
                    clearInterval(timer);
                }
            }
        });
        function updatestopwatch() {
            var remaining = (Date.now() - startTime) / 1000;
            stopwatch.value(remaining);
            if (remaining >= 3600) {
                clearInterval(timer);
            }
        }
    });
    </script>
    <!-- This code prevents timer from closing -->
    <script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '.dropdown-menu', function (e) {
            e.stopPropagation(); 
        });
        $(document).on('click', '.did-it', function (e) {
            $(".did-it").css('color', 'rgb(124,175,255)');
            $(".did-it").css('font-weight', 'bold');
            jQuery('.tick_img').each(function() {
   $(this).prepend('<img src="img/tick.png" class="png-over user_img" />') 
    
});
        }); 
    });
    </script>
    </HEAD>
    <BODY>
        <div class="selection-error" style="display: none;"></div>
        <div class="selection-success" style="display: none;"></div>
        <!-- Popover when a list item is clicked -->
        <!-- SideBar From: http://bootply.com/88026 -->
        <div class="page-container">
            <header>
                <div id="headerNav">
                    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
                        <div class="container">
                     <div class="row">
                         <!-- Brand and toggle get grouped for better mobile display -->
                            <div class="navbar-header col-xs-2">
                                    <h1 id="logo"><a href="http://lifewin.co/index.php"><img src="img/logo.png" height="65" width="135" alt="logo" ></a></h1>

                            </div>
								
                                <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="col-xs-10">
                               <ul class="nav navbar-nav navbar-right desktop">
										<!-- For the timer 
										<li><a href="#" class="did-it tick_img"><?php echo "<img class=\"user_img\"src='img/circle.png' />"; ?><span >Yes! I did it.</span></a></li> -->
										<li><a onclick="list('Winstate');" href="#">Yes! I Did It!</a></li>
										<li >
										<a href="#" class="dropdown-toggle icon-plus" data-toggle="dropdown">
											<span data-placement="bottom" title="Show Timer" class="colorchange">+ Timer </span></a>
											<ul class="dropdown-menu timer-wrapper keep_open" style=" 
    padding: 5px;
" >
                                        		
									<div class="btn-group">
										<button title="" type="button" class="btn btn-default b_fix icon-stopwatch" onclick="start(0);" data-original-title="Stopwatch"></button>
										<button title="" type="button" class="btn btn-default b_fix icon-clock" onclick="start(1);" data-original-title="Timer"></button>
									</div>
                                                

									<div class = "time_div form-control">
									<span id="time" class="form-control">00:00:00</span>
									<span id="timeelapsed" class="form-control">00:00:00</span>
									<div class = "progress_div">
										<div id = "progress">
											
										</div>
									</div>
								</div>
                                            
												<button type="button" class="glyphicon glyphicon-pause pause_btn" onclick="stop();" onmouseout="this.blur();"data-original-title="Pause" title=""></button>
								<button type="button" class="glyphicon glyphicon-refresh pause_btn" onclick="reset(1);" onmouseout="this.blur();"data-original-title="Reset" title=""></button>
								<div class = "clearfix"></div>
                                            </ul>
										</li>
										
                                        <li><a href="#"><span data-placement="bottom" title="Daily Points" id="daily"></span></a></li>
                                        <li><a href="#"><span data-placement="bottom" title="Weekly Points" id="weekly"></span></a></li>
                                        <li><a href="#" class="dropdown-toggle icon-plus" data-toggle="dropdown">
												<span data-placement="bottom" title="Total Points"> + Points </span> 
											</a>
                                            <ul class="dropdown-menu">
                                                <li data-toggle="modal" data-target="#quickadd"><a href="#">Enter Value</a></li>
                                                <li class="divider"></li>
                                                <li><a onclick="addPoints(2);" href="#">2 points</a></li>
                                                <li><a onclick="addPoints(5);" href="#">5 points</a></li>
                                                <li><a onclick="addPoints(10);" href="#">10 points</a></li>
                                            </ul>
                                        </li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            <?php echo "<img class=\"user_img\" src='https://graph.facebook.com/$fbid/picture' />"; ?>
                                                <span id="username"><?php echo $fbuname ?></span>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="#"><span class="glyphicon glyphicon-cog"></span>Settings</a></li>
                                                <li><a href="#" class="sync-btn"><span class="glyphicon glyphicon-refresh rotate"></span>Sync</a></li>
                                                <li><a href="logout.php"><span class="glyphicon glyphicon-off"></span>Logout</span></a></li>
                                            </ul>
                                        </li>
                                        <li class="hiddenclass">
                                            <div class="navbar-header input-group">
                                                <span class="input-group-btn hiddenclass">
                                                    <button type="button" class="navbar-toggle btn btn-default" data-toggle="offcanvas" data-target=".sidebar-nav">
                                                        <span class="icon-bar"></span>
                                                        <span class="icon-bar"></span>
                                                        <span class="icon-bar"></span>
                                                    </button>
                                                </span>
                                                <h2 class="navbar-brand hide" id="listname"></h2>

                                            </div>
                                        </li>
                                    </ul>
									
									<!-- <ul class="nav navbar-nav navbar-right pull-right mobile_device">
										<li> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> +show </a>
											
                                        </li>
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            <?php echo "<img class=\"user_img\" src='https://graph.facebook.com/$fbid/picture' />"; ?>
                                                <span id="username"><?php echo $fbuname ?></span>
                                            </a>  
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a href="#"><span class="glyphicon glyphicon-cog"></span>Settings</a></li>
                                                <li><a href="#"><span class="glyphicon glyphicon-refresh"></span>Sync</a></li>
                                                <li><a href="logout.php"><span class="glyphicon glyphicon-off"></span>Logout</span></a></li>
                                            </ul>
                                        </li>

										</li>
										<li class="hiddenclass">
                                            <div class="navbar-header input-group">
                                                <span class="input-group-btn hiddenclass">
                                                    <button type="button" class="navbar-toggle btn btn-default" data-toggle="offcanvas" data-target=".sidebar-nav">
                                                        <span class="icon-bar"></span>
                                                        <span class="icon-bar"></span>
                                                        <span class="icon-bar"></span>
                                                    </button>
                                                </span>
                                                <h2 class="navbar-brand hide" id="listname"></h2>

                                            </div>
                                        </li>
									</ul> -->
								
                                </div>

                            </div>
                        </div><!-- /.container -->
                    </nav>            

                </div><!--headernav-->
            </header>
<style>
					.input-group .suggestion { display:none; }
					.input-group input[type=text]:focus + .suggestion { display:block; } 
					.suggestion { position: absolute; width:150px; color:#fff; background:#000; top:35px; padding:5px; }
					.content-wrap { max-height:60%; overflow:hidden; position:relative;top:75px}
				</style>
            <!-- top navbar. Fixed on top of the screen even when scrolling down-->

            <div class="container content-wrap">
                <div class="row row-offcanvas row-offcanvas-left">
                    <!-- sidebar -->
                    <div class="col-xs-12 col-sm-3 col-md-3 sidebar-offcanvas sidebar-position"  role="navigation" style="width:15%">
                        <div id="sidebar">
                            <ul class="nav nav-pills nav-stacked">
                                <!-- class="active" and "sidebar-brand" to be used properly -->
								<li class="active"><a onclick="list('Tasks');" href="#"><span data-placement="right" title="Show/Add Tasks">Tasks</span></a></li>
                                <li><a onclick="list('Goals');" href="#">Goals</a></li>
                                <li><a onclick="list('Dailies');" href="#">Daily</a></li>
                                <li><a onclick="list('Scoreboard');" href="#">Scoreboard</a></li>
                            </ul>
                            
                        
                    </div>
                </div>
                <div class="cols-xs-9 col-sm-9 col-md-9" style="width:85%; margin-top:-75px">

                    <div class="navbar navbar-default hide" role="navigation">
                        <div class="container-head">
                            <!--Navbar modified with use of inputgroup buttons From: http://getbootstrap.com/components/#input-groups-->

                        </div>
                    </div>
					
                    <!-- Main Content of the whole website -->
                    <div class="inner-content-wrapper">
                        <form id="input" onSubmit="save(); return false;" >
                            <!-- Input styling From: http://getbootstrap.com/components/#input-groups -->
                            <div class="input-group">
                                <input type="text" class="form-control" name="newEntry" id="newEntry" placeholder="New Goal">
								<span class="suggestion"> Add your new Task </span>
								
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" onClick="save();
                                                return false;">+ ADD</button></span>
                            </div>
                        </form>
                        <!--1. Doesn't gets included in goalsNames 2. No list item can be dragged above -->
                        <ul class="sortable list-group">
                            <li class="tags list-group-item" id="tag0">
                                <!--Collapse/Show List Icons removed - they were confusing the users - users think that clicking on them will reveal what they are to do for the day
                                <span id="tagIcon0"></span>-->
                                <!--Sperate span for the text because otherwise the "badge" class span would get deleted!-->
                                <span id="firstTag"></span>
                                <span id="tagCount0" class="badge"></span>
                            </li>
                        </ul>
                        <!--"list-group" class is a requirement for bootstrap-->
                        <ul id="list" class="sortable list-group"></ul>
                    </div>

                </div>
            </div>
        </div>
        <!-- Footer to have the QuickAdd, Timer, Stopwatch, Meassage Text and Stop buttons -->
        <div class="footer hide">
            <div class="container">
                <!--From: http://getbootstrap.com/components/#input-groups -->
                <div class="input-group">
                    <span class="input-group-btn">
                        <button  type="button" class="btn btn-default b_fix icon-stopwatch" onclick="start(0);">
                            <!-- Halfling used earlier
                            <span class="glyphicon glyphicon-time"></span>-->
                        </button>
                    </span>
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default b_fix icon-clock" onclick="start(1);">
                            <!-- Halfling used earlier
                            <span class="glyphicon glyphicon-bell"></span>-->
                        </button>
                    </span>
                    <span id="time" class="form-control"></span>
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-default b_fix stop_fix" onclick="stop();" onmouseout="this.blur();">STOP</button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!-- QuickAdd Implemented using Modal from: http://getbootstrap.com/javascript/#modals -->
    <div class="modal fade" id="quickadd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Quick Add</h4>
                </div>
                <div class="modal-body">
                    <form id="quickAdd" >
                        <input type="number" min="0" class="form-control" name="quickadd" id="points" placeholder="Points to Add">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="addPoints('quickAdd');" data-dismiss="modal">Save</button> <!--Send Message to addPoints() function to check the 	quickAdd's form's value -->
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</BODY>
</HTML>