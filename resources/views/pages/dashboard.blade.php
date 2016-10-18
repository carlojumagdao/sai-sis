<?php
// Created at: Sublime Text 3
// Writer: Carlo Jumagdao
// Date: April 06, 2016
// Time: 10:05am
?>

@extends('master')
@section('title')
    {{"Dashboard"}}
@stop   
@section('charts')
    <script src="{{ URL::asset('assets/google-chart-js/loader.js') }}">  </script>
    <script type="text/javascript">
      google.charts.load('43', {'packages':['bar','corechart']});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var grdData = new google.visualization.arrayToDataTable([
          ['Session', 'Average Grade(%)','No. of learners','Attendance(%)'],
          @for($intCounter = 0; $intCounter < sizeOf($sesgrades); $intCounter++)
            ["{{$sesgrades[$intCounter]->session}}", {{$sesgrades[$intCounter]->content}},"{{$seslearners[$intCounter]->content}}",{{$sesattendance[$intCounter]->attendance}}],
          @endfor
        ]);

        var grdOpt = {
          width: 950,
          legend: { position: 'bottom', maxLines: 3 },
          bar: { groupWidth: "50%" }
        };

        var grdChart = new google.charts.Bar(document.getElementById('top_x_div'));
        grdChart.draw(grdData, google.charts.Bar.convertOptions(grdOpt));


        var locLearData = google.visualization.arrayToDataTable([
          ['School', 'No. of learners'],
            @foreach($loclears as $loclear) 
                ["{{$loclear->location}}", {{$loclear->content}}],
            @endforeach
        ]);

        var locLearOpt = {
            title: 'Learners per location',
            chartArea:{right:0,bottom:10,left:0,top:40,width:'55%',height:'75%'},
                hAxis: {
                  title: 'Learners per location',
                },
            pieHole: 0.4,
        };

        var locLearChart = new google.visualization.PieChart(document.getElementById('locLearner'));

        locLearChart.draw(locLearData, locLearOpt);

        var progLearData = google.visualization.arrayToDataTable([
          ['Program', 'No. of learners'],
            @foreach($proglears as $proglear) 
                ["{{$proglear->program}}", {{$proglear->content}}],
            @endforeach
        ]);

        var progLearOpt = {
            title: 'Learners per program',
            chartArea:{right:0,bottom:10,left:0,top:40,width:'55%',height:'75%'},
                hAxis: {
                  title: 'Learners per program',
                },
            pieHole: 0.4,
        };

        var progLearChart = new google.visualization.PieChart(document.getElementById('progLearner'));

        progLearChart.draw(progLearData, progLearOpt);
      };
    </script>
@stop
@section('content')
<!-- START CONTENT -->
    @section('title-page')
        {{"Dashboard"}}
    @stop  
    <!--start container-->
    <div class="container">
        <div class="section">
            <div class="row">
                <div class="col s12 m6 l3">
                    <div class="card">
                        <div class="card-content green white-text">
                            <p style="font-size: 18px;" class="card-stats-title center"><i class="mdi-social-school"></i> No. of learners</p>
                            <h4 style="font-weight: bold; margin: 1.5% 1% 1% 1.5%" class="card-stats-number center">{{$intLearners}}</h4>
                            <!-- <p class="card-stats-compare center">
                                <a href = "dv-service.php" class="yellow-text">View all</a>
                            </p>    -->
                        </div>
                        <div class="card-action green darken-2">
                            <div id="clients-bar"></div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6 l3">
                    <div class="card">
                        <div class="card-content purple white-text">
                            <p style="font-size: 18px;" class="card-stats-title center"><i class="mdi-maps-location-history"></i> No. of donors</p>
                            <h4 style="font-weight: bold; margin: 1.5% 1% 1% 1.5%" class="card-stats-number center">{{$intDonors}}</h4>
                            <!-- <p class="card-stats-compare center">
                                <a href = "dv-service.php" class="yellow-text">View all</a>
                            </p>  -->  
                        </div>
                        <div class="card-action purple darken-2">
                            <div id="sales-compositebar"></div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6 l3">
                    <div class="card">
                        <div class="card-content blue-grey white-text">
                            <p style="font-size: 18px;" class="card-stats-title center"><i class="mdi-editor-attach-money"></i> Total Donations</p>
                            <h4 style="font-weight: bold; margin: 1.5% 1% 1% 1.5%" class="card-stats-number center">₱ {{number_format($dblAmount)}}</h4>
                        </div>
                        <div class="card-action  blue-grey darken-2">
                            <div id="profit-tristate"></div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6 l3">
                    <div class="card">
                        <div class="card-content deep-purple white-text">
                            <p style="font-size: 18px;" class="card-stats-title center"><i class="mdi-action-grade"></i> Gen. Average Grade</p>
                            <h4 style="font-weight: bold; margin: 1.5% 1% 1% 1.5%" class="card-stats-number center">{{$dblAverage}}%</h4>
                        </div>
                        <div class="card-action  deep-purple darken-2">
                            <div id="invoice-line"></div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m12 l6">
                    <div class="card">
                        <div class="card-content white-text">
                            <div id="locLearner" style="width: 500px; height: 300px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m12 l6">
                    <div class="card">
                        <div class="card-content white-text">
                            <div id="progLearner" style="width: 500px; height: 300px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m12 l12">
                    <div class="card">
                        <div class="card-content white-text">
                            <div id="top_x_div" style="width: 600px; height: 350px;"></div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <!--end container-->
</section>
<!-- END CONTENT -->
@stop