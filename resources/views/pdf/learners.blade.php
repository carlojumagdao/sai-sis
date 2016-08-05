<!DOCTYPE html>
<html>
<head>
    <title>List of learners</title>
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
    <br>
    <br>
    <div style="margin-left: 4%">
    <h2> List of learners Report</h2>
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
    <br><br>
    <table width="100%" id="list">
        <thead>
            <tr>
                <th data-field="id">#</th>
                <th data-field="schoo">Learner Name</th>
            </tr>
        </thead>
        <tbody>
        <?php $intCounter = 1 ?>
        @foreach($learners as $learner)
            <tr>
                <td>&nbsp;{{$intCounter}}</td>
                <td>&nbsp;{{$learner->Name}}</td>
            </tr>
            <?php $intCounter++ ?>
        @endforeach
        </tbody>
    </table>
    </div>
</body>
</html>
    
