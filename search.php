<?php
session_start();

if ($_SESSION['status'] == FALSE)
    header("Location:index.php");

if (!isset($_GET['q']) || trim($_GET['q']) == "")
    header('Location: ./alert/error.php');
else {
    $q = urldecode($_GET['q']);
   // echo $q;
}
?>

<head>

    <!--- Basic Page Needs
    ================================================== -->
    <meta charset="utf-8">
    <title>Search Results - <?php echo $q; ?></title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Mobile Specific Metas
    ================================================== -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSS
================================================== -->
    <link rel="stylesheet" href="css/default.css">
    <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="css/searchpage.css">
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

            <h1 id="search-title" class="half-bottom">Search Results: <mark><?php echo $q ?></mark> <a href="home.php">Return Home</a></h1>
            <div id="search-content">
                <h3 id="users-title" class="half-bottom">Users</h3>
                <div id="users-results"></div>
                <h3 id="tags-title" class="half-bottom">Tags</h3><span id="tags-none"></span>
                <div id="tags-results"></div>
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
    <script src="js/jquery.pageslide.min.js"></script>

</body>
<script>
    loadResults();
    function loadResults(){
        $.ajax({                                      
            url: 'fetch/getsearch.php?q=<?php echo urlencode($q) ?>', 
            dataType: 'json',  success: function(data)        
            {
                $('#users-results').html("");
                $('#tags-results').html("");
                var users = data[0].users;
                var tags = data[0].tags;
                
                if(!users[0].none){
                    for (var i = 0; i<users.length; i++){
                        $('#users-results').append("<a href='#' class='users' id='u_"+i+"'>"+users[i].user+"</a><br>");
                    } 
                }else{
                    $('#users-results').append("<span class='users'>"+users[0].none+"</span>");
                }
                
                if(!tags[0].none){
                    for (var i = 0; i<tags.length; i++){
                        $('#tags-results').append
                        ("<a href='room.php?cat="+tags[i].cat+"&tag="+tags[i].tag.substr(1,tags[i].tag.length)+"' class='tags' id='t_"+i+"'>"+tags[i].tag+"</a><span>"+tags[i].cat+"</span><br>");
                    } 
                }else{
                    $('#tags-results').append("<span class='tags'>"+tags[0].none+"</span>");
                }
                
                $(".users, .tags").css('padding-left','15px');
                $(".tags").css('padding-right','15px');
                $(".users, .tags").css('font-size','16px');
                
            }
          
        });         
    }
    
    function requestPageslide(){
        $("[id*='u_']").each(function(e){
            var username = $(this).html();
            if(username.charAt(0)=='@')
                username = username.substr(1, username.length);
                    
            $(this).pageslide({ direction: "left", href: 'profile.php?username='+username });
        });
    }
            
    $(document).ajaxSuccess(function() {
        requestPageslide();
    });
</script>