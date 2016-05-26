<?php
// Created at: Sublime Text 3
// Writer: Carlo Jumagdao
// Date: April 15, 2016
// Time: 10:17am
?>
@extends('master')
@section('title')
    {{"Learner Profile"}}
@stop   
 @foreach($infos as $info)
    <?php 
        $code = $info->strLearCode;
        $fname = $info->strLearFname;
        $lname = $info->strLearLname;
        $session = $info->intLearSesId;
        $gender = $info->blLearGender;
        $school = $info->intLearSchId;
        $bdate = $info->datLearBirthDate;
        $image = "https://s3.amazonaws.com/sai-sis-files/learner/".$info->strLearPicPath."";
        $strDream = $info->strLearDream;
        $vision = $info->strLearVision;
        $contact = $info->strLearContact;
        $male = "";
        $female = "";
        if($gender == 1){
            $male = "checked";
        } else{
            $female = "checked";
        }
    ?>
@endforeach
<?php 
    foreach ($present as $pre) {
        $attPresent = $pre->present;
    }
    foreach ($absent as $abs) {
        $attAbsent = $abs->absent;
    }  
?>
@section('charts')
    <script src="{{ URL::asset('assets/google-chart-js/loader.js') }}">  </script>
    <script type="text/javascript">
      google.charts.load('43', {'packages':['corechart','line','bar','calendar']}); // Change 44 to current when you upload to get the current version from google.
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {

        var calData = new google.visualization.DataTable();
            calData.addColumn({ type: 'date', id: 'Date' });
            calData.addColumn({ type: 'number', id: 'Won/Loss' });
            calData.addRows([
                @foreach($days as $day) 
                    [new Date({{$day->year}},{{--$day->month}},{{$day->day}}),1],
                @endforeach
                @foreach($schDays as $schday) 
                    [new Date({{$schday->year}},{{--$schday->month}},{{$schday->day}}),-1],
                @endforeach
            ]);

            var calChart = new google.visualization.Calendar(document.getElementById('calendar_basic'));

            var calOpt = {
            title: "Silid Aralan Attendance",
            height: 350,
            noDataPattern: {
           backgroundColor: '#ffffff',
           color: '#e1e1ea'
         }
        };

        calChart.draw(calData, calOpt);

        var grdData = new google.visualization.arrayToDataTable([
          ['Grade Level', 'Percentage'],
          @foreach($grades as $grade) 
                ["{{'Grade '.$grade->intGrdLvl}}", {{$grade->Average}}],
            @endforeach
        ]);

        var grdOpt = {
          width: 400,
          legend: { position: 'none' },
          bar: { groupWidth: "50%" }
        };

        var grdChart = new google.charts.Bar(document.getElementById('top_x_div'));
        // Convert the Classic options to Material options.
        grdChart.draw(grdData, google.charts.Bar.convertOptions(grdOpt));


         var subjData = new google.visualization.DataTable();
          subjData.addColumn('string', 'Grade Level');
          subjData.addColumn('number', 'Math');
          subjData.addColumn('number', 'Science');
          subjData.addColumn('number', 'Filipino');
          subjData.addColumn('number', 'English');
          subjData.addColumn('number', 'Makabayan');

          subjData.addRows([
            @foreach($grades as $grade) 
                ["{{'Grade'.$grade->intGrdLvl}}",{{$grade->dblGrdMath}},{{$grade->dblGrdScience}},{{$grade->dblGrdFilipino}},{{$grade->dblGrdEnglish}},{{$grade->dblGrdMakabayan}}],
            @endforeach
          ]);

          var subjOpt = {
            chart: {
              title: 'Grades per subject',
              subtitle: 'in percentage(%)'
            },
            width: 900,
            height: 500,
            axes: {
              x: {
                0: {side: 'top'}
              }
            }
          };

        var subjChart = new google.charts.Line(document.getElementById('line_top_x'));

        subjChart.draw(subjData, subjOpt);

        var attData = google.visualization.arrayToDataTable([
          ['Attendance', 'School Days'],
          ['Present', {{$attPresent}}],
          ['Absent',  {{$attAbsent}}],
        ]);

        var attOpt = {
            chartArea:{right:0,bottom:40,left:0,top:20,width:'55%',height:'75%'},
                hAxis: {
                  title: 'Attendance',
                },
            colors:['#4273e0','#e7711c'],
            pieHole: 0.4,
        };

        var attChart = new google.visualization.PieChart(document.getElementById('piechart'));

        attChart.draw(attData, attOpt);
      }
    </script>
@stop
@section('content')

<!-- START CONTENT -->
    @section('title-page')
        {{"Learner: $fname $lname ($code)"}}
    @stop  
    <!--start container-->
    <div class="container">
        <div class="section">
            <div class="row">
            @if ($errors->any())
                <ul>
                    <blockquote class="error">
                        {!! implode('', $errors->all(
                            '<li>:message</li>'
                        )) !!}
                    </blockquote>
                </ul>
            @endif
            @if (Session::has('message'))
                <div>
                    <blockquote>{{ Session::get('message') }}</blockquote>
                </div>
            @endif
                <div class="col s12 m12">
                    <div id="preselecting-tab" class="section">
                        <div class="row">
                            <div class="col s12 m12 l12">
                                <div class="row">
                                    <div class="col s12">
                                        <ul class="tabs tab-demo-active z-depth-1 blue-grey darken-3">
                                        <li class="tab col s3"><a class="white-text waves-effect waves-light active" href="#overview">Overview</a>
                                        </li>
                                        <li class="tab col s3"><a class="white-text waves-effect waves-light" href="#profile">Profile</a>
                                        </li>
                                        <li class="tab col s3"><a class="white-text waves-effect waves-light" href="#grades">Grades</a>
                                        </li>
                                        <li class="tab col s3"><a class="white-text waves-effect waves-light" href="#attendance">Attendance</a>
                                        </li>
                                        <li class="tab col s3"><a class="white-text waves-effect waves-light" href="#stories">Stories</a>
                                        </li>
                                        </ul>
                                    </div>
                                    <div class="col s12">
                                        <div id="overview" class="col s12  blue-grey lighten-5">
                                            <div class="col s12 m12 l12">
                                                <div class="card white">
                                                    <div class="card-content black-text">
                                                        {{$fname}}'s Performance
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col s12 m6 l6">
                                                <div class="card white">
                                                    <div class="card-content black-text">
                                                        <div id="top_x_div" style="width: 500px; height: 300px;"></div>
                                                    </div>
                                                    <div class="card-action blue-grey darken-1">
                                                        <a href="#">Grades Summary</a>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col s12 m6 l6">
                                                <div class="card white">
                                                    <div class="card-content black-text">
                                                        <div id="piechart" style="width: 500px; height: 300px;"></div>
                                                    </div>
                                                    <div class="card-action blue-grey darken-1">
                                                        <a href="#">Attendance Summary</a>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="col s12 m12 l12">
                                                <div class="card white">
                                                    <div class="card-content black-text">
                                                        <div id="line_top_x"></div>
                                                    </div>
                                                    <div class="card-action blue-grey darken-1">
                                                        <a href="#">Subject's Summary</a>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="col s12 m12 l12">
                                                <div class="card white">
                                                    <div class="card-content black-text">
                                                        <div id="calendar_basic" style="width: 1000px; height: 350px;"></div>
                                                    </div>
                                                    <div class="card-action blue-grey darken-1">
                                                        <a href="#">Attendance's per year</a>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div id="profile" class="col s12 blue-grey lighten-5">
                                            <div class="col s12 m12 l12">
                                                <div class="card white">
                                                    <div class="card-content black-text">
                                                        {{$fname}}'s Profile
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col s12 m12">
                                                <div class="card white">
                                                    <div class="card-content black-text">
                                                        <div class="row">
                                                            {!! Form::open( array(
                                                                'method' => 'post',
                                                                'files' => 'true', 
                                                                'id' => 'form-add-setting',
                                                                'class' => 'col s12',
                                                                'action' => 'learnerController@update'
                                                            ) ) !!}
                                                            <div class="row">
                                                                <div class="col s12 m12 l4">
                                                                    <div class="card-panel2 tooltipped" data-position="top" data-delay="50" data-tooltip="Learner picture">
                                                                        <img id="cand-pic" src="{{$image}}" width="280px" height="280" /> 
                                                                    </div>
                                                                </div>
                                                                <div class="input-field col s12 m12 l7">
                                                                    {!! Form::text
                                                                        ('code', $code, array(
                                                                        'id' => 'code',
                                                                        'maxlength' => 50,
                                                                        'name' => 'txtCode',
                                                                        'required' => true,
                                                                        'readonly' => 'true',)) 
                                                                    !!}
                                                                    {!! Form::label( 'code', 'Student Code:' ) !!}
                                                                </div>
                                                                <div class="input-field col s12 m12 l7">
                                                                    {!! Form::text
                                                                        ('Fname', $fname, array(
                                                                        'id' => 'fname',
                                                                        'placeholder' => 'Juan',
                                                                        'maxlength' => 50,
                                                                        'name' => 'txtFname',
                                                                        'required' => true,)) 
                                                                    !!}
                                                                    {!! Form::label( 'fname', 'First Name:' ) !!}
                                                                </div>
                                                                <div class="input-field col s12 m12 l7">
                                                                    {!! Form::text
                                                                        ('Lname', $lname, array(
                                                                        'id' => 'lname',
                                                                        'placeholder' => 'Dela Cruz',
                                                                        'maxlength' => 50,
                                                                        'name' => 'txtLname',
                                                                        'required' => true,)) 
                                                                    !!}
                                                                    {!! Form::label( 'lname', 'Last Name:' ) !!}
                                                                </div>
                                                                <div class="input-field col s7">
                                        {!! Form::text
                                            ('Vision', $vision, array(
                                            'id' => 'vision',
                                            'placeholder' => 'Teacher',
                                            'maxlength' => 50,
                                            'name' => 'txtVision',
                                            'required' => true,)) 
                                        !!}
                                        {!! Form::label( 'vision', 'What I want to be:' ) !!}
                                    </div>
                                    <div class="col s4">
                                        <div class="file-field input-field">
                                            <div class="btn waves-effect waves-black tooltipped yellow darken-2 grey-text text-darken-4 " data-position="top" data-delay="50" data-tooltip="choose file">
                                                <span>File</span>
                                                <input name = "pic" type="file" onchange="readURL(this);">
                                            </div>
                                            <div class="file-path-wrapper">
                                                <input class="file-path validate yellow-text text-darken-2" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="input-field col s7">
                                        {!! Form::number
                                            ('Contact', $contact, array(
                                            'id' => 'contact',
                                            'placeholder' => '09000000000',
                                            'maxlength' => 50,
                                            'name' => 'txtContact',)) 
                                        !!}
                                        {!! Form::label( 'contact', 'Contact:' ) !!}
                                    </div>
                                    <div class="input-field col s7 offset-s4">
                                        <label for="date">Birthdate</label>
                                        <input id="date" type="date" class="datepicker" name="datBdate" placeholder="YYYY-MM-DD" value="{{$bdate}}">
                                    </div>
                                                                <div class="input-field col s7 offset-s4">
                                                                    {!! Form::select('selSes', $ses_options,  ['id' => 'session','placeholder' => $session]
                                                                    ) !!}
                                                                    {!! Form::label( 'session', 'Session:' ) !!}
                                                                </div>
                                                                <div class="input-field col s7 offset-s4">
                                                                    {!! Form::select('selSchool', $sch_options,  ['id' => 'school','placeholder' => $school]
                                                                    ) !!}
                                                                    {!! Form::label( 'school', 'School:' ) !!}
                                                                </div>
                                                                <div class="input-field col s12 m12 l7 offset-l4">
                                                                <textarea id="dream" class="materialize-textarea" name="txtDream">{{$strDream}}</textarea>
                                                                <label for="dream">Dream</label>
                                                            </div>
                                                                <div class="input-field col s7 offset-s4">
                                                                    <p>
                                                                        <input name="rdGender" type="radio" id="test1" value = "1" {{$male}}/>
                                                                        <label for="test1" class="radlabel">Male</label>
                                                                    </p>
                                                                    <p>    
                                                                        <input name="rdGender" type="radio" id="test2" value="0" {{$female}}/>
                                                                        <label for="test2" class="radlabel">Female</label>
                                                                    </p>
                                                                </div>
                                                                <div class="input-field col s7 offset-s4">
                                                                    {!! Form::submit( 'Update', array(
                                                                        'id' => 'btn-add-setting',
                                                                        'class' => 'btn'
                                                                        )) 
                                                                    !!}
                                                                </div>
                                                            </div>
                                                            {!! Form::close() !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="grades" class="col s12 blue-grey lighten-5">
                                            <div class="col s12 m12 l12">
                                                <div class="card white">
                                                    <div class="card-content black-text">
                                                        {{$fname}}'s School Grades
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col s12 m12 l8">
                                                <div class="card white">
                                                    <div class="card-content black-text" >
                                                        <table class="bordered" id="list">
                                                            <thead>
                                                                <tr>
                                                                    <th data-field="Grade">Level</th>
                                                                    <th data-field="Filipino">Filipino</th>
                                                                    <th data-field="English">English</th>
                                                                    <th data-field="Math">Math</th>
                                                                    <th data-field="Science">Science</th>
                                                                    
                                                                    <th data-field="Makabayan">Makabayan</th>
                                                                    <th data-field="Average">Average</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($grades as $grade)
                                                                <tr>
                                                                    <td class="hide id-grade">{{$grade->intGrdId}}</td>
                                                                    <td>{{$grade->intGrdLvl}}</td>
                                                                    <td>{{round($grade->dblGrdFilipino,2)}}</td>
                                                                    <td>{{round($grade->dblGrdEnglish,2)}}</td>
                                                                    <td>{{round($grade->dblGrdMath,2)}}</td>
                                                                    <td>{{round($grade->dblGrdScience,2)}}</td>
                                                                    
                                                                    <td>{{round($grade->dblGrdMakabayan,2)}}</td>
                                                                    <td><a href="/view/grades/breakdown/{{$grade->intGrdLvl}}/{{$code}}" target="_blank">{{round($grade->Average,2)}}%</a></td>
                                                                    <td>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col s12 m12 l4">
                                                <div class="card white">
                                                    <div class="card-content black-text" >
                                                    <span class="card-title black-text">Add Grade</span>
                                                        <div class="row">
                                                        {!! Form::hidden
                                                            ('', $code, array(
                                                            'name' => 'code',
                                                            'id' => 'code')) 
                                                        !!}
                                                        {!! Form::hidden
                                                            ('', $fname, array(
                                                            'name' => 'fname',
                                                            'id' => 'fname')) 
                                                        !!}
                                                        <div class="input-field col s12 m12 l6">
                                                            {!! Form::number
                                                                ('Level','', array(
                                                                'id' => 'level',
                                                                'maxlength' => 50,
                                                                'name' => 'txtLevel',)) 
                                                            !!}
                                                            {!! Form::label( 'level', 'Grade Level:' ) !!}
                                                        </div>
                                                        <div class="input-field col s12 m12 l6">
                                                            {!! Form::number
                                                                ('Quarter','', array(
                                                                'id' => 'quarter',
                                                                'maxlength' => 50,
                                                                'name' => 'txtQuarter',)) 
                                                            !!}
                                                            {!! Form::label( 'quarter', 'Quarter:' ) !!}
                                                        </div>
                                                        <div class="input-field col s12 m12 l12">
                                                            {!! Form::number
                                                                ('Filipino','', array(
                                                                'id' => 'filipino',
                                                                'maxlength' => 50,
                                                                'name' => 'txtFilipino',)) 
                                                            !!}
                                                            {!! Form::label( 'filipino', 'Filipino:' ) !!}
                                                        </div>
                                                        <div class="input-field col s12 m12 l12">
                                                            {!! Form::number
                                                                ('English','', array(
                                                                'id' => 'english',
                                                                'maxlength' => 50,
                                                                'name' => 'txtEnglish',)) 
                                                            !!}
                                                            {!! Form::label( 'english', 'English:' ) !!}
                                                        </div>
                                                        <div class="input-field col s12 m12 l12">
                                                            {!! Form::number
                                                                ('Math','', array(
                                                                'id' => 'math',
                                                                'maxlength' => 50,
                                                                'name' => 'txtMath',)) 
                                                            !!}
                                                            {!! Form::label( 'math', 'Math:' ) !!}
                                                        </div>
                                                        <div class="input-field col s12 m12 l12">
                                                            {!! Form::number
                                                                ('Science','', array(
                                                                'id' => 'science',
                                                                'maxlength' => 50,
                                                                'name' => 'txtScience',)) 
                                                            !!}
                                                            {!! Form::label( 'science', 'Science:' ) !!}
                                                        </div>
                                                        <div class="input-field col s12 m12 l12">
                                                            {!! Form::number
                                                                ('Makabayan','', array(
                                                                'id' => 'makabayan',
                                                                'maxlength' => 50,
                                                                'name' => 'txtMakabayan',)) 
                                                            !!}
                                                            {!! Form::label( 'makabayan', 'Makabayan:' ) !!}
                                                        </div>
                                                        <div class="input-field col s12">
                                                            {!! Form::submit( 'Submit', array(
                                                                'id' => 'btn-add-setting',
                                                                'class' => 'btn submit-grade'
                                                                )) 
                                                            !!}
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="attendance" class="col s12 blue-grey lighten-5">
                                            <div class="col s12 m12 l12">
                                                <div class="card white">
                                                    <div class="card-content black-text">
                                                        {{$fname}}'s SAI Attendance
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col s12 m12 l8">
                                                <div class="card white">
                                                    <div class="card-content black-text" >
                                                        <table class="bordered" id="att-list">
                                                            <thead>
                                                                <tr>
                                                                    <th data-field="Grade">Date</th>
                                                                    <th data-field="English">Status</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($days as $day)
                                                            <?php $convertDate = date('F j, Y (D)', strtotime($day->datSchoolDay));
                                                            ?>
                                                                <tr>
                                                                    <td class="hide id-att">{{$day->intAttId}}</td>
                                                                    <td>{{$convertDate}}</td>
                                                                    <td>Present</td>
                                                                    <td>
                                                                        <a class='waves-effect waves-light btn-floating btn-small red del-att' data-position='top' data-tooltip='Delete'><i class='mdi-action-delete'></i></a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col s12 m12 l4">
                                                <div class="card white">
                                                    <div class="card-content black-text" id="att-form">
                                                        <span class="card-title black-text">
                                                        Check the present days</span>

                                                        @foreach($schDays as $schDay)
                                                        <?php $convertDate = date('F j, Y (D)', strtotime($schDay->datSchoolDay));
                                                        ?>
                                                        <p>
                                                            <input type="checkbox" class="filled-in" id="{{$schDay->datSchoolDay}}" value="{{$schDay->intSDId}}" name="schdays[]" />
                                                            <label for="{{$schDay->datSchoolDay}}">{{$convertDate}}</label>
                                                        </p>
                                                        @endforeach
                                                        <div class="input-field col s12">
                                                            <button class="btn waves-effect waves-light attendance">Submit</button>
                                                        </div>
                                                        <div>&nbsp;</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="stories" class="col s12 blue-grey lighten-5">
                                            <div class="col s12 m12 l12">
                                                <div class="card white">
                                                    <div class="card-content black-text">
                                                        {{$fname}}'s Successful Stories
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col s12 m12 l7">
                                                <div class="card white">
                                                    <div class="card-content black-text">
                                                        <div class="row">
                                                            <table class="bordered" id="list">
                                                            <thead>
                                                                <tr>
                                                                    <th data-field="no">#</th>
                                                                    <th data-field="title">Title</th>
                                                                    <th data-field="author">Author</th>
                                                                    <th data-field="action">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php $intCounter = 0; ?>
                                                            @foreach($stories as $story)
                                                                <tr>
                                                                    <td class="hide id-story">{{$story->intStoId}}</td>
                                                                    <td class="hide sto-content">{{$story->strStoContent}}</td>
                                                                    <td>{{++$intCounter}}</td>
                                                                    <td class="sto-title">{{$story->strStoTitle}}</td>
                                                                    <td class="sto-author">{{$story->strStoAuthor}}</td>
                                                                    <td>
                                                                    <a class='waves-effect waves-light btn-floating btn-small blue view-sto' data-position='top' data-tooltip='View'><i class='mdi-action-visibility'></i></a>
                                                                    <a class='waves-effect waves-light btn-floating btn-small red del-sto' data-position='top' data-tooltip='Delete'><i class='mdi-action-delete'></i></a>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col s12 m12 l5">
                                                <div class="card white">
                                                    <div class="card-content black-text">
                                                    <span class="card-title black-text">Add Story</span>
                                                        <div class="row">
                                                            <div class="input-field col s12 m12 l12">
                                                                {!! Form::text
                                                                    ('sto-title','', array(
                                                                    'id' => 'sto-title',
                                                                    'maxlength' => 50,
                                                                    'name' => 'txtStoTitle',)) 
                                                                !!}
                                                                {!! Form::label( 'sto-title', 'Title:' ) !!}
                                                            </div>
                                                            <div class="input-field col s12 m12 l12">
                                                                {!! Form::text
                                                                    ('sto-author','', array(
                                                                    'id' => 'sto-author',
                                                                    'maxlength' => 50,
                                                                    'name' => 'txtStoAuthor',)) 
                                                                !!}
                                                                {!! Form::label( 'sto-author', 'Author:' ) !!}
                                                            </div>
                                                            <div class="input-field col s12">
                                                                <textarea id="sto-content" class="materialize-textarea" name="txtStoContent"></textarea>
                                                                <label for="sto-content">Content</label>
                                                            </div>
                                                            <div class="input-field col s12">
                                                                <button class="btn waves-effect waves-light story">Submit</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="view-story" class="modal">
        <div class="modal-content">
            <p id="mod-id" class="hide"></p>
            <h4 id="mod-title"></h4>
            <p id="mod-author"></p>
            <p style="font-size: 12px;margin-top: -15px;"><i>Author</i></p>
            <p id="mod-content"></p>
        </div>
        <div class="modal-footer">
            <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Close</a>
            <button class="btn edit-sto modal-action modal-close waves-effect waves-green yellow darken-2"><i class='mdi-content-create'></i>Edit</button> 
        </div>
    </div>
    <div id="edit-story" class="modal">
        <div class="modal-content">
            <div class="row">
                <div class="input-field col s12 m12 l12">
                    {!! Form::text
                        ('sto-title','', array(
                        'id' => 'sto-title-edit',
                        'maxlength' => 50,
                        'name' => 'txtStoTitle',
                        'placeholder' => ' ',)) 
                    !!}
                    {!! Form::label( 'sto-title-edit', 'Title:' ) !!}
                </div>
                <div class="input-field col s12 m12 l12">
                    {!! Form::text
                        ('sto-author','', array(
                        'id' => 'sto-author-edit',
                        'maxlength' => 50,
                        'name' => 'txtStoAuthor',
                        'placeholder' => ' ',)) 
                    !!}
                    {!! Form::label( 'sto-author-edit', 'Author:' ) !!}
                </div>
                <div class="input-field col s12">
                    <textarea id="sto-content-edit" class="materialize-textarea" name="txtStoContent" placeholder=" "></textarea>
                    <label for="sto-content-edit">Content</label>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Close</a>
                <button class="btn waves-effect waves-light update-story">Update</button>
            </div>
        </div>
    </div>
    <!--end container-->
</section>
<!-- END CONTENT -->
@stop
<!-- <meta name="csrf_token" content="{{ csrf_token() }}" /> -->
@section('script')
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
                reader.onload = function (e) {
                    $('#cand-pic')
                    .attr('src', e.target.result)
                    .width(280)
                    .height(280);
                };
            reader.readAsDataURL(input.files[0]);
        }
    }
    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 15, // Creates a dropdown of 15 years to control year
        format: 'yyyy-mm-dd'
    });
    $(document).on("click", ".submit-grade", function(){
        var id = 0, filipino = 0, math = 0, english = 0, science = 0, makabayan = 0, level = 0, quarter = 0;
        id = document.getElementById("code").value;
        quarter = document.getElementById("quarter").value;
        filipino = document.getElementById("filipino").value;
        english = document.getElementById("english").value;
        math = document.getElementById("math").value;
        science = document.getElementById("science").value;
        makabayan = document.getElementById("makabayan").value;
        level = document.getElementById("level").value;
        fname = document.getElementById("fname").value;
        $.ajax({
            url: "{{ URL::to('learner/grade') }}",
            type:"POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: { code : id, txtFilipino : filipino,txtMath : math,txtEnglish : english,txtScience : science,txtMakabayan : makabayan,txtLevel : level, fname : fname,txtQuarter:quarter},
            success:function(data){
                $( "#grades" ).empty();
                $( "#grades" ).append(data);
            },error:function(){ 
                alert("Error: Please check your input.");
            }
        }); //end of ajax
    });
    $(document).on("click",".attendance", function(){
        var cboxes = document.getElementsByName('schdays[]');
        id = document.getElementById("code").value;
        fname = document.getElementById("fname").value;
        var len = cboxes.length;
        var present = new Array();
        var counter = 0;
        for (var i=0; i < len; i++) {
            if(cboxes[i].checked){
                present[counter] = cboxes[i].value;
                counter++;
            }   
        }
        $.ajax({
            url: "{{ URL::to('learner/attendance') }}",
            type:"POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: { code : id, attendance : present, fname:fname },
            success:function(data){
                $( "#attendance" ).empty();
                $( "#attendance" ).append(data);
            },error:function(){ 
                alert("Error: Please check your input.");
            }
        }); //end of ajax
    });
    $(document).on("click", ".del-grade", function(){
        var x = confirm("Are you sure you want to delete this record?");
        if (x){
            var id = $(this).parent().parent().find('.id-grade').text(); 
            var code = document.getElementById("code").value;
            var fname = document.getElementById("fname").value;
            $.ajax({
                url: "{{ URL::to('learner/grade/delete') }}",
                type:"POST",
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf_token"]').attr('content');
                    if (token) {
                          return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                data: { id : id, fname : fname, code : code},
                success:function(data){
                    $( "#grades" ).empty();
                    $( "#grades" ).append(data);
                },error:function(){ 
                    alert("Error: Please check your input.");
                }
            }); //end of ajax
        }
        else
        return false;
        
    });
    $(document).on("click", ".del-sto", function(){
        var x = confirm("Are you sure you want to delete this record?");
        if (x){
            var id = $(this).parent().parent().find('.id-story').text(); 
            var code = document.getElementById("code").value;
            var fname = document.getElementById("fname").value;
            $.ajax({
                url: "{{ URL::to('learner/stories/delete') }}",
                type:"POST",
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf_token"]').attr('content');
                    if (token) {
                          return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                data: { id : id, fname : fname, code : code},
                success:function(data){
                    $( "#stories" ).empty();
                    $( "#stories" ).append(data);
                },error:function(){ 
                    alert("Error: Please check your input.");
                }
            }); //end of ajax
        }
        else
        return false;
        
    });
    $(document).on("click", ".del-att", function(){
        var x = confirm("Are you sure you want to delete this record?");
        if (x){
            var id = $(this).parent().parent().find('.id-att').text(); 
            var code = document.getElementById("code").value;
            var fname = document.getElementById("fname").value;
            $.ajax({
                url: "{{ URL::to('learner/attendance/delete') }}",
                type:"POST",
                beforeSend: function (xhr) {
                    var token = $('meta[name="csrf_token"]').attr('content');
                    if (token) {
                          return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                    }
                },
                data: { id : id, fname : fname, code : code},
                success:function(data){
                    $( "#attendance" ).empty();
                    $( "#attendance" ).append(data);
                },error:function(){ 
                    alert("Error: Please check your input.");
                }
            }); //end of ajax
        }
        else
            return false;
    });
    $(document).on("click",".story", function(){
        id = document.getElementById("code").value;
        fname = document.getElementById("fname").value;
        title = document.getElementById("sto-title").value;
        author = document.getElementById("sto-author").value;
        content = document.getElementById("sto-content").value;
        $.ajax({
            url: "{{ URL::to('learner/stories') }}",
            type:"POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: { code : id, txtTitle : title, fname : fname, txtAuthor : author, txtContent : content },
            success:function(data){
                $( "#stories" ).empty();
                $( "#stories" ).append(data);
            },error:function(){ 
                alert("Error: Please check your input.");
            }
        }); //end of ajax
    });
    $(document).on("click",".update-story", function(){
        id = document.getElementById("code").value;
        idStory = document.getElementById("mod-id").innerHTML;
        fname = document.getElementById("fname").value;
        title = document.getElementById("sto-title-edit").value;
        author = document.getElementById("sto-author-edit").value;
        content = document.getElementById("sto-content-edit").value;
        $.ajax({
            url: "{{ URL::to('learner/stories/update') }}",
            type:"POST",
            beforeSend: function (xhr) {
                var token = $('meta[name="csrf_token"]').attr('content');
                if (token) {
                      return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: { idStory : idStory, code : id, txtTitle : title, fname : fname, txtAuthor : author, txtContent : content },
            success:function(data){
                $( "#stories" ).empty();
                $( "#stories" ).append(data);
                $('#edit-story').closeModal();
            },error:function(){ 
                alert("Error: Please check your input.");
            }
        }); //end of ajax
    });
    $(document).on("click",".view-sto", function(){
        var title = $(this).parent().parent().find('.sto-title').text(); 
        var content = $(this).parent().parent().find('.sto-content').text(); 
        var author = $(this).parent().parent().find('.sto-author').text(); 
        var id = $(this).parent().parent().find('.id-story').text();
        document.getElementById('mod-title').innerHTML = title;
        document.getElementById('mod-author').innerHTML = author;
        document.getElementById('mod-content').innerHTML = content;
        document.getElementById('mod-id').innerHTML = id;
        $('#view-story').openModal();
    });
    $(document).on("click",".edit-sto", function(){
        $('#view-story').closeModal();
        title = document.getElementById("mod-title").innerHTML;
        author = document.getElementById("mod-author").innerHTML;
        content = document.getElementById("mod-content").innerHTML;
        document.getElementById('sto-title-edit').value = title;
        document.getElementById('sto-author-edit').value = author;
        document.getElementById('sto-content-edit').value = content;
        $('#edit-story').openModal();
    });
@stop   