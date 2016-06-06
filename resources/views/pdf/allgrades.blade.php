<!DOCTYPE html>
<html>
<head>
    <title>Grades</title>
    <style>
        table {
            border-collapse: collapse;
            border: 1px solid #000;
            padding: 1%;
        }
        table th, table td {
            border: 1px solid #000;

        }
    </style>
</head>
<body>
    <div style="margin-left: 4%">
    <h2> Grades Report</h2>
    @foreach($sessions as $session)
        Session Name: <b>{{$session->strSesName}}</b>
    @endforeach
    <br>
    @foreach($coles as $cole)
        Colearner: <b>{{$cole->Name}}</b>
    @endforeach
    <br>
    @foreach($programs as $program)
        Program: <b>{{$program->strProgName}}</b>
    @endforeach
    <br>
    @foreach($schools as $school)
        School: <b>{{$school->strSchName}}</b>
    @endforeach
    <br><br>
        Grade Level: <b>{{$level}}</b>
    <br>
        Quarter: <b>{{$quarter}}</b>
    <br><br>
    <table width="100%" id="list">
        <thead>
            <tr>
                <th data-field="schoo">Learner Name</th>
                <th>Level</th>
                <th>Quarter</th>
                <th data-field="coordinator">Filipino</th>
                <th data-field="coordinator">English</th>
                <th data-field="coordinator">Math</th>
                <th data-field="coordinator">Science</th>
                <th data-field="coordinator">Makabayan</th>
                <th>Average</th>
            </tr>
        </thead>
        <tbody>
        <?php 
            $intLearName = "none"; 
            $intLearLvl = "none";
        ?>
        @foreach($learners as $learner)
        <?php
            $dblAverage = ($learner->dblGrdFilipino + $learner->dblGrdEnglish + $learner->dblGrdMath + $learner->dblGrdScience + $learner->dblGrdMakabayan) / 5;
        ?>
            <tr>
                <?php 
                    if($intLearName != $learner->Name){
                        ?><td>&nbsp;{{$learner->Name}}</td><?php
                        $intLearName = $learner->Name;
                    } else{
                        ?><td>&nbsp;</td><?php  
                    } 
                    if($intLearLvl != $learner->intGrdLvl){
                        ?><td><center>{{round($learner->intGrdLvl)}}</center></td><?php
                        $intLearLvl = $learner->intGrdLvl;
                    } else{
                        ?><td>&nbsp;</td><?php  
                    }
                ?>
                <td><center>{{round($learner->intGrdQtr)}}</center></td>
                <td><center>{{round($learner->dblGrdFilipino)}}</center></td>
                <td><center>{{round($learner->dblGrdEnglish)}}</center></td>
                <td><center>{{round($learner->dblGrdMath)}}</center></td>
                <td><center>{{round($learner->dblGrdScience)}}</center></td>
                <td><center>{{round($learner->dblGrdMakabayan)}}</center></td>
                <td><center>{{round($dblAverage)}}%</center></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
</body>
</html>
    
