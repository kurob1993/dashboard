/*   
Template Name: Color Admin - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.4
Version: 1.7.0
Author: Sean Ngu
Website: http://www.seantheme.com/color-admin-v1.7/admin/
*/
var blue="#348fe2",
blueLight="#5da5e8",
blueDark="#1993E4",
aqua="#49b6d6",
aquaLight="#6dc5de",
aquaDark="#3a92ab",
green="#00acac",
greenLight="#33bdbd",
greenDark="#008a8a",
orange="#f59c1a",
orangeLight="#f7b048",
orangeDark="#c47d15",
dark="#2d353c",
grey="#b6c2c9",
purple="#727cb6",
purpleLight="#8e96c5",
purpleDark="#5b6392",
red="#ff5b57";
var handleVectorMap=function() {
    "use strict";
    if($("#world-map").length!==0) {
        $("#world-map").vectorMap( {
            map:"world_mill_en", scaleColors:["#e74c3c", "#0071a4"], normalizeFunction:"polynomial", hoverOpacity:.5, hoverColor:false, markerStyle: {
                initial: {
                    fill: "#4cabc7", stroke: "transparent", r: 3
                }
            }
            , regionStyle: {
                initial: {
                    fill: "rgb(97,109,125)", "fill-opacity": 1, stroke: "none", "stroke-width": .4, "stroke-opacity": 1
                }
                , hover: {
                    "fill-opacity": .8
                }
                , selected: {
                    fill: "yellow"
                }
                , selectedHover: {}
            }
            , focusOn: {
                x: .5, y: .5, scale: 0
            }
            , backgroundColor:"#2d353c", markers:[ {
                latLng: [41.9, 12.45], name: "Vatican City"
            }
            , {
                latLng: [43.73, 7.41], name: "Monaco"
            }
            , {
                latLng: [-.52, 166.93], name: "Nauru"
            }
            , {
                latLng: [-8.51, 179.21], name: "Tuvalu"
            }
            , {
                latLng: [43.93, 12.46], name: "San Marino"
            }
            , {
                latLng: [47.14, 9.52], name: "Liechtenstein"
            }
            , {
                latLng: [7.11, 171.06], name: "Marshall Islands"
            }
            , {
                latLng: [17.3, -62.73], name: "Saint Kitts and Nevis"
            }
            , {
                latLng: [3.2, 73.22], name: "Maldives"
            }
            , {
                latLng: [35.88, 14.5], name: "Malta"
            }
            , {
                latLng: [12.05, -61.75], name: "Grenada"
            }
            , {
                latLng: [13.16, -61.23], name: "Saint Vincent and the Grenadines"
            }
            , {
                latLng: [13.16, -59.55], name: "Barbados"
            }
            , {
                latLng: [17.11, -61.85], name: "Antigua and Barbuda"
            }
            , {
                latLng: [-4.61, 55.45], name: "Seychelles"
            }
            , {
                latLng: [7.35, 134.46], name: "Palau"
            }
            , {
                latLng: [42.5, 1.51], name: "Andorra"
            }
            , {
                latLng: [14.01, -60.98], name: "Saint Lucia"
            }
            , {
                latLng: [6.91, 158.18], name: "Federated States of Micronesia"
            }
            , {
                latLng: [1.3, 103.8], name: "Singapore"
            }
            , {
                latLng: [1.46, 173.03], name: "Kiribati"
            }
            , {
                latLng: [-21.13, -175.2], name: "Tonga"
            }
            , {
                latLng: [15.3, -61.38], name: "Dominica"
            }
            , {
                latLng: [-20.2, 57.5], name: "Mauritius"
            }
            , {
                latLng: [26.02, 50.55], name: "Bahrain"
            }
            , {
                latLng: [.33, 6.73], name: "São Tomé and Príncipe"
            }
            ]
        }
        )
    }
}

;

var getMonthName=function(e) {
    var t=[];
    t[0]="January";
    t[1]="February";
    t[2]="March";
    t[3]="April";
    t[4]="May";
    t[5]="Jun";
    t[6]="July";
    t[7]="August";
    t[8]="September";
    t[9]="October";
    t[10]="November";
    t[11]="December";
    return t[e]
}

;
var getDate=function(e) {
    var t=new Date(e);
    var n=t.getDate();
    var r=t.getMonth()+1;
    var i=t.getFullYear();
    if(n<10) {
        n="0"+n
    }
    if(r<10) {
        r="0"+r
    }
    t=i+"-"+r+"-"+n;
    return t
}

;
var handleScheduleCalendar=function() {
    var e=["January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December"];
    var t=["S",
    "M",
    "T",
    "W",
    "T",
    "F",
    "S"];
    var n=new Date,
    r=n.getMonth()+1,
    i=n.getFullYear();
    var s=[["2/"+r+"/"+i,
    "Popover Title",
    "#",
    "#00acac",
    "Some contents here"],
    ["5/"+r+"/"+i,
    "Tooltip with link",
    "http://www.seantheme.com/color-admin-v1.3",
    "#2d353c"],
    ["18/"+r+"/"+i,
    "Popover with HTML Content",
    "#",
    "#2d353c",
    'Some contents here <div class="text-right"><a href="http://www.google.com">view more >>></a></div>'],
    ["28/"+r+"/"+i,
    "Color Admin V1.3 Launched",
    "http://www.seantheme.com/color-admin-v1.3",
    "#2d353c"]];
    var o=$("#schedule-calendar");
    $(o).calendar( {
        months:e, days:t, events:s, popover_options: {
            placement: "top", html: true
        }
    }
    );
    $(o).find("td.event").each(function() {
        var e=$(this).css("background-color");
        $(this).removeAttr("style");
        $(this).find("a").css("background-color", e)
    }
    );
    $(o).find(".icon-arrow-left, .icon-arrow-right").parent().on("click", function() {
        $(o).find("td.event").each(function() {
            var e=$(this).css("background-color");
            $(this).removeAttr("style");
            $(this).find("a").css("background-color", e)
        }
        )
    }
    )
}

;

var handleInteractiveChart=function() {
    "use strict";
    function e(e, t, n) {
        $('<div id="tooltip" class="flot-tooltip">'+n+"</div>").css( {
            top: t-45, left: e-55
        }
        ).appendTo("body").fadeIn(200)
    }
    if($("#interactive-chart").length!==0) {
        var t=[[1,
        40],
        [2,
        50],
        [3,
        60],
        [4,
        60],
        [5,
        60],
        [6,
        65],
        [7,
        75],
        [8,
        90],
        [9,
        100],
        [10,
        105],
        [11,
        110],
        [12,
        110],
        [13,
        120],
        [14,
        130],
        [15,
        135],
        [16,
        145],
        [17,
        132],
        [18,
        123],
        [19,
        135],
        [20,
        150]];
        var n=[[1,
        10],
        [2,
        6],
        [3,
        10],
        [4,
        12],
        [5,
        18],
        [6,
        20],
        [7,
        25],
        [8,
        23],
        [9,
        24],
        [10,
        25],
        [11,
        18],
        [12,
        30],
        [13,
        25],
        [14,
        25],
        [15,
        30],
        [16,
        27],
        [17,
        20],
        [18,
        18],
        [19,
        31],
        [20,
        23]];
        var r=[[1,
        ""],
        [2,
        ""],
        [3,
        "May&nbsp;15"],
        [4,
        ""],
        [5,
        ""],
        [6,
        "May&nbsp;19"],
        [7,
        ""],
        [8,
        ""],
        [9,
        "May&nbsp;22"],
        [10,
        ""],
        [11,
        ""],
        [12,
        "May&nbsp;25"],
        [13,
        ""],
        [14,
        ""],
        [15,
        "May&nbsp;28"],
        [16,
        ""],
        [17,
        ""],
        [18,
        "May&nbsp;31"],
        [19,
        ""],
        [20,
        ""]];
        $.plot($("#interactive-chart"), [ {
            data:t, label:"Page Views", color:blue, lines: {
                show: true, fill: false, lineWidth: 2
            }
            , points: {
                show: true, radius: 3, fillColor: "#fff"
            }
            , shadowSize:0
        }
        , {
            data:n, label:"Visitors", color:green, lines: {
                show: true, fill: false, lineWidth: 2
            }
            , points: {
                show: true, radius: 3, fillColor: "#fff"
            }
            , shadowSize:0
        }
        ], {
            xaxis: {
                ticks: r, tickDecimals: 0, tickColor: "#ddd"
            }
            , yaxis: {
                ticks: 10, tickColor: "#ddd", min: 0, max: 200
            }
            , grid: {
                hoverable: true, clickable: true, tickColor: "#ddd", borderWidth: 1, backgroundColor: "#fff", borderColor: "#ddd"
            }
            , legend: {
                labelBoxBorderColor: "#ddd", margin: 10, noColumns: 1, show: true
            }
        }
        );
        var i=null;
        $("#interactive-chart").bind("plothover", function(t, n, r) {
            $("#x").text(n.x.toFixed(2));
            $("#y").text(n.y.toFixed(2));
            if(r) {
                if(i!==r.dataIndex) {
                    i=r.dataIndex;
                    $("#tooltip").remove();
                    var s=r.datapoint[1].toFixed(2);
                    var o=r.series.label+" "+s;
                    e(r.pageX, r.pageY, o)
                }
            }
            else {
                $("#tooltip").remove();
                i=null
            }
            t.preventDefault()
        }
        )
    }
}

;

var DashboardSSO=function() {
    "use strict";
    return {
        init:function() {
            handleInteractiveChart();            
            handleScheduleCalendar();
            handleVectorMap();
        }
    }
}

()