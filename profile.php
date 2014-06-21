<?php
session_start();
include './config/db.php';
$username_main = $_SESSION['username'];
$username = $_GET['username'];
$own = 0;
if ($username_main == $username) {
    $own = 1;
}
################################################################################
$get_user_id = mysql_query("SELECT * FROM user_table WHERE username ='$username' ");

$userid = mysql_fetch_array($get_user_id);

$id = $userid['uid'];
#####################################


$get_user = mysql_query("SELECT * FROM info_table WHERE uid='$id'");
$user = mysql_fetch_array($get_user);
#####################################

$fid = $_SESSION['id'];

######################################
$get_following = mysql_query("SELECT * FROM followers_table WHERE uid ='$id' AND follower_id='$fid' ");
$following = mysql_fetch_array($get_following);
$follow = 'Follow';
if ($following != NULL) {
    $follow = "Following";
}
?>
<head>

    <!--- Basic Page Needs
    ================================================== -->
    <meta charset="utf-8">
    <title>Profile Information | Sparrow</title>
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
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/qtip.css">
    <!-- Script
    ================================================== -->
    <script src="js/modernizr.js"></script>

    <!-- Favicons
         ================================================== -->
    <link rel="shortcut icon" href="favicon.ico" >
</head>

<body >


    <div class="profile-body">
        <a title="View Statistics" href="stats_profile.php?username=<?php echo $username ?>"><img src="images/roomstats1.png" style="height:32px;width:32px;float:right"/></a>
        <?php if ($own == 0) { ?>
            <a id="follow" style="float:left; margin-right:10px" href="#"><?php if ($follow == 'Follow') { ?>
                    <img title="follow" style="height:28px;width: 28px" src="images/follow.png"/><?php } else { ?><img title="unfollow" style="height:28px;width: 28px" src="images/unfollow.png"/><?php } ?>
            </a>
        <?php } if ($own == 1) { ?>
            <a target="_parent" style="height:40px;width: 40px" title="Edit Your Profile" href="edit_profile.php"><img src="images/edit2.png" style="height:28px;width: 28px;float:left"></a>
        <?php } ?>
        <div id="page-content" class="row page">
        
        

            <div id="primary" class="eight columns">

                <div id="upload-wrapper">
                    <div class="name-photo" align="center">
                        <h3 style="color: #fff"><?php echo $username; ?></h3>
                        <img src="<?php
        if ($user['profilepic'] != '') {
            echo $user['profilepic'];
        } else {
            echo 'images/user-03.png';
        }
        ?>">
                    </div>
                </div>
                <div class="follow-block">
                    <h6><a id="myfollows" href="#">Follows</a></h6> <h6><a id="myfollowers" href="#">Followers</a></h6>
                </div>
                <!-- form -->

                <fieldset>

                    <div class="pull-left" >
                        <span class="info"><h5 style="color: #fff;">First: </h5>
                            <span><?php echo $user['firstname']; ?></span></span> <br>

                        <span class="info"><h5 style="color: #fff">Last: </h5>
                            <span><?php echo $user['lastname']; ?></span></span> <br>

                        <span class="info"><h5 style="color: #fff">Age: </h5>
                            <span><?php echo $user['age']; ?></span></span> <br>

                        <span class="info"><h5 style="color: #fff">Gender: </h5>
                            <span><?php echo $user['gender']; ?></span></span> <br>

                        <span class="info"><h5 style="color: #fff">Country: </h5>
                            <span><?php echo $user['location']; ?></span></span> <br>

                        <span class="info"><h5 style="color: #fff">Work: </h5>
                            <span><?php
                             if ($user['work'] != NULL)
                                 echo $user['work']; else
                                 echo 'No work available';
        ?></span></span> <br>

                        <span class="info"><h5 style="color: #fff">Education: </h5>
                            <span><?php
                                if ($user['education'] != NULL)
                                    echo $user['education']; else
                                    echo 'No education available';
        ?></span></span> <br>

                        <span class="info"><h5 style="color: #fff">Biography: </h5>
                            <span><?php
                                if ($user['bio'] != NULL)
                                    echo $user['bio']; else
                                    echo 'No biography available';
        ?></span></span> <br>
                    </div>

                </fieldset>
                <!-- Form End -->



            </div>
            <div id="follow-post" style="display:none"></div>
            <div id="follower-post" style="display:none"></div>
            <!-- section end -->

        </div>



    </div>

</div <!-- Content End-->


<!-- footer
================================================== -->

<!-- Java Script
================================================== -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/jquery-1.10.2.min.js"><\/script>')</script>
<script type="text/javascript" src="js/jquery-migrate-1.2.1.min.js"></script>

<script src="js/jquery.flexslider.js"></script>
<script src="js/doubletaptogo.js"></script>
<script src="js/init.js"></script>
<script src="js/qtip.js"></script>
<script>
    $(document).ready(function() {
        var value = "<?php echo $follow ?>";
            
        $("#follow").on("click", function(e) {
            if (value == 'Following') {
                var jqxhr = $.post("follow/unfollow.php?username=<?php echo $username; ?>", function() {

                })
                .done(function() {
                    //$("#follow").val("Follow");
                    value = "Follow";
                    $("#follow img").attr("src", "images/follow.png");
                    $("#follow img").attr("title", "follow");
                })
                .fail(function() {
                    alert("error");
                });
            }
            else {
                var jqxhr = $.post("follow/follow.php?username=<?php echo $username; ?>", function() {

                })
                .done(function() {
                    value = "Following";
                    //$("#follow").val("Following");
                    $("#follow img").attr("src", "images/unfollow.png");
                    $("#follow img").attr("title", "unfollow");
                })
                .fail(function() {
                    alert("error");
                });
            }
        });
        getFF();
        getFFnum();
    });
    function getFF(){
        var followbox = $('<div />').qtip({
            content: {
                text: $('#follow-post'),
                title: "<b>"+"<?php echo $username ?>"+"'s follows</b>",
                button:true
            },
            position: {
                my: 'center', at: 'center',
                target: $(window)
            },
            show: {
                ready: false,
                modal: {
                    on: true,
                    blur: false
                }
            },
            hide: false,
            style: {
                classes: 'qtip-bootstrap qtip-rounded',
                width: 700
            }
        });
        var followerbox = $('<div />').qtip({
            content: {
                text: $('#follower-post'),
                title: "<b>"+"<?php echo $username ?>"+"'s followers</b>",
                button:true
            },
            position: {
                my: 'center', at: 'center',
                target: $(window)
            },
            show: {
                ready: false,
                modal: {
                    on: true,
                    blur: false
                }
            },
            hide: false,
            style: {
                classes: 'qtip-bootstrap qtip-rounded',
                width: 700
            }
        });
            
        var followapi = followbox.qtip('api');
        var followerapi = followerbox.qtip('api');
        $('#myfollows').unbind('click').on('click',function(e){
            e.preventDefault();
            $.ajax({
                url: 'fetch/getfollows.php?username=<?php echo $username ?>',
                dataType: 'json',
                success: function(data){
                    if(!data[0].none){
                        $('#follow-post').html("");
                        $('#follow-post').html("<div>");
                        for(var i in data){
                            $('#follow-post').append('<a href="profile.php?username='+data[i].user+'">'+data[i].user+'</a><br>');
                        }
                        $('#follow-post').append("</div>");
                    }else{
                        $('#follow-post').html(data[0].none);
                    }
                    followapi.toggle(true);
                }
            });
         
        });
        $('#myfollowers').unbind('click').on('click',function(e){
            e.preventDefault();
            $.ajax({
                url: 'fetch/getfollowers.php?username=<?php echo $username ?>',
                dataType: 'json',
                success: function(data){
                    if(!data[0].none){
                        $('#follower-post').html("");
                        $('#follower-post').html("<div>");
                        for(var i in data){
                            $('#follower-post').append('<a href="profile.php?username='+data[i].user+'">'+data[i].user+'</a><br>');
                        }
                        $('#follower-post').append("</div>");
                    }else{
                        $('#follower-post').html(data[0].none);
                    }
                    followerapi.toggle(true);
                }
            });
         
        });
    }
    function getFFnum(){
        $.ajax({
            url: 'fetch/getffnum.php?username=<?php echo $username ?>',
            dataType: 'json',
            success: function(data){
                $('#myfollows').html(data[0].follows+' Follows');
                $('#myfollowers').html(data[0].followers+' Followers');
            }
        });
    }
</script>
</body>




