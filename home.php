<?php
session_start();
$user = $_SESSION['username'];

if ($_SESSION['status'] == FALSE)
    header("Location:index.php");
//echo 'hello ' . $_SESSION['username'] . '!';
?>
<!DOCTYPE html>
<!--[if lt IE 8 ]><html class="no-js ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="no-js ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 8)|!(IE)]><!--><html class="no-js" lang="en"> <!--<![endif]-->
    <head>

        <!--- Basic Page Needs
        ================================================== -->
        <meta charset="utf-8">
        <title>Home</title>
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
        <link rel="stylesheet" href="css/qtip.css">
        <link rel="stylesheet" href="css/search.css">
        <link rel="stylesheet" type="text/css" href="css/homepage.css"/>
        <link rel="stylesheet" href="css/jquery.fancybox.css" type="text/css" media="screen" />
        <link rel="stylesheet" type="text/css"
              href="css/jquery-ui-1.10.4.min.css" />
        <link rel="stylesheet" href="css/News/news.css"/>

        <style>
            .ui-autocomplete {
                max-height: 100px;
                overflow-y: auto;
                /* prevent horizontal scrollbar */
                overflow-x: hidden;
            }
        </style>
        <script>
            var stats;
        </script>
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

                    <div class="logo">
                        <a href="home.php"><img src="images/logo.png"/></a>
                        <a id="readlater"  title="Show marked tags" href="#"><img id="readimg" src="images/book.png"/></a>
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

                    </nav> <!-- end #nav-wrap -->

                </div>

            </div>

        </header> <!-- Header End -->


        <!-- Content
        ================================================== -->
        <div class="content-outer">

            <div id="page-content" class="row page">

                <section>

                    <div id="alert-post" style="display:none">
                        <ul>
                            <li><b>Hash Format: #side1_side2</b></li>
                            <li><b>Add a Comment</b></li>
                            <li><b>Select a Category</b></li>
                            <li><b>Choose a side</b></li>
                        </ul>
                    </div>
                    <div id="read-post" style="display:none"></div>

                    <div class="start" id ="start">
                        <form id="homepost-form" name="homepost-form" method="post" action="forms/homepost.php">
                            <div class="apply" style="display:none">
                                <div id="rn" class="rn">
                                    <input type="hidden" name="roomname" id="roomname" value=""/> <span id ="roomnamex"></span>
                                </div>
                                <select id ="cat" class="cat" name="cat">
                                    <option value="default" title="">Add a Category</option>
                                    <option value="Games" title="">Games</option>
                                    <option value="Movies" title="">Movies</option>
                                    <option value="Music" title="">Music</option>
                                    <option value="Food" title="">Food</option>
                                    <option value="Travel" title="">Travel</option>
                                    <option value="Politics" title="">Politics</option>
                                    <option value="Sports" title="">Sports</option>
                                    <option value="Tech" title="">Tech</option>
                                    <option value="Books" title="">Books</option>
                                    <option value="Brands" title="">Brands</option>
                                </select>


                            </div>


                            <div id="commentbox">

                                <textarea class="inputc" name="comment" id="inputc"></textarea>

                            </div>
                            <div id="optbox">
                                <a id="post-help" href="#" title="What is this?"><img src="images/help-16.png" /></a>
                                <input class="postcomment" id="postcomment" value="Post" type="button" />
                                <a id="getroom" data-fancybox-type="ajax" href="" > </a>
                            </div>
                            <div id="roomsides" class="apply"  style="display:none">
                                <input type="radio" checked="checked" name="side" value="1" id="s1"/><span id="s11"></span> <input type="radio" value="2" name="side" id="s2"/><span id="s22"></span>
                            </div>
                        </form>

                    </div>

                </section>
                <!-- section end -->

                <div id="home-title" >
                    <h1 class="half-bottom">Feed</h1>
                    <ul id="nav" class="feed-nav">
                        <li><span id="feed-choice"><a>Top Feed</a></span>
                            <ul>
                                <li><a id="top" value="Top Feed" href="#">Top Feed</a></li>
                                <li><a id="hot" value="Hot Feed" href="#">Hot Feed</a></li>
                            </ul>
                        </li>
                    </ul>

                </div>
                <section>
                    <div class="three columns pull-left" >
                        <p class="description"><span id="desc">Top news in all categories</span>
                        <div id="stat-div"> 
                            <ul class="stats-tabs" id="comment-number">


                            </ul>
                            <ul class="stats-tabs" id="sides">

                            </ul>
                            <ul class="stats-tabs" id="top-comment">

                            </ul>

                        </div>

                        </p>
                    </div>
                    <div class="nine colums pull-right">
                        <div class="accordion" id="section">Categories<span></span></div>
                        <div class="accordion-area" style="display:none">
                            <ul>
                                <li><a href="#" class="categories" id="Games">Games</a  ></li>
                                <li><a href="#"   class="categories" id="Sports" >Sports</a  ></li>
                                <li> <a href="#"   class="categories" id="Politics" >Politics</a  ></li>
                                <li><a href="#"   class="categories" id="Music" >Music</a  ></li>
                                <li><a href="#"   class="categories" id="Movies" >Movies</a  ></li>
                                <li><a href="#"   class="categories" id="Food" >Food</a  ></li>
                                <li><a href="#"   class="categories" id="Tech" >Tech</a  ></li>
                                <li><a href="#"   class="categories" id="Books" >Books</a  ></li>
                                <li><a href="#"   class="categories" id="Brands" >Brands</a  ></li>
                                <li><a href="#"   class="categories" id="Travel" >Travel</a  ></li>
                            </ul>
                        </div>
                        <div id="intro-slider">
                            <div class="flexslider" >

                                <ul class="slides" id="content">

                                </ul>
                            </div>
                        </div>
                    </div>
                </section>
            </div>


        </div> <!-- Content End-->


        <!-- footer
        ================================================== 
        -->
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

        </footer>

        <!-- Footer End-->

        <!-- Java Script
        ================================================== -->
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script type="text/javascript" src="js/jquery-migrate-1.2.1.min.js"></script>


        <script src="js/jquery.flexslider.js"></script>
        <script src="js/doubletaptogo.js"></script>
        <script src="js/init.js"></script>
        <script src="js/qtip.js"></script>
        <script src="js/search.js"></script>
        <script type="text/javascript" src="js/jquery.fancybox.pack.js"></script>
        <script src="js/jquery.pageslide.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="js/jquery.accordion.js"></script>
        <script src="//www.google.com/jsapi?key=AIzaSyA5m1Nc8ws2BbmPRwKu5gFradvD_hgq6G0" type="text/javascript"></script>
        <script src="js/news.js" ></script>
        <script type="text/javascript">

            google.load('search', '1');

        </script>
        <script type="text/javascript"
        src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>



    </body>
    <script>
        $(document).ready(function() {
            var u = "<?php echo $_SESSION['username'] ?>";

            var hashpos;
            var pos;

            var alertbox = $('<div />').qtip({
                content: {
                    text: $('#alert-post'),
                    title: 'You Need to:',
                    button: true
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
                    classes: 'qtip-light qtip-bootstrap qtip-rounded',
                    width: 700
                }
            });
            var readbox = $('<div />').qtip({
                content: {
                    text: $('#read-post'),
                    title: 'You Need to:',
                    button: true
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
                    classes: 'qtip-light qtip-bootstrap qtip-rounded',
                    width: 700
                }
            });

            var alertapi = alertbox.qtip('api');
            var readapi = readbox.qtip('api');

            // $(document).on('keyup','.cart-qty',function( e ) {  
            $('.inputc').unbind('keyup').on("keyup", function(e) {
                var title = $(this).val();
                if (e.keyCode == 51) {
                    var hash = $(this).getCursorPosition();
                    if (title.charAt(hash - 1) == '#') {
                        hashpos = hash - 1;
                    }
                    //----------------------------------AUTO-----------------------------
                    function split(val) {
                        return val.split(/\s+/);
                    }
                    function extractLast(term) {
                        return split(term).pop();
                    }
                    $("#inputc")
                    // don't navigate away from the field on tab when selecting an item
                    .bind("keyup", function(event) {
                        if (event.keyCode === $.ui.keyCode.TAB &&
                            $(this).data("ui-autocomplete").menu.active) {
                            event.preventDefault();
                        }
                    })
                    .autocomplete({
                        source: function(request, response) {
                            //var text = $('#inputc').val().substring(hashpos, hash+1);
                            $.getJSON('autocomplete/getautocomplete.php', {
                                term: extractLast(request.term)
                            }, response);
                        },
                        search: function() {
                            // custom minLength
                            var text = $('#inputc').val().substring(hashpos, hash + 1);
                            //alert(text);
                            if (text.charAt(0) != '#' || text.length < 2) {
                                return false;
                            }
                        },
                        focus: function() {
                            // prevent value inserted on focus
                            return false;
                        },
                        select: function(event, ui) {
                            var terms = split(this.value);
                            // remove the current input
                            terms.pop();
                            // add the selected item
                            terms.push(ui.item.value);
                            /*String.prototype.splice = function( idx, rem, s ) {
                                         return (this.slice(0,idx) + s + this.slice(idx + Math.abs(rem)));
                                         };
                                         this.value = this.value.splice(0, 0, terms.join( " " ));*/
                            // add placeholder to get the comma-and-space at the end
                            terms.push("");
                            this.value = terms.join(" ");

                            var category = ui.item.category;
                            $('select[name="cat"]').find('option[value="' + category + '"]').attr("selected", true);

                            return false;
                        }
                    });
                    //------------------------AUTO-----------------------------------
                }
                if (e.keyCode == 189)
                {
                    var under = $(this).getCursorPosition();
                    if (title.charAt(under - 1) == '_') {
                        unders = under - 1;

                    }
                }
                // user has pressed space
                if (e.keyCode == 32 || e.keyCode == 13) {
                    spacepos = $(this).getCursorPosition() - 1;
                    var title2 = title;
                    var matches = title.match(new RegExp("(#[a-zA-Z0-9]+_[a-zA-Z0-9]+)", ""));

                    if (matches != null) {
                        title = matches[0];
                        var finaltitle = title;
                        var side1 = title.substr(1, title.indexOf('_') - 1);
                        var side2 = title.substr(title.indexOf('_') + 1, title.length);

                        $(this).val($(this).val().replace(/(#[a-zA-Z0-9]+_[a-zA-Z0-9]+)/, ''));
                        $(this).val($(this).val().replace(/[ ]{2,}/, ' '));
                        var s1 = side1.toLowerCase();
                        var s2 = side2.toLowerCase();
                        if (s2 > s1) {

                            $("#s11").text(side1);
                            $("#s22").text(side2);

                            $("#roomname").val(finaltitle.replace(/[ ]{2,}/, ''));
                            $("#roomnamex").html(finaltitle.replace(/[ ]{2,}/, ''));

                            $(".apply").fadeIn();

                        } else {
                            $("#s11").text(side2);
                            $("#s22").text(side1);

                            finaltitle = "#" + side2 + "_" + side1;

                            $("#roomname").val(finaltitle.replace(/[ ]{2,}/, ''));
                            $("#roomnamex").html(finaltitle.replace(/[ ]{2,}/, ''));

                            $(".apply").fadeIn();

                        }
                    }
                }
                return false;
            });
            $(".postcomment").on("click", function(e) {
                var input = $.trim($('#inputc').val()); //not empty
                var rn = $('#roomname').val(); //no hashtag
                var category = $.trim($('#cat').val()); //diff than default
                var s = $("input[name=side]:checked").val();//
                //
                //
                var form = $("#homepost-form");
                //$(".apply").is(":visible")
                if ($(".apply").is(":visible")) {
                    if ((input.length < 1 || input === "" || category === "default")) {
                        //Alert  
                        alertapi.toggle(true);
                    } else {
                        //$('#homepost-form').submit();
                        $.ajax({
                            type: "POST",
                            url: form.attr('action'),
                            data: form.serialize(),
                            cache: true,
                            success: function(response) {
                                //alert(response);
                                rn = rn.substr(1, rn.length);
                                var link = 'room.php?cat=' + category + '&tag=' + rn;
                                form[0].reset();
                                $('.apply').css("display", "none");
                                window.location = link;
                            }
                        });
                    }
                }
                return false;
            });
            $("#post-help").on("click", function(e) {
                e.preventDefault();
                alertapi.toggle(true);
            });

            $("#top, #hot").unbind('click').on("click", function(e) {
                e.preventDefault();
                var value = $(this).html();
                //on success
                if (this.id == "top") {
                    $("#desc").html("Top news in all categories");
                }
                if (this.id == "hot") {
                    $("#desc").html("Hot news in the last 24 hours");
                }
                $("#feed-choice a").html(value);
                loadSlider("Games", this.id);
            });

            //clicks on post
            loadNotifications();
            loadTags();
            loadFeed("Games", "top");
            main_search();
            /* Slide to the left*/
            $("#act").pageslide({direction: "left", href: 'activity.php'});

            $("#profile").pageslide({direction: "left", href: 'profile.php?username=' + u});

            function requestPageslide() {
                $("[id*='u_']").each(function(e) {
                    var username = $(this).html();
                    if (username.charAt(0) == '@')
                        username = username.substr(1, username.length);

                    $(this).pageslide({direction: "left", href: 'profile.php?username=' + username});
                });
            }

            $(document).ajaxSuccess(function() {
                requestPageslide();
            });
        });


        $('#inputc').qtip({
            content: {
                text: '#side1_side2',
                title: 'Hash Format'
            },
            position: {
                target: 'mouse', // Track the mouse as the positioning target
                adjust: {x: 5, y: 5} // Offset it slightly from under the mouse
            },
            hide: {
                event: false,
                inactive: 2000,
                distance: 50
            }

        });
        function slide(category, type) {

            $(".flexslider").remove();
            $("#intro-slider").append("<div class='flexslider'></div>");
            $(".flexslider").html('<div id="loading" ><img src="images/loader.gif" class="ajax-loader"/> </div><ul class="slides" id="content"> </ul>');
            if (type == "top") {
                $.ajax({
                    url: 'News/getNews.php?name=' + category,
                    data: "",
                    dataType: 'json',
                    success: function(data)
                    {
                        stats = data;
                        var s;
                        for (var i in data) {
                            var s = category + "-" + data[i].tagname.replace(/\_/g, ' ');

                            if (i == 0) {
                                OnLoad(s);

                            }
                            else {
                                setTimeout(function() {
                                    OnLoad(s);
                                }, 1000);
                            }
                        }
                    }}).complete(function() {
                    setTimeout(function() {
                        $('.flexslider').flexslider({
                            controlNav: false,
                            start: function(slider) {
                                showStats(slider.currentSlide);
                            },
                            before: function(slider) {
                                showStats((slider.currentSlide + 1) % 2);
                            }
                        });
                        $("#loading").fadeOut("slow");
                    }, 3000);
                });
            }
            if (type == "hot") {
                $.ajax({
                    url: 'News/getHotNews.php?name=' + category,
                    data: "",
                    dataType: 'json',
                    success: function(data)
                    {
                        stats = data;
                        var s;
                        for (var i in data) {
                            var s = category + "-" + data[i].tagname.replace(/\_/g, ' ');

                            if (i == 0) {
                                OnLoad(s);

                            }
                            else {
                                setTimeout(function() {
                                    OnLoad(s);
                                }, 1000);
                            }
                        }
                    }}).complete(function() {
                    setTimeout(function() {
                        $('.flexslider').flexslider({
                            controlNav: false,
                            start: function(slider) {
                                showStats(slider.currentSlide);
                            },
                            before: function(slider) {
                                showStats((slider.currentSlide + 1) % 2);
                            }
                        });
                        $("#loading").fadeOut("slow");
                    }, 3000);
                });
            }
        }
        function showStats(index) {
            if(stats.length > 0){
                var a = parseFloat(stats[index].side1);
                var b = parseFloat(stats[index].side2);
                var total = parseFloat(stats[index].total);
                a = (a / total * 100);
                b = (b / total * 100);
                
                var sides = (stats[index].tagname).slice(1).split("_");
                $("#comment-number").html("<li><a href='#'>" + stats[index].users + " <b>People talking about this.</b></a></li>");
                $("#sides").html('<li><a href="#">' + a.toFixed(1) + ' %<b>' + sides[0] + '</b></a></li> <li><a href="#">' + b.toFixed(1) + ' %<b>' + sides[1] + '</b></a></li>');
                if (stats[index].cid) {
                    $("#top-comment").html("<b>top comment:</b><br>" +
                        "<a id='u_" + stats[index].uid + "' href='#'>@" + stats[index].username + "</a>:<a href='room.php?cat=" + stats[index].category + "&tag=" + stats[index].tagname.slice(1) + "&not=" + parseInt(stats[index].side) + parseInt(stats[index].cid) + "'> " + stats[index].comment + "</a> <b>with " + sides[parseInt(stats[index].side) - 1] + "</b>");
                } else {

                    $("#top-comment").html("No Top comments yet");
                }
            }else{
                alert("There are no tags on this category!");
            }
        }
        function loadFeed(target, type) {
            $('.accordion').accord({
                speed: 'slow'
            });
            loadSlider(target, type);
        }
        function loadSlider(target, type) {
            slide(target, type);
            $("#section").html(target + "<span></span>");
            $("#Games, #Sports, #Politics, #Music,#Movies,#Food,#Tech,#Books,#Brands,#Travel").unbind("click").on("click", function(e) {
                e.preventDefault();
                slide(this.id, type);
                $("#section").html(this.id + "<span></span>");
                $("#section").trigger("click");
            });
        }
        //---------------------READ LATER--------------------------//
        //readapi.toggle(true);
        function loadTags() {
            var readbox = $('<div />').qtip({
                content: {
                    text: $('#read-post'),
                    title: '<b>Marked Tags</b>',
                    button: true
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
            $('#readlater').unbind('click').on('click', function(e) {
                e.preventDefault();
                $.ajax({
                    url: 'fetch/gettags.php',
                    dataType: 'json',
                    success: function(data) {
                        if (!data[0].none) {
                            $('#read-post').html("");
                            $('#read-post').html("<div>");
                            for (var i in data) {
                                $('#read-post').append(
                                '<a href="room.php?cat='
                                    + data[i].cat + '&tag='
                                    + data[i].tag.substr(1, data[i].tag.length) + '">'
                                    + data[i].tag + '</a><span style="float: right">' + data[i].cat + '</span><br>');
                            }
                            $('#read-post').append("</div>");
                        } else {
                            $('#read-post').html(data[0].none);
                        }
                        readapi.toggle(true);
                    }
                });

            });
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
        function loadNotifications() {
            $('#notify').qtip({
                content: {
                    text: function(event, api) {
                        $.ajax({
                            url: 'fetch/getnotifications.php', // Use href attribute as URL
                            dataType: 'json'
                        })
                        .then(function(content) {
                            if (!content[0].none) {
                                var target = "";
                                for (var i in content) {
                                    var not = content[i].not;
                                    target += '<br>' + not;
                                }
                                api.set('content.text', "<span id='nots-container'>" + target + "</span>");
                                $('#notifyimg').attr("src", "images/whitealert.png")
                                markNotifications();
                            } else
                                api.set('content.text', content[0].none);

                            api.set('content.title', 'Most Recent');
                            api.set('hide.fixed', 'true');
                            api.set('hide.delay', '200');
                            api.set('hide.effect', function() {
                                $(this).slideUp();
                            });
                            api.set('show.effect', function() {
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
                    my: 'top center', // Position my top left...
                    at: 'bottom center', // at the bottom right of...
                    target: $('#notify') // my target
                },
                style: 'qtip-tipsy' //'qtip-bootstrap'
            });

        }
        function markNotifications() {
            $('[id*="unread"]').unbind('hover').on('hover', function() {
                var nid = this.id.substr(7, this.id.length);
                $.ajax({
                    url: 'forms/marknotification.php?nid=' + nid,
                    success: function(response) {
                        if (response == "success")
                            $('#unread_' + nid).removeClass('unread').addClass('read');
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
                        if (!shaked)
                            $('#notifyimg').effect("shake", {}, 1000);
                        shaked = true;
                        loadNotifications();
                    }
                }
            });
        }

        timer = setInterval(function() {
            if (!hovering)
                checkNotifications();
            //alert(lastcheck);
        }, 5000);

        //---------------------NOTIFICATIONS------------------------// 
        //---------------------ACITIVTY------------------------------//  



    </script>
    <script>
        (function($, undefined) {
            $.fn.getCursorPosition = function() {
                var el = $(this).get(0);
                var pos = 0;
                if ('selectionStart' in el) {
                    pos = el.selectionStart;
                } else if ('selection' in document) {
                    el.focus();
                    var Sel = document.selection.createRange();
                    var SelLength = document.selection.createRange().text.length;
                    Sel.moveStart('character', -el.value.length);
                    pos = Sel.text.length - SelLength;
                }
                return pos;
            }
        })(jQuery);

    </script>

