<!DOCTYPE html>
<!--[if lt IE 8 ]><html class="no-js ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="no-js ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 8)|!(IE)]><!--><html class="no-js" lang="en"> <!--<![endif]-->
    <head>

        <!--- Basic Page Needs
        ================================================== -->
        <meta charset="utf-8">
        <title>Welcome</title>
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Mobile Specific Metas
        ================================================== -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <!-- CSS
    ================================================== -->
        <link rel="stylesheet" href="css/default.css">
        <link rel="stylesheet" href="css/layout.css">
        <link rel="stylesheet" href="css/media-queries.css">

        <!-- Script
        ================================================== -->
        <script src="js/modernizr.js"></script>

        <!-- Favicons
             ================================================== -->
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon"> 

    </head>

    <body onload="infoNotFound()">

        <!-- Header
        ================================================== -->
        <header>

            <div class="row">

                <div class="twelve columns">

                    <div class="logo">
                        <a href="index.php"><img alt="" src="images/logo.png"></a>
                    </div>

                    <nav id="nav-wrap">

                        <a class="mobile-btn" href="#nav-wrap" title="Show navigation">Show navigation</a>
                        <a class="mobile-btn" href="#" title="Hide navigation">Hide navigation</a>

                        <ul id="nav" class="nav">

                            <li><a href="about.html">About</a></li>


                        </ul> <!-- end #nav -->

                    </nav> <!-- end #nav-wrap -->

                </div>

            </div>

        </header> <!-- Header End -->

        <!-- Intro Section
        ================================================== -->
        <section id="intro">

            <!-- Flexslider Start-->
            <div id="intro-slider" class="flexslider">

                <ul class="slides">

                    <!-- Slide -->
                    <li>
                        <div class="row">
                            <div class="twelve columns">
                                <div class="slider-text">
                                    <h1>Sign In<span>.</span></h1>
                                    <p id="warn">Enter Your Account Information</p>
                                    <div id="contact-form">

                                        <!-- form -->
                                        <form name="login-form" id="login-form" method="post" action="forms/checkuser.php">
                                            <fieldset>

                                                <div class="half">
                                                    <label id="username-signin" for="contactName" style="color:whitesmoke">Username</label>
                                                    <input name="username" type="text" id="username" size="35" value="" />
                                                </div>

                                                <div class="half pull-right">
                                                    <label id="password-signin" for="contactEmail" style="color:whitesmoke">Password</label>
                                                    <input name="password" type="password" id="password" size="35" value="" />
                                                </div>
                                                <div>
                                                    <button type="button" id="signin">Enter</button>
                                                    <span id="image-loader">
                                                        <img src="images/loader.gif" alt="" />
                                                    </span>
                                                    <button type="button" id="flex-next-signup">Sign Up Here</button>
                                                    <span id="image-loader">
                                                        <img src="images/loader.gif" alt="" />
                                                    </span>
                                                </div>

                                            </fieldset>
                                        </form> <!-- Form End -->

                                        <!-- contact-warning -->
                                        <div id="message-warning"></div>
                                        <!-- contact-success -->
                                        <div id="message-success">
                                            <i class="icon-ok"></i>Your message was sent, thank you!<br />
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </li>

                    <!-- Slide -->
                    <li>
                        <div class="row">
                            <div class="twelve columns">
                                <div class="slider-text">
                                    <h1>Register<span>.</span></h1>
                                    <p id="rwarn"></p>
                                    <span id="username-error"></span>
                                    <span id="password-error"></span>
                                    <span id="email-error"></span>
                                    <span id="confirm-error"></span>

                                    <div id="contact-form">

                                        <!-- form -->
                                        <form name="register-form" id="register-form" method="post" action="forms/register.php">
                                            <fieldset>
                                                <div class="half">
                                                    <label id="email-signup" style="color:whitesmoke">Email</label>
                                                    <input name="email" type="email" id="remail" size="35" value="" />
                                                </div>
                                                <div class="half pull-right">
                                                    <label id="username-signup" for="contactName" style="color:whitesmoke">Username</label>
                                                    <input name="username" type="text" id="rusername" size="35" value="" />
                                                </div>

                                                <div class="half">
                                                    <label id="password-signup" for="contactEmail" style="color:whitesmoke">Password</label>
                                                    <input name="password" type="password" id="rpassword" size="35" value="" />
                                                </div>
                                                <div class="half pull-right">
                                                    <label id="cpassword-signup" style="color:whitesmoke">Confirm Password</label>
                                                    <input name="cpassword" type="password" id="cpassword" size="35" value="" />
                                                </div>

                                                <div>
                                                    <button id="signup" type="button">Sign Up</button>
                                                    <span id="image-loader">
                                                        <img src="images/loader.gif" alt="" />
                                                    </span>
                                                    <button type="button" id="flex-prev-signin">Go Back</button>
                                                    <span id="image-loader">
                                                        <img src="images/loader.gif" alt="" />
                                                    </span>
                                                </div>

                                            </fieldset>
                                        </form> <!-- Form End -->

                                        <!-- contact-warning -->
                                        <div id="message-warning"></div>
                                        <!-- contact-success -->
                                        <div id="message-success">
                                            <i class="icon-ok"></i>Your message was sent, thank you!<br />
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </li>

                </ul>

            </div> <!-- Flexslider End-->

        </section> <!-- Intro Section End-->


        <!-- Works Section
        ================================================== -->



        <!-- footer
        ================================================== -->
        <footer >

            <div class="row">

                <div class="twelve columns">

                   
                    <ul class="footer-social">
                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                        <li><a href="#"><i class="fa fa-skype"></i></a></li>
                        <li><a href="#"><i class="fa fa-rss"></i></a></li>
                    </ul>

                    <ul class="copyright">
                        <!--<li>&copy; 2014 Sparrow</li> -->
                        <li>Copyrights @2014 <a href="#">Debate.</a></li>
                        <li><a rel="nofollow" href="#">Joseph El Khoury </a> And <a rel="nofollow" href="#">Mohamed Atie </a> </li>
                    </ul>

                </div>

                <div id="go-top" style="display: block;"><a title="Back to Top" href="#">Go To Top</a></div>

            </div>

        </footer> <!-- Footer End-->

        <!-- Java Script
        ================================================== -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/jquery-1.10.2.min.js"><\/script>')</script>
        <script type="text/javascript" src="js/jquery-migrate-1.2.1.min.js"></script>

        <script src="js/jquery.flexslider.js"></script>
        <script src="js/doubletaptogo.js"></script>
        <script src="js/init.js"></script>

    </body>
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function () {
            $('#signin').click(function() {
                var fusrnm = $.trim($('#username').val());
                var fpswrd = $.trim($('#password').val());
                if (fusrnm.length < 1 || fusrnm === "" || fpswrd.length < 1 || fpswrd === "") {
                    $('#password-signin').css('color', 'red')
                    $('#username-signin').css('color', 'red')
                    //WARN USER
                } else{
                    $('#login-form').submit();
                }
            }); 
        //controlling the slider
        $(window).load(function() {
            $('.flexslider').flexslider({
                slideshow: false
            });
        });
            
        $('#flex-next-signup').click(function () {
            $('.flexslider').flexslider("next");
            $('#password-signin').css('color', 'whitesmoke')
            $('#username-signin').css('color', 'whitesmoke')
        });
        $('#flex-prev-signin').click(function () {
            $('.flexslider').flexslider("prev");
            $('#password-signup').css('color', 'whitesmoke')
            $('#username-signup').css('color', 'whitesmoke')
            $('#cpassword-signup').css('color', 'whitesmoke')
            $('#email-signup').css('color', 'whitesmoke')
        });
            
        $('#signup').click(function() {
            var fusrnm = $.trim($('#rusername').val());
            var fpswrd = $.trim($('#rpassword').val());
            var email = $('#remail').val();
            var confirm = $('#cpassword').val();
                    
            if (fusrnm.length < 4 || fusrnm.length > 10 ||fusrnm === "" ){
                $('#username-error').html("| Username should be at least 4 characters long |");
                $('#username-signup').css('color', 'red');
            } else if(fpswrd.length < 6 || fpswrd === "" || 
                fpswrd.length > 20  ) {
                $('#password-error').html("| Password should be 6 to 20 characters long |");
                $('#password-signup').css('color', 'red');
            }else if(confirm != fpswrd){
                $('#confirm-error').html("| Passwords do not match |");
                $('#cpassword-signup').css('color', 'red')
            }
            else {
                if (checkEmail(email) === true) {
                    $('#register-form').submit();
                } else {
                    $('#rusername').empty();
                    $('#rpassword').empty();
                    $('#cpassword').empty();
                    $('#remail').empty();
                    $('#email-signup').css('color', 'red')
                    $('#email-error').html("| Invalid Email |");
                }
            }
        });
        function checkEmail(emailId) {
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(emailId)) {
                return true;
            }
            return false;
        }
    });
        
       
    </script>
    <script>
    function infoNotFound() {
        var fail = "<?php echo $_GET["fail"] ?>";
        if (fail === "login") {
            $('#warn').html("Login Failed");
            $('#warn').css('color', 'red');
        }
        if(fail=="signup"){
            $('#rwarn').html("User Already Exists");
            $('#rwarn').css('color', 'red');
            
            $('.flexslider').flexslider("next");
        }
    }
    </script>
</html>
