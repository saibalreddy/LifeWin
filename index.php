<?php include 'authentication.php';?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <link rel="shortcut icon" href="img/logo.ico" type="image/png" />
        <title>LifeWin - Habits to Success</title>

        <meta name="viewport" content="initial-scale=1, maximum-scale=1">
        <meta property="og:image" content="img/50by50.jpg"/>
	<link rel='shortcut icon' type='image/x-generic' href='/favicon.ico' />
        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <![endif]-->
        <meta charset="UTF-8">
        <meta name="author" content="Nitish Kumar">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>LifeWin - Habits to Success | Homepage</title>
        <link href="css/icomoon.css" rel="stylesheet" type="text/css">
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="css/style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="selection-error" style="display: none;"></div>
        <div class="selection-success" style="display: none;"></div>
        <div id="fb-root"></div>
        <div class="modal fade" id="login_signup_box">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 loginbox">
                                <h4 class="modal-title">Login to your account</h4>
                                <div class="form-group">
                                    <a href="fblogin.php" class="signin-fb btn btn-primary btn-fb">Login With Facebook</a>
                                    <a href="gmail_login.php" class="btn btn-danger btn-google">Login With Google</a>  
                                </div>

                                <div class="form-group">
                                    <img src="img/sep.png" alt="">
                                </div>
                                <div class="clearfix"></div>
                                <form method="post" name="userlogin" action="userLogin.php">
                                    <div class="form-group">
                                        <input id="email" class="form-control" type="text" name="email" title="Enter Email" placeholder="Email" onchange="jsemail()" pattern="([a-zA-Z0-9._-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z]+)*)" required autofocus>
                                        <span style="color:#e11" id="err-email"><?php echo $err['email']; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="password" id="password_login" placeholder="Password">
                                    </div>
                                    <div class="form-group text-left">
                                        <button type="submit" name="login" value="userlogin" class="btn btn-primary btnlogin">Login</button>
                                        <button type="submit" name="resetpass" value="resetpass" class="btn btn-danger btnresetpass">Reset Password</button>
                                        <p class="text-left pull-right"><a id="forgetPass" href="#">Forgot Password </a></p>
                                    </div>
                                </form>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 signup">
                                <h4 class="modal-title">Sign up</h4>
                                <form method="post" name="signup" action="signUp.php" onsubmit="return jssignup()">
                                    <div class="form-group">
                                    	<input type="text" class="form-control" id="fname" name="fname" title="Enter your First Name" placeholder="First Name" autofocus onchange="jsname()" style="text-transform:capitalize" pattern="^[A-Za-z][A-Za-z. ]+$" required>
                                    	<span class="error" id="err-name"><?php echo $err['fname']; ?></span>
                                    </div>
                                    <div class="form-group">
                                    	<input type="text" class="form-control" id="lname" name="lname" title="Enter your Last Name" placeholder="Last Name" autofocus onchange="jsname()" style="text-transform:capitalize" pattern="^[A-Za-z][A-Za-z. ]+$" required>
                                    	<span class="error" id="err-name"><?php echo $err['lname']; ?></span>
                                    </div> 
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" onchange="jsemail()" required>
                                        <span class="error" id="err-email"><?php echo $err['email']; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" id="password" name="password" title="Minimum 5 characters long" placeholder="Password" onchange="jspassword()" maxlength="20" pattern="^.{5,20}$" required>
                                        <span class="error" id="err-password"><?php echo $err['password']; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password" title="Re-enter yout password" onchange="jspassword()" maxlength="20" pattern="^.{5,20}$" required>
                                        <span class="error" id="err-password"><?php echo $err['password']; ?></span>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="signup" value="signup" class="btn btn-danger">Sign Up</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <header>
            <div id="headerNav">
                <div class="container">
                    <div class="row">
                        <nav class="navbar navbar-default" role="navigation">
                            <div class="container-fluid">
                                <!-- Brand and toggle get grouped for better mobile display -->
                                <div class="navbar-header col-md-3">
                                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-menu">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                    <h1 id="logo"><a href="http://lifewin.co/index.php"><img src="img/logo.png" height="65" width="135" alt="logo" ></a></h1>
                                </div>

                                <!-- Collect the nav links, forms, and other content for toggling -->
                                <div class="collapse navbar-collapse" id="bs-menu">
                                    <ul class="nav navbar-nav">
                                        <li class="active"><a href="index.php">Home</a></li>
                                        <li><a href="benefits.html">Benefits</a></li>
                                        <li><a href="solutions.html">Solutions</a></li>
                                        <li><a href="http://blog.lifewin.co">Blog</a></li>
                                    </ul>

                                    <ul class="nav navbar-nav navbar-right">
                                        <li><a href="#" data-toggle="modal" data-target="#login_signup_box">Signup/Login</a></li>
                                    </ul>
                                </div><!-- /.navbar-collapse -->
                            </div><!-- /.container-fluid -->
                        </nav>            
                    </div><!--row-->
                </div><!--container-->
            </div><!--headernav-->
        </header>
        <div style="color:red;"><?php if(isset($_SESSION['error'])) { echo $_SESSION['error']; unset($_SESSION['error']);}?></div>
        <div class="success-msg"><?php if(isset($_SESSION['success'])) { echo $_SESSION['success']; unset($_SESSION['success']);}?></div>
        <div class="clearfix"></div>

        <section id="banner">
            <div id="carousel-slider-top" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#carousel-slider-top" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-slider-top" data-slide-to="1"></li>
                    <li data-target="#carousel-slider-top" data-slide-to="2"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                    <div class="item active">
                        <img src="img/slide1.jpg" alt="Take Your First Ftep, Towards Productivity."/>
                        <div class="carousel-caption">
                            <h1>Take Your First Step<br>
                                Towards Productivity</h1>
                            <button class="btn1">Get Started!</button>
                        </div>
                    </div>

                    <div class="item">
                        <img src="img/slide2.jpg" alt="Get to Work, Enter the Zone."/>
                        <div class="carousel-caption">
                            <h1>Get to Work<br>
                                Realise Flow</h1>
                            <button class="btn1">Enter the Zone!</button>
                        </div>
                    </div>        

                    <div class="item">
                        <img src="img/slide3.jpg" alt=""/>
                        <div class="carousel-caption">
                            <h1>Change Your Life<br>
                                One Day at a time</h1>
                            <button class="btn1">Get Started!</button>
                        </div>
                    </div>    
                </div><!--carousel-inner-->
            </div>
        </section>

        <div class="clearfix"></div>

        <section id="home_devices">
            <div class="container">
                <div class="row">
                    <div class="device">
                        <div class="col-sm-6 col-md-5 col-md-offset-1">
                            <font size="48">
                            <span class="icon-file"></span>
                            <span class="icon-stopwatch"></span>
                            <span class="icon-checkmark"></span>
                            <!--Too many icons becoming overwhelming
                            <span class="icon-calendar"></span>
                            <span class="icon-alarm"></span>
                            <span class="icon-bars"></span>-->
                            </font>
                            <h4>Next Generation of Personal Productivity Apps</h4>
                            <p>Have something that you really want to do, but caught up with other stuff? Boost your productiviy by making them "Urgent" - or else you loose the game!</p><br>
                            <p>Procastration and unhealthy habits feels so good? With our subtle rewards and punishments, alter whats' a reward and whats' not!</p>
                        </div>

                        <div class="col-sm-6 col-md-5">
                            <img src="img/device.png" alt="" class="img-responsive"/>	
                        </div> 
                    </div><!--device--> 

                    <div class="clearfix"></div>

                    <div class="benefits">
                        <h2>Specialities</h2>
                        <div class="col-xs-6 col-sm-6 col-md-3">
                            <div class="thumbnail">
                                <div class="holder"> <img src="img/img1.png" alt="" class="img-responsive" /></div>
                                <div class="caption">
                                    <h4>Self Management</h4>
                                    <p>When you do self management, you will have more time than you know what to do with.
                                        - The 7 Habits of Highly Effective People</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-3">
                            <div class="thumbnail">
                                <div class="holder">  <img src="img/img2.png" alt="" class="img-responsive" /></div>
                                <div class="caption">
                                    <h4>Intrinsic Motivation</h4>
                                    <p>For the first time in world, a system and an app without External Pressures and Extrinsic Motivation, but your own Conscious and Internal Drive.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-3">
                            <div class="thumbnail">
                                <div class="holder"><img src="img/img3.png" alt="" class="img-responsive" /></div>
                                <div class="caption">
                                    <h4>Instant Gratification</h4>
                                    <p>Get awarded instantly with points and even free time for stuff you really want to do. What's more you will no longer feel rewarded for the your not-so-healty habits of Procastration and Fast food!</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-6 col-sm-6 col-md-3">
                            <div class="thumbnail">
                                <div class="holder"> <img src="img/img4.png" alt="" class="img-responsive" /></div>
                                <div class="caption">
                                    <h4>Success!</h4>
                                    <p>Self Control is the best determinant of success, no matter what are your financial and educational conditions,
                                        no matter how you measure success. 
                                        - Dan Ariely</p>
                                </div>
                            </div>
                        </div>                                                
                    </div><!--benefits-->          
                </div>
            </div><!--container-->

            <div class="signup_section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h2>What will you do to win?</h2>
                            <button class="btn1">Get Started!</button>

                        </div>
                    </div>
                </div>
            </div><!--signup section-->    

            <div class="clearfix"></div>
            <!--Testimonials, to be included, when the we have some {adding hide class will not show testimonial } -->
            <div class="container hide">
                <div class="row">
                    <div class="col-md-12">

                        <div class="home_testimonial">
                            <h2>What the users say</h2>
                            <div id="carousel-testimonial" class="carousel slide" data-ride="carousel">
                                <!-- Wrapper for slides -->

                                <div class="carousel-inner">
                                    <div class="item active">
                                        <img src="img/user1.png" alt="slide1" class="img-responsive" />
                                        <div class="carousel-caption_user">
                                            <h5>Jenna Sue</h5>
                                            <p>"Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. "</p>
                                        </div>
                                    </div>

                                    <div class="item">
                                        <img src="img/user1.png" alt="slide1" class="img-responsive" />
                                        <div class="carousel-caption_user">
                                            <h5>Jenna Sue</h5>
                                            <p>"Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. "</p>
                                        </div>
                                    </div>        

                                    <div class="item">
                                        <img src="img/user1.png" alt="slide1" class="img-responsive" />
                                        <div class="carousel-caption_user">
                                            <h5>Jenna Sue</h5>
                                            <p>"Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. "</p>
                                        </div>
                                    </div>    
                                </div><!--carousel-inner-->
                                <!-- Controls -->
                                <a class="left carousel-control" href="#carousel-testimonial" data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left"></span>
                                </a>
                                <a class="right carousel-control" href="#carousel-testimonial" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>    
        </section>

        <div class="clearfix"></div>

        <footer id="footer">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6 col-md-3">
                        <h3><a href="http://lifewin.co/">LifeWin</a></h3>
                        <p>A New Generation Personal Productivity App</p>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <h3>Company</h3>
                        <ul>
                            <li><a href="index.html">Home</a></li>
                            <li><a href="benefits.html">Benefits</a></li>
                            <li><a href="solutions.html">Solutions</a></li>
                            <li><a href="http://blog.lifewin.co">Blog</a></li>
                        </ul>
                    </div> 
                    <div class="col-sm-6 col-md-3">
                        <h3>About</h3>
                        <ul>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Terms & Condition</a></li>
                            <li><a href="#">Features</a></li>
                            <li><a href="#">FAQ's</a></li>
                        </ul>
                    </div> 
                    <div class="col-sm-6 col-md-3">
                        <h3> Social </h3>
                        <ul>
                            <li><a target="_blank" href="https://www.facebook.com/lifewinapp">
                                    <img src="img/fb.png" alt="LifeWin Facebook Page" class="img-responsive" />
                                    facebook.com/LifeWinApp
                                </a></li>
                            <li><a target="_blank" href="https://twitter.com/lifewinapp">
                                    <img src="img/twitter.png" alt="LifeWin Twitter Page" class="img-responsive" />
                                    twitter.com/LifeWinApp
                                </a></li>
                            <li><a target="_blank" href="http://www.reddit.com/r/lifewin/">
                                    <img src="img/reddit.png" alt="LifeWin sub-reddit" class="imag-responsive" height="32" width="32"/>
                                    reddit.com/r/LifeWin
                                </a></li>
                            <!--Link to Google Profile hidden, as we have none
        <li><a target="_blank" href="#"><img src="img/google.png" alt="" class="img-responsive" /></a></li>-->
                        </ul>
                    </div>                        
                </div>
            </div>
        </footer>


        <script type="text/javascript" charset="utf-8" src="js/jquery-2.0.3.min.js"></script> 
        <script type="text/javascript" charset="utf-8" src="js/bootstrap.min.js"></script> 
        <script type="text/javascript" charset="utf-8" src="js/custom.js"></script>
        <script type="text/javascript" charset="utf-8" src="js/jquery.flexisel.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $(document).on('click', '#forgetPass', function(event) {
                    event.preventDefault();
                    $('.btnlogin,#password_login').hide();
                    $('.btnresetpass').show();
                    $('#forgetPass').text('Sign In');
                    $('#forgetPass').addClass('signin');
                });
                $(document).on('click', '#forgetPass.signin', function(event) {
                    event.preventDefault();
                    $('.btnlogin,#password_login').show();
                    $('.btnresetpass').hide();
                    $('#forgetPass').text('Forgot Password');
                    $('#forgetPass').removeClass('signin');
                });
            });
            
            function alert_sucess(msg){
                $('.selection-success').html('<div class="alert alert-success">'+ msg +'</div>');
                $('.selection-success').fadeIn('slow');
                $('.selection-success').addClass('open');
                setTimeout(function(){
                    $('.selection-success').removeClass('open');
                    $('.selection-success').fadeOut('slow');
                    
                },2000);
            }
            function alert_error(msg){
                $('.selection-error').html('<div class="alert alert-danger">'+ msg +'</div>');
                $('.selection-error').fadeIn('slow');
                $('.selection-error').addClass('open');
                setTimeout(function(){
                    $('.selection-error').removeClass('open');
                    $('.selection-error').fadeOut('slow');
                     
                },2000);
            } 
        </script>
    </body>
</html>