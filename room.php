<?php
include 'config/db.php';
session_start();
if ($_SESSION['status'] == FALSE)
    header("Location:index.php");

if (isset($_GET["tag"]) && isset($_GET["cat"])) {
    $category = $_GET["cat"];
    $tag = '#' . $_GET["tag"];
    $uid = $_SESSION['id'];
    $search_tags = mysql_query("SELECT * FROM tag_table  WHERE LOWER(`tagname`) = LOWER('$tag') && `category` = '$category'");
    $target_tag = mysql_fetch_array($search_tags);
    $tid = $target_tag['tid'];
    $started = date('d M y', strtotime($target_tag['Date']));
    $owner_id = $target_tag['uid'];
    $owner_query = mysql_query("SELECT * FROM user_table WHERE uid=$owner_id");
    $owner = mysql_fetch_array($owner_query);
    $owner_name = $owner['username'];
    if ($target_tag == 0) {
        header("Location: home.php");
    }
    if (isset($_GET['not'])) {
        $not = $_GET['not'];
    } else {
        $not = "";
    }
} else {
    header("Location: home.php");
}
?>
<!DOCTYPE html>
<!--[if lt IE 8 ]><html class="no-js ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="no-js ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 8)|!(IE)]><!--><html class="no-js" lang="en"> <!--<![endif]-->
    <head>

        <!--- Basic Page Needs
        ================================================== -->
        <meta charset="utf-8">
        <title><?php echo $tag; ?></title>
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Mobile Specific Metas
        ================================================== -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

        <!-- CSS
    ================================================== -->
        <link rel="stylesheet" type="text/css" href="css/Roomdesign.css"/>

        <link rel="stylesheet" href="css/default.css">
        <link rel="stylesheet" href="css/layout.css">
        <link rel="stylesheet" href="css/media-queries.css">
        <link rel="stylesheet" href="css/qtip.css">
        <link rel="stylesheet" href="css/search.css">
        <link rel="stylesheet" href="css/room-stats.css">

        <link href="css/kendo/kendo.common.min.css" rel="stylesheet" />
        <link href="css/kendo/kendo.default.min.css" rel="stylesheet" />
        <link href="css/kendo/kendo.dataviz.min.css" rel="stylesheet" />
        <link href="css/kendo/kendo.dataviz.default.min.css" rel="stylesheet" />

        <link rel="stylesheet" type="text/css"
              href="css/jquery-ui-1.10.4.min.css" />
        <style>
            .ui-autocomplete {
                max-height: 100px;
                overflow-y: auto;
                /* prevent horizontal scrollbar */
                overflow-x: hidden;
            }
        </style>


        <!-- Script
        ================================================== -->
        <script src="js/modernizr.js"></script>

        <!-- Favicons
             ================================================== -->
        <link rel="shortcut icon" href="favicon.ico" >

    </head>

    <body>

        <!-- Header
        ================================================== -->
        <header>

            <div class="row">

                <div class="twelve columns">
                    <div id="read-post" style="display:none"></div>
                    <div class="logo">
                        <a href="home.php"><img src="images/logo.png"/></a>
                        <a id="readlater" title="Show marked tags" href="#"><img id="readimg" src="images/book.png"/></a>
                        <a id="notify" href="#"><img id="notifyimg" src="images/whitealert.png"/></a>
                        <a id="search" href="#" title="Search"><img id="searchimg" src="images/search-2.png"/></a>
                    </div>
                    <div id="searchdiv" style="display: none">
                        <h6>Search Users and Tags</h6>
                        <input type="text" id="searchbar"/>
                        <span>Press enter or click search</span>
                        <h6 id="entersearch"><a href="#">Search</a></h6>
                    </div>
                    <nav id="nav-wrap">

                        <a class="mobile-btn" href="#nav-wrap" title="Show navigation">Show navigation</a>
                        <a class="mobile-btn" href="#" title="Hide navigation">Hide navigation</a>

                        <ul id="nav" class="nav">

                            <li><a href="home.php">Feed</a></li>
                            <li><a id="act" href="#">Activity</a></li>
                            <li><a id="profile" href="#">Profile</a></li>
                            <li><a href="logout.php">Log Out</a></li>

                        </ul> <!-- end #nav -->

                    </nav> <!-- end #nav-wrap-->

                </div>

            </div>

        </header>  <!--Header End -->

        <!-- Content
         ================================================== -->
        <div class="content-outer">

            <div id="room-options">
                <div title="tagname" id="roomname-op"><h6><?php echo $tag . " / "; ?></h6></div>
                <div title="category" id="cat-op"><h6><?php echo $category . " / "; ?></h6></div>
                <div title="started by" id="started-op"><h6><?php echo $owner_name . " / "; ?></h6></div>
                <div title="on this date" id="by-op"><h6><?php echo $started; ?></h6></div>

                <div id="view-stats"><a href="" title="view statistics on this page"><img src="images/roomstats.png"/></a></div>
                <?php
                $mark_query = mysql_query("SELECT * FROM `readlater_table` WHERE `tid` = $tid AND `uid` = $uid");
                $marked = mysql_fetch_array($mark_query);
                if ($marked > 0) {
                    ?>
                    <div id ="tag-mark"><a href = "" title = "marked"><img src="images/unmark.png"/></a></div>
                <?php } else { ?>
                    <div id ="tag-mark"><a href = "" title = "mark this tag for later"><img src="images/mark.png"/></a></div>
                <?php } ?>

            </div>

            <div id="stats-section">
                <div id="averages"><h2 id="a1"></h2><h2 id="a2"></h2></div>
                <div id="stats-op"><h4 id="g1"><a href='#'>Graph1</a></h4><h4 id="g2"><a href='#'>Graph2</a></h4></div>
                <div id="chart"></div><div id="analysis"><h5></h5></div>
            </div>

            <div id="page-content" class="row page">

                <section>

                    <div id="alert-post" style="display:none">

                    </div>


                    <div class="start" id ="start">
                        <div id="roomname" name="roomname">
                            <div class="rm1"><h1></h1></div>
                            <div class="rmvs"><h3>VS</h3></div>
                            <div class="rm2"><h1></h1></div>                            
                        </div>
                        <form action="forms/roompost.php" method="post" id="roompost-form">
                            <input type="hidden" id="tagname" name="tagname" value="<?php echo $tag ?>"/>
                            <input type="hidden" id="cat" name="cat" value="<?php echo $category ?>"/>
                            <input type="hidden" id="side" name="side" value=""/>
                            <div id="commentfeed_side1" >
                                <div class="side1" id="side1">
                                    <div class="post1" id="post1">
                                        <textarea name="comment1" id="comment1" type="textfield" /></textarea>
                                        <input type="hidden" name="reply1" value="" id="1x"/>
                                        <input type="button" name="s1" value="Comment" id="s1"/>
                                    </div>
                                    <div class="content1">

                                    </div>
                                </div>
                            </div>

                            <div id="commentfeed_side2" >
                                <div id="side2" class="side2" >

                                    <div class="post2" id="post2">
                                        <textarea name="comment2" id="comment2" type="textfield"/></textarea>
                                        <input type="hidden" name="reply2" value="" id="2x"/>
                                        <input type="button" name="s2" value="Comment" id="s2"/>
                                    </div>
                                    <div class="content2">

                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>

                </section> <!-- section end -->

            </div>
            <div id="cb" style="display: none"></div>
            <div id="secondary" class="four columns end">

            </div>


        </div> <!-- Content End-->


        <!-- footer 
        ================================================== -->
         <footer id="footer">

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
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

        <script type="text/javascript" src="js/jquery-migrate-1.2.1.min.js"></script>
        <script src="js/jquery.flexslider.js"></script>
        <script src="js/jquery.pageslide.min.js" type="text/javascript"></script>
        <script src="js/doubletaptogo.js"></script>
        <script src="js/init.js"></script>
        <script src="js/qtip.js"></script>
        <script src="js/search.js"></script>
        <script src="js/room-stats.js"></script>
        <script src="js/kendo/kendo.all.min.js"></script>
        <script src="js/jquery.mousewheel.js"></script>
        <!-- <script src="js/jquery-ui.triggeredAutocomplete.js"></script> -->
        <script src="js/jquery.pageslide.min.js" type="text/javascript"></script>


        <script type="text/javascript"
        src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>



    </body>
    <script>
        $(document).ready(function () {
            var rn = "<?php echo $tag ?>";
            var cat = "<?php echo $category ?>";
            var u = "<?php echo $_SESSION['username'] ?>";
            var tid = "<?php echo $tid ?>";
            //alert(rm);
            $('#roomname .rm1 h1').html(rn.substring(1, rn.indexOf('_')));
            $('#roomname .rm2 h1').html(rn.substring(rn.indexOf('_')+1,rn.length));
            getcomments(1);
            getcomments(2);
            main_search();
            loadNotifications();
            loadTags();
            $("#act").pageslide({ direction: "left", href: 'activity.php' });
            $("#profile").pageslide({ direction: "left", href: 'profile.php?username='+u });
           
            function getcomments(side){
                $.ajax({                                      
                    url: 'fetch/getcomments.php?tid='+<?php echo $target_tag['tid'] ?>+'&side='+side, 
                    data: "", async:false,dataType: 'json',  success: function(data)        
                    {
                        $('.content'+side).html("");
                     
                        var $ul = $("<ul class='final-comments'>");
                        
                        for (var i in data)
                        {
                            //alert(data.length);
                           
                            var session_id = <?php echo $_SESSION['id'] ?>;
                            var username = data[i].username;
                            var comment = data[i].comment;
                            var date = data[i].date;
                            
                            var related = data[i].related;
                            var content = comment.comment;//get comment of comment
                            var replyto = comment.replyto;
                           
                            var cid = comment.cid; //get cid of comment
                            var uid = comment.uid;
                            var reports = data[i].reports;
                            var likes = data[i].likes;
                            var dislikes = data[i].dislikes;
                            var shares = data[i].shares;
                            
                            var likes_element = "<span><a id='likes_"+cid+"' href='#'>+"+likes+"</a></span>";
                            var dislikes_element = "<span><a id='dislikes_"+cid+"' href='#'>-"+dislikes+"</a></span>";
                            var shares_element = "<span id='shares_"+cid+"'><a href='#'> share["+shares+"] </a></span>";
                            var reports_element = "<span id='report_"+cid+"' title='"+reports+" reports'><a href='#'> ! </a></span>";
                            var reply_element = "<span id='"+side+"_reply_"+cid+"' title='reply with'><a href='#'><img class='replyImg' src='images/reply.png'/></a></span>";
                            var xreply_element = "<span id='"+side+"_xreply_"+cid+"' title='reply against'><a href='#'><img class='replyImg' src='images/sword.png'/></a></span>";
                                
                            if(related.length > 0){
                                var ld = related[0].ld;
                                //alert(ld);
                                if(ld == 1)
                                    likes_element = "<span title='remove +1'><a id='likes_"+cid+"' href='#'>[+"+likes+"]</a></span>"; 
                                else if(ld == 2)
                                    dislikes_element = "<span title='remove -1'><a id='dislikes_"+cid+"' href='#'>[-"+dislikes+"]</a></span>";
                                
                                var shared = related[0].shared;
                                if(shared == 1)
                                    shares_element = "<span id='shares_"+cid+"'> share["+shares+"] </span>";
                               
                                var reported = related[0].reported
                                if(reported == 1)
                                    reports_element = "<span id='report_"+cid+"' title='"+reports+" reports'> (!) </span>";  
                                
                            }
                            // href='forms/delete-comment.php?cid="+cid+"'
                            var delete_element; 
                            //alert(uid + "-" + session_id);
                            if(session_id == uid){ //if comment's user is current user -> include delete
                                delete_element = "<span title='delete'><a id='delete_"+cid+"' href='#'> X </a></span>";
                                reports_element = ""; //can't report myself'
                                reply_element = ""; //can't reply to myself'
                                xreply_element = ""; //can't reply against myself'
                            }else{
                                delete_element= "";    
                            }
                            
                            var wa_element = "";
                            if(replyto != null){
                                var x = replyto.substring(0, 2);
                                if(x == 'x_'){
                                    //var waid = replyto.substr(2, replyto.length);
                                    wa_element = "<a id='"+side+"wa_"+replyto+"'' href='#'><img class='waImg' src='images/against.png'/></a>";
                                }else{
                                    wa_element = "<a id='"+side+"wa_"+replyto+"'' href='#'><img class='waImg' src='images/with.png'/></a>";  
                                }
                                //alert(replyto); 
                            }
                                
                            content = replaceAtMentionsWithLinks (content, cid);  
                            //alert(delete_element);
                            if(reports == 1){
                                var comment_div = "<div id='xcb"+cid+"'><li>This comment has been reported many times! <a href='#'>Show</a></li></div><div style='display:none' id='cb"+cid+"'>";
                            }else{
                                var comment_div = "<div id='cb"+cid+"'>";
                            }
                            $ul.append(comment_div+"<li><a id='u_"+cid+"' href='profile.php?username="+username+"'>"
                                +username+"</a>: <span class='entry-content'>"
                                +content+"</span><div id='cop'><span>"
                                +date+"</span>"
                                +likes_element+dislikes_element+shares_element+wa_element+"<span id='subcop"
                                +cid+"'>"+reply_element+xreply_element+delete_element+reports_element+"</span></div></li></div>");
                            //  $('.content'+side).css("overflow", "auto");
                        }
                        $ul.append("</ul>");
                        $ul.appendTo('.content'+side); 
                        loadTips();
                        loadCSS();                        
                        loadJS();
                        
                        var tid = <?php echo $target_tag['tid'] ?>;
                        loadMentions(tid, side);
                        //requestPageslide();
                        // highlight requested comment
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
                loadStats(tid,rn);
            });
            
            function loadCSS(){
                $(".final-comments [id*='xcb']").css("background-color", "yellow"); //spam
                $(".final-comments div").css("width", "398px");
                $(".final-comments li").css("border-bottom", "1px solid grey");
                $(".final-comments li").css("margin-bottom", "5px");
                $(".final-comments li").css("height", "1px solid grey");
                $(".final-comments li span").css("padding-right", "10px");
                $(".final-comments li span [id*='likes']").css("color", "green");
                $(".final-comments li span [id*='dislikes']").css("color", "red");
                $(".final-comments li span [id*='delete']").css("color", "red");
                $(".final-comments li span [id*='delete']").css("font-size", "12px");
                $(".final-comments li span [id*='report'] a").css("color", "purple");
                $(".final-comments li span [id*='report'] a").css("font-size", "20px");
                $(".final-comments li span [id*='report']").css("color", "purple");
                $(".final-comments li span [id*='report']").css("font-size", "20px");
                $(".final-comments li span .replyImg").css("width", "15px");
                $(".final-comments li span .replyImg").css("height", "15px"); 
                $(".final-comments li .waImg").css("width", "22px");
                $(".final-comments li .waImg").css("height", "15px"); 
                $(".final-comments [id*='subcop']").css("float","right"); ///THISISSSS
                       
                $(".final-comments [id*='subcop']").css("display","none");
                $(".final-comments #cop").css("margin-top","10px");
            }
            function loadJS(){
                $("[id*='xcb'] a").on('click', function(e){
                    e.preventDefault();
                    var id = $(this).closest("div").attr('id');
                    var target_id = id.substr(1, id.length);
                    $("#"+target_id).css("display","block");
                    $("#"+id).css("display","none");
                })
                
                $(".final-comments div").hover(
                function() {
                    // Styles to show the box
                    var id = this.id;
                    var subcop = "#subcop"+id.substr(2, id.length);
                    
                    $(subcop).css("display","block");
                },
                function () {
                    // Styles to hide the box
                    var id = this.id;
                    var subcop = "#subcop"+id.substr(2, id.length);
                    
                    $(subcop).css("display","none");;
                }
            );
                $("[id*='delete']").unbind().on("click", function(e){
                    e.preventDefault();
                    var id = this.id;
                    if (confirm('Do you want to delete this comment?')) {
                        var cid = id.substr(7, id.length);
                        $.ajax({                                      
                            url: 'forms/delete-comment.php?cid='+cid, 
                            data: "",  success: function(data)        
                            {
                                $('.final-comments #cb'+cid).css("display","none");
                            }
                        });
                    }
                });
                $("[id*='likes']").unbind('click').on("click", function(e){
                    e.preventDefault();
                    var id = this.id;
                    var cid = id.substr(6, id.length);
                    var html = $('#'+id).html();
                    $.ajax({                                      
                        url: 'forms/like-comment.php?cid='+cid, 
                        data: "",  success: function(data)        
                        {
                            if(data == 'new' || data == 'null'){
                                $('#'+id).html('[+'+(parseInt(html.substr(1, html.length))+1)+']');
                                $('#'+id).prop('title', 'remove +1');
                            }else if(data == 'change'){
                                $('#'+id).html('[+'+(parseInt(html.substr(1, html.length))+1)+']'); 
                                var dislike = $('#dis'+id).html();
                                $('#dis'+id).html('-'+(parseInt(dislike.substr(2, dislike.length))-1));
                                $('#'+id).prop('title', 'remove +1');
                                $('#dis'+id).prop('title', '');
                            }else if(data == 'remove'){
                                $('#'+id).html('+'+(parseInt(html.substr(1, html.length))-1));
                                $('#'+id).prop('title', '');
                                $('#'+id).closest("span").prop('title', '');
                            }
                            loadTips();
                        }
                    });
                    
                });
                $("[id*='dis']").unbind('click').on("click", function(e){
                    e.preventDefault();
                    var id = this.id;
                    var cid = id.substr(9, id.length);
                    var html = $('#'+id).html();
                    $.ajax({                                      
                        url: 'forms/dislike-comment.php?cid='+cid, 
                        data: "",  success: function(data)        
                        {
                            if(data == 'new' || data == 'null'){
                                $('#'+id).html('[-'+(parseInt(html.substr(1, html.length))+1)+']');
                                $('#'+id).prop('title', 'remove -1');
                            }else if(data == 'change'){
                                $('#'+id).html('[-'+(parseInt(html.substr(1, html.length))+1)+']'); 
                                var like = $('#'+id.substr(3, id.length)).html();
                                $('#'+id.substr(3, id.length)).html('+'+(parseInt(like.substr(1, like.length))-1));
                                $('#'+id).prop('title', 'remove -1');
                                $('#'+id.substr(3, id.length)).prop('title', '');
                            }else if(data == 'remove'){
                                $('#'+id).html('-'+(parseInt(html.substr(2, html.length))-1));
                                $('#'+id).prop('title', '');
                                $('#'+id).closest("span").prop('title', '');
                            }
                            loadTips();
                        }
                    });
                    
                });
                $("[id*='shares'] a").unbind().on("click", function(e){
                    e.preventDefault();
                    var id = $(this).closest("span").attr('id'); //get parent id
                    var cid = id.substr(7, id.length);
                    var html = $('#'+id+' a').html();
                    if(confirm("Do you want to share this comment with your followers?")){
                        $.ajax({                                      
                            url: 'forms/share-comment.php?cid='+cid, 
                            data: "",  success: function(data)        
                            {
                                $('#'+id).html(' share['+(parseInt(html.substr(7, html.length))+1)+'] ');  
                                loadTips();
                            }
                        });
                    } 
                });
               
                $("[id*='report'] a").unbind().on("click", function(e){
                    e.preventDefault();
                    var id = $(this).closest("span").attr('id'); //parent id
                    var cid = id.substr(7, id.length);
                    if(confirm("Are you sure you want to report this comment?")){
                        $.ajax({                                      
                            url: 'forms/report-comment.php?cid='+cid, 
                            data: "",  success: function(data)        
                            {
                                var title = parseInt($('#'+id).prop('title'))+1;
                                $('#'+id).prop('title', title+' reports');
                                $('#'+id).html(' (!) '); 
                                //e.preventDefault();
                            }
                        });
                    } 
                });
                $("[id*='reply'] a").unbind().on("click", function(e){
                    e.preventDefault();
                    var id = $(this).closest("span").attr('id'); //parent id
                    var side = parseInt(id.charAt(0));
                    $('#comment'+side).val("");                               
                    if(id.charAt(2) == 'x'){
                        var cid = id.substr(9, id.length);
                        var against = true;
                    }else{
                        var cid = id.substr(8, id.length);
                    }
                    
                    var user = '@'+$('#u_'+cid).html();
                    if(against){
                        $('#'+side+'x').val(""); 
                        if(side == 1)
                            side++;
                        else
                            side--;
                                                
                        $('#comment'+side).val("");
                        $('#'+side+'x').val('x_'+cid); 
                    }else{
                        $('#'+side+'x').val(cid); 
                        var temp = side;
                        if(temp == 1)
                            temp++;
                        else
                            temp--;
                        $('#comment'+temp).val("");
                        $('#'+temp+'x').val(""); 
                    }  
                    
                    var words = split($('#comment'+side).val());
                    words.push(user);
                    words.push("");
                    $('#comment'+side).focus().val(words.join(" "));
                });
                
                $("a[id*='wa_']").click(function(e) {
                    e.preventDefault();
                    var cid = this.id;
                    var side = parseInt(cid.charAt(0));
                    
                    if(cid.charAt(4)=='x' && side == 1)
                        side++;
                    else if(cid.charAt(4)=='x' && side == 2)
                        side--;                        
                    
                    var mcid = cid.replace(/.wa_[x_]*/, '');
                    $('html body').animate({
                        scrollTop: $('#cb'+mcid).offset().top
                    }, 500);
                    $('.content'+side).animate({
                        scrollTop: $('#cb'+mcid).offset().top
                    }, 2000);
                    //$('#cont'+side).scrollTop($parentDiv.scrollTop() + $innerListItem.position().top);
                    $('#cb'+mcid).effect("highlight", {}, 2000);
                    //$('#cb'+mcid).toggle("slide");
                });
              
                
                function split( val ) {
                    return val.split( /\s+/ );
                }
             
            }
           
            function loadTips(){
                $("a[id*='wa_']").each(function() {
                    var cid = this.id;
                    $(this).qtip({
                        content: {
                            text: function(event, api) {
                                $.ajax({
                                    url: 'fetch/getwa.php?cid='+cid, // Use href attribute as URL
                                    dataType: 'json'
                                })
                                .then(function(content) {
                                    // Set the tooltip content upon successful retrieval
                                    api.set('content.text', content[0].comment.comment + '<br> <span style="color:lightblue">Click the icon to navigate</span>');
                                    if(content[0].nf){
                                        api.set('content.text', content[0].nf); 
                                    }
                                    api.set('hide.event', 'false');
                                    api.set('hide.event', 'click mouseleave');
                                    api.set('hide.inactive', '1000');
                                    
                                    if(cid.charAt(4) == 'x'){
                                        api.set('content.title', "Replying against "+content[0].username+"'s comment:");
                                    }else{
                                        api.set('content.title', "Replying with "+content[0].username+"'s comment:");
                                    }
                                    api.set('content.footer', 'click to close');
                                    //loadJS();
                                }, function(xhr, status, error) {
                                    // Upon failure... set the tooltip content to error
                                    api.set('content.text', status + ': ' + error);
                                   
                                });
        
                                return 'Loading..'; // Set some initial text
                            }
                        },
                        position: {
                            viewport: $(window)
                        },
                        style: 'qtip-tipsy' //'qtip-bootstrap'
                    });
                });
                $("[id*='likes']").each(function() { 
                    var cid = this.id;
                    if(cid.charAt(0) == 'd'){
                        cid = cid.substr(9, cid.length);
                        var url = 'fetch/getdislikers.php?cid='+cid;
                        var title = 'Who disliked this?' ;
                    }else{
                        cid = cid.substr(6, cid.length);
                        var url = 'fetch/getlikers.php?cid='+cid;
                        var title = 'Who liked this?';
                    }
                    $(this).qtip({
                        content: {
                            text: function(event, api) {
                                $.ajax({
                                    url: url, // Use href attribute as URL
                                    dataType: 'json'
                                })
                                .then(function(content) {
                                    if(!content[0].none){
                                        var target = "";
                                        for(var i in content){
                                            var user = content[i].user;  
                                            target+='<a href="#" id="u_'+i+'" >'+user+'</a><br>' 
                                        }
                                        api.set('content.text', target);
                                    }else
                                        api.set('content.text', content[0].none); 
                                    
                                    api.set('content.title', title);
                                    api.set('hide.fixed', 'true');
                                    //api.set('hide.event', 'click');
                                    api.set('hide.delay', '200');
                                    
                   
                                }, function(xhr, status, error) {
                                    // Upon failure... set the tooltip content to error
                                    api.set('content.text', status + ': ' + error);
                                   
                                });
        
                                return 'Loading..'; // Set some initial text
                            }
                        },
                        position: {
                            viewport: $(window)
                        },
                        style: 'qtip-light' //'qtip-bootstrap'
                    });
                });
                $("[id*='shares']").each(function() { 
                    var cid = this.id;
                    cid = cid.substr(7, cid.length);
                    var url = 'fetch/getshares.php?cid='+cid;
                    $(this).qtip({
                        content: {
                            text: function(event, api) {
                                $.ajax({
                                    url: url, // Use href attribute as URL
                                    dataType: 'json'
                                })
                                .then(function(content) {
                                    if(!content[0].none){
                                        var target = "";
                                        for(var i in content){
                                            var user = content[i].user;  
                                            target+='<a href="#" id="u_'+i+'">'+user+'</a><br>'  
                                        }
                                        api.set('content.text', target);
                                    }else
                                        api.set('content.text', content[0].none);  
                                   
                                    api.set('content.title', "Who shared this?"); 
                                    api.set('hide.fixed', 'true');
                                    //api.set('hide.event', 'click');
                                    api.set('hide.delay', '200');
                                    
                   
                                }, function(xhr, status, error) {
                                    // Upon failure... set the tooltip content to error
                                    api.set('content.text', status + ': ' + error);
                                   
                                });
        
                                return 'Loading..'; // Set some initial text
                            }
                        },
                        position: {
                            viewport: $(window)
                        },
                        style: 'qtip-light' //'qtip-bootstrap'
                    });
                });
            }
            
           
            function loadMentions(tid, side){
                function split( val ) {
                    return val.split( /\s+/ );
                }
                function extractLast( term ) {
                    return split( term ).pop();
                }
                $("#comment1, #comment2").on("keyup", function(e){
                    if(e.keyCode == 50){ //'@'pressed  
                        $( "#comment1,#comment2" )
                        // don't navigate away from the field on tab when selecting an item
                        .bind( "keydown", function( event ) {
                            if ( event.keyCode === $.ui.keyCode.TAB &&
                                $( this ).data( "ui-autocomplete" ).menu.active ) {
                                event.preventDefault();
                            }
                        })
                        .autocomplete({
                            source: function( request, response ) {
                                $.getJSON( 'autocomplete/getusers.php?tid='+tid+'&s='+side, {
                                    term: extractLast( request.term )
                                }, response );
                            },
                            search: function() {
                                // custom minLength
                                var term = extractLast( this.value );
                                if ( term.charAt(0) != '@' || term.length < 2 ) {
                                    return false;
                                }
                            },
                            focus: function() {
                                // prevent value inserted on focus
                                return false;
                            },
                            select: function( event, ui ) {
                                var terms = split( this.value );
                                // remove the current input
                                terms.pop();
                                // add the selected item
                                terms.push( ui.item.value );
                                // add placeholder to get the comma-and-space at the end
                                terms.push( "" );
                                this.value = terms.join( " " );
                                return false;
                            }
                        });
                    }
                });
            }
            
           
            function replaceAtMentionsWithLinks (text, cid) {
                var pattern = /\B@[a-z0-9_-]+/gi;
                
                var result = text.match(pattern);
                //alert(result[0]);
                $.ajax({                                      
                    url: 'fetch/check-mention.php', type: "POST",
                    data: {mentions: result},async:false, dataType: 'json',  success: function(data)        
                    {
                        for(var i in data){
                            var mention = data[i].mention;
                            text = text.replace('@'+mention,
                            '<a id="u_'+cid+'" href="profile.php?username='+mention+'">@'+mention+'</a>');
                            //alert(text);
                            
                        }
                     
                    }
                });
                return text;
            }
            
            //---------------------NOTIFICATIONS------------------------// 
            var hovering; //check to stop interval. true-stop,false-start
            //var lastcheck; //timestamp for last time checked
            var shaked = false;
           
            checkNotifications();
            
            $("#notify").hover(
            function() {
                hovering = true;
            },
            function() {
                hovering = false;
            }
        );
            function loadNotifications(){
                $('#notify').qtip({
                    content: {
                        text: function(event, api) {
                            $.ajax({
                                url: 'fetch/getnotifications.php', // Use href attribute as URL
                                dataType: 'json'
                            })
                            .then(function(content) {
                                if(!content[0].none){
                                    var target = "";
                                    for(var i in content){
                                        var not = content[i].not;  
                                        target+='<br>'+not;  
                                    }
                                    api.set('content.text', "<span id='nots-container'>"+target+"</span>");
                                    //$('#notify').effect("highlight", {}, 3000);
                                    $('#notifyimg').attr("src", "images/whitealert.png");
                                    markNotifications();
                                }else
                                    api.set('content.text', content[0].none);
                            
                                api.set('content.title', 'Most Recent');
                                api.set('hide.fixed', 'true');
                                api.set('hide.delay', '200');
                                api.set('hide.effect', function(){
                                    $(this).slideUp();
                                });
                                api.set('show.effect', function(){
                                    $(this).slideDown();
                                });
                   
                            }, function(xhr, status, error) {
                                // Upon failure... set the tooltip content to error
                                api.set('content.text', status + ': ' + error);
                                   
                            });
        
                            return 'Loading..'; // Set some initial text
                        }
                    },
                    position: {
                        my: 'top center',  // Position my top left...
                        at: 'bottom center', // at the bottom right of...
                        target: $('#notify') // my target
                    },
                    style: 'qtip-tipsy' //'qtip-bootstrap'
                });
           
            }
            function markNotifications(){
                $('[id*="unread"]').unbind('hover').on('hover',function(){
                    var nid = this.id.substr(7, this.id.length);
                    $.ajax({
                        url: 'forms/marknotification.php?nid='+nid,
                        success: function(response){
                            if(response == "success")
                                $('#unread_'+nid).removeClass('unread').addClass('read');
                        }
                    });
                });
            }
            function checkNotifications() {
                var request = 'fetch/check-notifications.php';
                $.ajax({
                    url: request,
                    async: false,
                    cache: false,
                    success: function(result) {
                        //alert(result.payload);
                        if (result == 'update') {        // new/unchecked data
                            $('#notifyimg').attr("src", "images/redalert.png");
                            if(!shaked)
                                $('#notifyimg').effect("shake", {}, 1000);
                            shaked=true;
                            loadNotifications();
                        }
                    }
                });
            }
   
            timer = setInterval(function() {
                if(!hovering)
                    checkNotifications();
                //alert(lastcheck);
            }, 5000);
        
        
            //--------------------- END NOTIFICATIONS------------------------// 
            //---------------ACTIVITY----------//
              
            //---------------Activity-----------//
            $("#tag-mark").unbind('click').on("click",function(e){
                var id = '#'+this.id+' a';
                $.ajax({
                    type: "POST",
                    url: 'forms/readlater.php',
                    data: {tid:<?php echo $tid ?>},
                    cache: false,
                    success: function(response){
                        //alert(response);
                        if(response == 'new'){
                            $(id+' img').attr('src', 'images/unmark.png');
                            $(id).prop('title', 'marked');
                        }else{
                            $(id +' img').attr('src', 'images/mark.png');
                            $(id).prop('title', 'mark this tag for later');
                        }
                       
                    }
                });
                return false;  
            });
            //---------------------READ LATER--------------------------//
            //readapi.toggle(true);
            function loadTags(){
                var readbox = $('<div />').qtip({
                    content: {
                        text: $('#read-post'),
                        title: '<b>Marked Tags</b>',
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
            
                var readapi = readbox.qtip('api');
                $('#readlater').unbind('click').on('click',function(e){
                    e.preventDefault();
                    $.ajax({
                        url: 'fetch/gettags.php',
                        dataType: 'json',
                        success: function(data){
                            if(!data[0].none){
                                $('#read-post').html("");
                                $('#read-post').html("<div>");
                                for(var i in data){
                                    $('#read-post').append(
                                    '<a href="room.php?cat='
                                        +data[i].cat+'&tag='
                                        +data[i].tag.substr(1,data[i].tag.length)+'">'
                                        +data[i].tag+'</a><span style="float: right">'+data[i].cat+'</span><br>');
                                }
                                $('#read-post').append("</div>");
                            }else{
                                $('#read-post').html(data[0].none);
                            }
                            readapi.toggle(true);
                        }
                    });
         
                });
            }
            //--------------------READ LATER--------------------------------------------//
            function commenturl(){
                var target = <?php echo $not ?>+""; //turn it to a string
                if(target != ""){
                    var cid = target.substr(1, target.length);
                    var side = target.substring(0, 1);
                    var target_element = $('#cb'+cid);
                    $('.content'+side+' .final-comments').prepend(target_element);
                    $('#cb'+cid).effect("highlight", {}, 3000);
                }
            }
            $("#s1, #s2").on("click",function(e){
                if(this.id == "s1"){
                    var input = $.trim($('#comment1').val()); //not empty
                    var side = 1;
                    $("#side").val(side);
                } else{
                    var input = $.trim($('#comment2').val());
                    var side = 2;
                    $("#side").val(side);
                }
                var form = $("#roompost-form");
                
                if(input.length >= 1){
                    $.ajax({
                        type: "POST",
                        url: form.attr( 'action' ),
                        data: form.serialize(),
                        cache: false,
                        success: function(response){
                            //alert(response);
                            form[0].reset();
                            $('#1x,#2x').val("");
                            getcomments(side);
                            $('.content'+side).animate({
                                scrollTop: $('#cb'+response)
                            }, 2000);
                            $('html body').animate({
                                scrollTop: $('#cb'+response)
                            }, 1000);
                           
                            $('#cb'+response).effect("highlight", {}, 3000);
                        }
                    });
                }
            
                return false;  
            });
            
            commenturl(); 
            
        });
    </script>