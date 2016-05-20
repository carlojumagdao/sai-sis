<?php
    $From = date('F j, Y', strtotime($from));
    $To = date('F j, Y', strtotime($to));
?>
<!DOCTYPE html>
<html>
<head>
    <title>Attendance</title>
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
    <img src="assets/images/sailogo-black.png" alt="SAI Logo" width="150">
    <br>
    <br>
    <div style="margin-left: 4%">
    <h2> Attendance Report</h2>
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
    <br>
    <br>
    Date Range
    <br>
    From: <b>{{$From}}</b>
    <br>
    To: <b>{{$To}}</b>
    <br>
    @foreach($schDays as $schDay)
        No. School Days: <b>{{$schDay->days}}</b>
        <?php $schDays = $schDay->days ?>
    @endforeach
    <br><br>
    <table width="100%" id="list">
        <thead>
            <tr>
                <th data-field="id">#</th>
                <th data-field="schoo">Learner Name</th>
                <th data-field="coordinator">No. of present days</th>
                <th>Percentage</th>
            </tr>
        </thead>
        <tbody>
        <?php $intCounter = 1 ?>
        @foreach($learners as $learner)
        <?php
            $value = ($learner->Attendance / $schDays) * 100;
            $value = round($value);
        ?>
            <tr>
                <td>&nbsp;{{$intCounter}}</td>
                <td>&nbsp;{{$learner->Name}}</td>
                <td><center>{{$learner->Attendance}}</center></td>
                <td><center>{{$value}}%</center></td>
            </tr>
            <?php $intCounter++ ?>
        @endforeach
        </tbody>
    </table>
    </div>
</body>
</html>
    
