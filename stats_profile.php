<!DOCTYPE html>
<?php session_start();
$username = $_GET['username'];
?>
<html>
    <head>
        <title></title>
        <link href="css/profile-stats.css" rel="stylesheet" />
        <link href="css/kendo/kendo.common.min.css" rel="stylesheet" />
        <link href="css/kendo/kendo.default.min.css" rel="stylesheet" />
        <link href="css/kendo/kendo.dataviz.min.css" rel="stylesheet" />
        <link href="css/kendo/kendo.dataviz.default.min.css" rel="stylesheet" />
        <script src="js/kendo/jquery.min.js"></script>
        <script src="js/kendo/kendo.all.min.js"></script>
    </head>
    <body class="profile-stats-body">
        <a href="profile.php?username=<?php echo $username;?>" ><img src="images/arrow-back.png" style="height:35px;width:35px;"></a>
        <div id="example" class="k-content">
           
            <div class="chart-wrapper">
                <div id="chart"></div>
            </div>
            <script>
                function createChart() {

                    $("#chart").kendoChart({
                        theme:"black",
                        dataSource: {
                            transport: {
                                read: {
                                    url: "get_profile_stats.php?username=<?php echo $username ?>",
                                    dataType: "json"
                                }, schema: {
                                    model: {
                                        fields: {
                                            Occurance: {type: "number"},
                                            Name: {type: "string"}
                                        }
                                    }}
                            }}, //seriesColors: ["#006634", "#90cc38"],
                        title: {
                            position: "top",
                            text: "<?php echo $username ?>'s Statistics"
                        },
                        seriesDefault: {
                            type: "pie",
                            Labels:{
                                visible:"true",
                                background:"#fff"
                            }
                        },
                        series: [
                            {
                                field: "Occurance",
                                categoryField: "Name",
                                type: "pie"
                            }],
                        chartArea: {
                            background: "transparent"
                        },
                        tooltip: {
                            visible: true
                        }
                    });
                }

                $(document).ready(createChart);
                //$(document).bind("kendo:skinChange", createChart);
            </script>
        </div>


    </body>
</html>