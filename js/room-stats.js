var show = false;
var lastClicked = "";
function loadStats(tid, tag){
    tag = tag.substr(1, tag.length);
    AverageSide(tid, tag); //load percent for each side
    
    $('#view-stats a').unbind('click').on('click', function(e){
        e.preventDefault();
        if(show == false){
            show = true;
            $('#stats-section').fadeIn();
            $(this).prop('title', 'hide statistics');
            
            lastClicked = 'g1';
            CommentsOverTime(tid,tag); //by default
        }else{
            show = false;
            $('#stats-section').fadeOut();
            $(this).prop('title', 'view statistics on this page');
        }
    });
    $('#g1').unbind('click').on('click', function(e){
        e.preventDefault();
        if(lastClicked != this.id)
            $("#analysis h5").html("");
        CommentsOverTime(tid,tag);
        lastClicked = this.id;
    })
    $('#g2').unbind('click').on('click', function(e){
        e.preventDefault();
        if(lastClicked != this.id)
            RegressionLineForComments(tid,tag);
        lastClicked = this.id;
    })
}

function AverageSide(tid,tag){
    var side1 = tag.substring(0, tag.indexOf('_'));
    var side2 = tag.substring(tag.indexOf('_')+1, tag.length);
    $.ajax({                                      
        url: "./room-stats/average_side.php?t="+tid, 
        data: "",
        dataType: 'json',  
        success: function(data){
            var a = parseFloat(data[0].side1);
            var b = parseFloat(data[1].side2);
            var total = parseFloat(data[2].total);
            a = (a/total * 100);
            b = (b/total * 100);
            
            $("#a1").html(a.toFixed(1)+'% with '+side1);
            $("#a2").html(b.toFixed(1)+'% with '+side2);
        }      
    });
}

function RegressionLineForComments(tid,tag){
    var side1 = tag.substring(0, tag.indexOf('_'));
    var side2 = tag.substring(tag.indexOf('_')+1, tag.length);
    var DataSource = new kendo.data.DataSource({
        transport: {
            read: function(options) {
                $.ajax( {
                    url: "./room-stats/regression_comments.php?t="+tid+"&name="+tag,
                    dataType: "json",
                    success: function(result) {
                        options.success(result);
                        $("#analysis h5").html("Analysis: " + result[result.length-1].comment);
                    }
                });
            }
        },
        group:{
            field: "group"  
        },
        schema: {
            model: {
                fields: {
                    date: {
                        type: "date",
                        parse: function(value) {
                            return new Date(value * 1000);
                        }
                    }
                }
            }
        }
    });
    $("#chart").kendoChart({
        title: {
            text: "#"+tag+": Regression Line For Comments"
        },
        dataSource: DataSource,
        chartArea: {
            background: ""
        },
        series: [
        {
            name: "#= group.value #",
            type: 'scatter',
            xField: "date",
            yField: "y"
        },
        {
            name: "#= group.value # (Regression Line)",
            type: 'scatterLine',
            xField: "date",
            yField: "ry"
        }
        ],
        xAxis: {
            title: {
                text: "Time in Year - Month/Day/Hour"
            },
            crosshair: {
                visible: true,
                tooltip: {
                    visible: true,
                    format: "{0: yyyy - MMM/d/H }"
                }
            }
        
        },
        yAxis:{
            title: {
                text: "Activity (based on comments)"
            },
            crosshair: {
                visible: true,
                tooltip: {
                    visible: true,
                    format: "{0}"
                }
            }
        },
        theme: "Silver"
    });
    var chart = $("#chart").data("kendoChart");
    chart.options.transitions = false;

    // Subsequent updates won't be animated
    setTimeout(function() {
        src.push({
            value: 3
        });
    }, 2000);
}
function CommentsOverTime(tid, tag) {
    var side1 = tag.substring(0, tag.indexOf('_'));
    var side2 = tag.substring(tag.indexOf('_')+1, tag.length);
    
    $("#chart").kendoChart({
        title: {
            text: "#"+tag+": Progression of Comments Over Months"
        },
        dataSource: {
            transport: {
                read: {
                    url: "./room-stats/comments_time.php?t="+tid,
                    dataType: "json"
                }
            }
        
        },
        legend: {
            position: "bottom"
        },
        chartArea: {
            background: ""
        },
        series: [
        {
            field: "side1",
            name: side1
        },
        {
            field: "side2",
            name: side2
        }
        ],
        categoryAxis: {
            field: "month"
        },
        seriesDefaults: {
            type: "line",
            style: "normal"
        },
        valueAxis: {
            labels: {
                format: "{0}"
            },
            line: {
                visible: false
            },
            axisCrossingValue: -10
        },
        
        tooltip: {
            visible: true
        },
        theme: "Flat"
    });
    var chart = $("#chart").data("kendoChart");
    chart.options.transitions = false;

    // Subsequent updates won't be animated
    setTimeout(function() {
        src.push({
            value: 3
        });
    }, 2000);

}

$(document).bind("kendo:skinChange", CommentsOverTime);
