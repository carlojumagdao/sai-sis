<?php
    foreach($infos as $info){
        $strDonName = $info->Name;
        $strDonPicPath = $info->strLearPicPath;
        $strDonVision = $info->Vision;
        if($info->strLearDream == null){
            $strDonDream = "No dream to show.";
        } else{
            $strDonDream = $info->strLearDream;
        }
        
    }
    foreach($countStories as $countStory){
        $intCountStory = $countStory->total;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <title>Donee Profile | Silid Aralan</title>

  <!-- CORE CSS-->
    <link rel="stylesheet" href="{{ URL::asset('assets/js/plugins/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link href="{{ URL::asset('assets/css/materialize.css') }}" type="text/css" rel="stylesheet" media="screen,projection">
        <link href="{{ URL::asset('assets/css/page-center.css') }}" type="text/css" rel="stylesheet" media="screen,projection"> 
    <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
    <style type="text/css">
    h1,h2,h3,h4,h5,h6{
        font-weight: 300;
    }
    h1{
        margin: 4%;
    }
    .card-panel {
        background-color: rgba(255, 255, 255, 0.48);
        padding: 10px;
    }
    input[type=text]:focus:not([readonly]), input[type=password]:focus:not([readonly]), input[type=email]:focus:not([readonly]), input[type=url]:focus:not([readonly]), input[type=time]:focus:not([readonly]), input[type=date]:focus:not([readonly]), input[type=datetime-local]:focus:not([readonly]), input[type=tel]:focus:not([readonly]), input[type=number]:focus:not([readonly]), input[type=search]:focus:not([readonly]), textarea.materialize-textarea:focus:not([readonly]) {
        border-bottom: 1px solid black !important;
        box-shadow: 0 1px 0 0 black !important;
    }

    input[type=text]:focus:not([readonly]) + label, input[type=password]:focus:not([readonly]) + label, input[type=email]:focus:not([readonly]) + label, input[type=url]:focus:not([readonly]) + label, input[type=time]:focus:not([readonly]) + label, input[type=date]:focus:not([readonly]) + label, input[type=datetime-local]:focus:not([readonly]) + label, input[type=tel]:focus:not([readonly]) + label, input[type=number]:focus:not([readonly]) + label, input[type=search]:focus:not([readonly]) + label, textarea.materialize-textarea:focus:not([readonly]) + label {
        color: black !important;
    }
    .card-action{
        border-radius: 12px;
    }
    .parallax-container {
        overflow: visible; 
    }

    
</style>

    <script src="{{ URL::asset('assets/js/jquery-1.11.2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/google-chart-js/loader.js') }}">  </script>
    <script type="text/javascript">
        google.charts.load('43', {'packages':['corechart',]}); // Change 44 to current when you upload to get the current version from google.
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {

            var grdData = new google.visualization.arrayToDataTable([
            ['Grade Level', 'Grade'],
                @foreach($grades as $grade) 
                ["{{$grade->intGrdLvl}}", {{$grade->Average}}],
                @endforeach
            ]);

            var grdOpt = {
                width:'100%',
                height:'100%',
                legend: { position: 'none' },
                hAxis: {
                  title: 'Grade Level',
                },
            };
            var grdChart = new google.visualization.ColumnChart(document.getElementById('top_x_div'));
            grdChart.draw(grdData, grdOpt);

            var subjData = google.visualization.arrayToDataTable([
              ['Grade Level', "Grade"],
                @foreach($highSubj as $highSub) 
                    ["{{$highSub->intGrdLvl}}", {{$highSub->$subject}}],
                @endforeach
            ]);

            var subjOpt = {
                width:'100%',
                height:'100%',
              curveType: 'function',
              legend: { position: 'none' },
              hAxis: {
                  title: 'Grade Level',
                },
            };

            var subjChart = new google.visualization.LineChart(document.getElementById('curve_chart'));

            subjChart.draw(subjData, subjOpt);

            var attData = google.visualization.arrayToDataTable([
              ['Attendance', 'School Days'],
              ['Present', {{$present}}],
              ['Absent',  {{$absent}}],
            ]);

            var attOpt = {
                width:'100%',
                height:'100%',
                chartArea:{right:0,bottom:5,left:0,top:5,width:'100%',height:'100%'},
                legend: { position: 'right' },
                colors:['#5cb85c','#d9534f'],
                pieHole: 0.3,
            };

            var attChart = new google.visualization.PieChart(document.getElementById('piechart'));

            attChart.draw(attData, attOpt);

        }  
        $(window).resize(function(){
            drawChart();
        });  
    </script>
</head>

    <body background="{{ URL::asset('assets/images/login-bg-1.png') }}" class="parallax-container">
    <div class="row main" id="page-wrap">
        <div class="col s12">
            <center>
            <img id="user-pic" src="{{ URL::asset('assets/images/uploads/'.$strDonPicPath.'') }}" class= "circle responsive-img valign profile-image" width="200px" />
            </center>
        </div>
        <div class="center"><h4>{{$strDonName}}</h4></div>
        <div class="center"><h5>Future {{$strDonVision}}</h5></div>
        <div class="col s6 m6 l6">
            <div class=" z-depth-4 card-panel card-content">
                <center>
                <h1>{{$intCountStory}}</h1>
                <p><img src="{{ URL::asset('assets/images/story.png') }}" width="15px"/> Success Stories</p>
                <div class="card-action green darken-1">
                    <a class="white-text stories">View Details</a>
                </div>
                </center>
            </div>
        </div>
        <div class="col s6 m6 l6">
            <div class=" z-depth-4 card-panel card-content">
                <center>
                <h1>{{$dblAttAverage}}%</h1>
                <p><img src="{{ URL::asset('assets/images/attendance.png') }}" width="15px"/> Attendance</p>
                <div class="card-action blue darken-1">
                    <a class="white-text attendance">View Details</a>
                </div>
                </center>
            </div>
        </div>
        <div class="col s6 m6 l6">
            <div class=" z-depth-4 card-panel card-content">
                <center>
                <h1>{{$dblGradeAverage}}%</h1>
                <p><img src="{{ URL::asset('assets/images/grade.png') }}" width="15px"/>  Average Grade</p>
                <div class="card-action orange darken-1">
                    <a class="white-text grades">View Details</a>
                </div>
                </center>
            </div>
        </div>
        <div class="col s6 m6 l6">
            <div class=" z-depth-4 card-panel card-content">
                <center>
                <h1 style="margin-left: -1%;">2016</h1>
                <p><img src="{{ URL::asset('assets/images/dream.png') }}" width="15px"/> Dreams</p>
                <div class="card-action red darken-1">
                    <a class="white-text dream">View Details</a>
                </div>
                </center>
            </div>
        </div>
    </div>
    <div class="row stories-div hide" id="page-wrap">
        <h4 class="center"><b>Success stories</b></h4>
        @foreach($stories as $story)
            <div cs="col s12 m12 l12">
                <div class=" z-depth-4 card-panel card-content">
                    <h4>{{$story->strStoTitle}}</h4>
                    <p>{{$story->strStoAuthor}}</p>
                    <p style="font-size: 12px;margin-top: -15px;"><i>Author</i></p>
                    <p>{{$story->strStoContent}}</p>
                </div>
            </div>
        @endforeach
        <div cs="col s12 m12 l12">
            <a class="btn col s12 sto_back" id="">Back</a>
            &nbsp;
        </div>
    </div>
    <div class="row grades-div hide" id="page-wrap">
        <div class="col s12 m12 l12">
            <div class=" z-depth-4 card-panel card-content">
                <h6 class="center"><b>School Grades</b></h6>
                <div id="top_x_div"></div>
            </div>
            <div class=" z-depth-4 card-panel card-content">
                <h6 class="center"><b>Best Subject ({{$subjectName}}) Grade</b></h6>
                <div id="curve_chart"></div>
            </div>
        </div>
        <div cs="col s12 m12 l12">
            <a class="btn col s12 grades_back" id="">Back</a>
            &nbsp;
        </div>
    </div>
    <div class="row dream-div hide" id="page-wrap">
        <div cs="col s12 m12 l12">
            <h4 class="center"><b>2016 Dreams</b></h4>
            <div class=" z-depth-4 card-panel card-content">
                <p>{{$strDonDream}}</p>
            </div>
        </div>
        <div cs="col s12 m12 l12">
            <a class="btn col s12 part_dream blue" id="">I want to be part your dream</a>
            &nbsp;
        </div>
        <div cs="col s12 m12 l12">
            <a class="btn col s12 dream_back" id="">Back</a>
            &nbsp;
        </div>
    </div>
    <div class="row attendance-div hide" id="page-wrap">
        <div class="col s12 m12 l12">
            <div class=" z-depth-4 card-panel card-content">
                <h6 class="center"><b>Attendance</b></h6>
                <div id="piechart"></div>
            </div>
        </div>
        <div cs="col s12 m12 l12">
            <a class="btn col s12 attendance_back" id="">Back</a>
            &nbsp;
        </div>
    </div>
    <div class="row dream-part-div hide" id="page-wrap">
        <div cs="col s12 m12 l12">
            <h5 class="center"><b>How can you be part of his/her dream?</b></h5>
                Thank you for your intension of fulfilling our learners dream, Kindly send us your message on how you want this dream to come alive.
                <br>
                <h6>Email us at: <b>info@silidaralan.org</b></h6>
        </div>
        <div cs="col s12 m12 l12">
            <a class="btn col s12 home" id="">Back To Home</a>
            &nbsp;
        </div>
    </div>
    <script src="{{ URL::asset('assets/js/materialize.js') }}"></script>
    <script src="{{ URL::asset('assets/js/materialize.js') }}"></script>
    <script src="{{ URL::asset('assets/js/plugins.js') }}"></script>
    <script src="{{ URL::asset('assets/js/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script type="text/javascript">
        $(window).load(function() {
            $( ".dream-part-div" ).hide();
        });
        $( ".stories" ).click(function() {
            $( ".main" ).hide(1000);
            $( ".stories-div" ).removeClass("hide");
        });
        $( ".grades" ).click(function() {
            $( ".main" ).hide(1000);
            $( ".grades-div" ).removeClass("hide");
        });
        $( ".dream" ).click(function() {
            $( ".main" ).hide(1000);
            $( ".dream-part-div" ).hide();
            $( ".dream-div" ).removeClass("hide");   
        });
        $( ".attendance" ).click(function() {
            $( ".main" ).hide(1000);
            $( ".attendance-div" ).removeClass("hide");
        });
        $( ".dream-part" ).click(function() {
            $( ".main" ).hide(1000);
            $( ".dream-part-div" ).removeClass("hide");
        });
    </script>
    <script type="text/javascript">
        $( ".sto_back" ).click(function() {
          $( ".main" ).show(1000);
          $( ".stories-div" ).addClass("hide");
        });
        $( ".grades_back" ).click(function() {
          $( ".main" ).show(1000);
          $( ".grades-div" ).addClass("hide");
        });
        $( ".dream_back" ).click(function() {
          $( ".main" ).show(1000);
          $( ".dream-div" ).addClass("hide");
        });
        $( ".part_dream" ).click(function() {
          $( ".main" ).hide(1000);
          $( ".dream-div" ).addClass("hide");
          $( ".dream-part-div" ).removeClass("hide");
          $( ".dream-part-div" ).show();
        });
        $( ".attendance_back" ).click(function() {
          $( ".main" ).show(1000);
          $( ".attendance-div" ).addClass("hide");
        });
        $( ".home" ).click(function() {
          $( ".main" ).show(1000);
          $( ".dream-part-div" ).addClass("hide");
        });
    </script>
</body>
</html>