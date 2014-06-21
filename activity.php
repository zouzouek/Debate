<?php
session_start();

if ($_SESSION['status'] == FALSE)
    header("Location:index.php");
//echo 'hello ' . $_SESSION['username'] . '!';
?>
<head>

    <!--- Basic Page Needs
    ================================================== -->
    <meta charset="utf-8">
    <title>Users Activity</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Mobile Specific Metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSS
================================================== -->
    <link rel="stylesheet" href="css/default.css">
    <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="css/activity.css">
    <link rel="stylesheet" href="css/media-queries.css">

    <!-- Script
    ================================================== -->
    <script src="js/modernizr.js"></script>

    <!-- Favicons
         ================================================== -->
    <link rel="shortcut icon" href="favicon.ico" >

</head>

<body>


    <div id ="profile-body">
        <div id="page-content" class="row page">

            <h1 id="activity-title" class="half-bottom">Users Activity</h1>
            <div id="activity-feed">

            </div>

            <!-- section end -->
        </div>
    </div>

    <!-- Content End-->


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

</body>
<script>
    var lastCheck;
    loadActivity();
    function loadActivity(){
        $.ajax({                                      
            url: 'fetch/getactivity.php', 
            dataType: 'json',  success: function(data)        
            {
                $('#activity-feed').html("");
                if(!data[0].none){     
                    for (var i = 0; i<data.length; i++)
                    {
                        $('#activity-feed').append(data[i].act);
                        if(i==0){lastCheck = data[0].time;} //get lastest activity time
                        
                    }
                }else{
                    $('#activity-feed').append("<p align='center'>"+data[0].none+"</p>");
                }
                $(".feed-div").css('background-color','#EFF1F0');
                $(".feed-div-info").css('background-color','white');
                $(".feed-div-info").css('font-size','12px');
                $(".feed-div-info").css('margin-bottom','5px');
                $(".feed-div-info").css('border-bottom','1px #11ABB0 dotted');
            }
          
        });         
    }
   
    function checkActivity() {
        var request = 'fetch/check-activity.php?time='+lastCheck;
        $.ajax({
            url: request,
            async: false,
            cache: false,
            success: function(result) {
                //alert(result.payload);
                if (result == 'update') {   
                    //alert('new');
                    loadActivity();
                }
            }
        });
    }
    timer = setInterval(function() {
        checkActivity();
        //alert(lastcheck);
    }, 5000);
       
</script>