<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use stdClass;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class dashboardController extends Controller
{
    public function index(){
        // for the birthday section
        $bdayLear = DB::select('SELECT COUNT(strLearCode) as bdayLear FROM tblLearner WHERE MONTH(datLearBirthDate) = MONTH(NOW()) AND DAY(datLearBirthDate) = DAY(DATE_ADD(NOW(), INTERVAL 8 HOUR)) AND blLearDelete = 0');
        $bdayCole = DB::select('SELECT COUNT(intColeId) as bdayCole FROM tblColearner WHERE MONTH(datColeBirthDate) = MONTH(NOW()) AND DAY(datColeBirthDate) = DAY(DATE_ADD(NOW(), INTERVAL 8 HOUR)) AND blColeDelete = 0');
        $bdayDonor = DB::select('SELECT COUNT(intDonorId) as bdayDonor FROM tblDonor WHERE MONTH(datDonorBDate) = MONTH(NOW()) AND DAY(datDonorBDate) = DAY(DATE_ADD(NOW(), INTERVAL 8 HOUR)) AND blDonorDelete = 0');
        foreach ($bdayLear as $value) {
            $countBdayLear = $value->bdayLear;
        }
        foreach ($bdayCole as $value) {
            $countBdayCole = $value->bdayCole;
        }
        foreach ($bdayDonor as $value) {
            $countBdayDonor = $value->bdayDonor;
        }
        $bdays = 0;
        $bdays = $countBdayLear + $countBdayCole + $countBdayDonor;
        session(['bdays' => $bdays]);
        // for the birthday section
        $learners = DB::select('SELECT COUNT(strLearCode) AS learners FROM tblLearner WHERE blLearDelete = 0');
        foreach ($learners as $value) {
            $intLearners = $value->learners;
        }
        $donors = DB::select('SELECT COUNT(intDonorId) AS donors, SUM(dblDonorAmount) AS amount FROM tblDonor WHERE blDonorDelete = 0');
        if($donors){
           foreach ($donors as $value) {
                $intDonors = $value->donors;
                $dblAmount = $value->amount;
            } 
        } else{
            $intDonors = 0;
            $dblAmount = 0;
        }
        
        $grades = DB::select('SELECT (AVG(dblGrdEnglish) + AVG(dblGrdFilipino) + AVG(dblGrdMakabayan) + AVG(dblGrdMath) + AVG(dblGrdScience)) / 5 AS dblGrade FROM tblGrade WHERE blGrdDelete = 0 GROUP BY intGrdLvl;');
        $dblAverage = 0;
        foreach ($grades as $value) {
            $dblAverage = $value->dblGrade;
        }
        $sespresents = DB::select('SELECT count(a.intAttId) as content, s.strSesName as session FROM tblSession as s
                LEFT JOIN tblSchoolDay as sd ON sd.intSDSesId = s.intSesId
                LEFT JOIN tblAttendance as a ON sd.intSDId = a.intAttSDId
            WHERE s.blSesDelete = 0 GROUP BY s.strSesName ORDER BY s.strSesName');
        $sesdays = DB::select('SELECT count(sd.intSDId) as content, s.strSesName as session FROM tblSession as s
                    LEFT JOIN tblSchoolDay as sd ON s.intSesId = sd.intSDSesId
                WHERE s.blSesDelete = 0 GROUP BY s.strSesName ORDER BY s.strSesName');      
        $sesgrades = DB::select('SELECT (AVG(g.dblGrdEnglish) + AVG(g.dblGrdFilipino) + AVG(g.dblGrdMakabayan) + AVG(g.dblGrdMath) + AVG(g.dblGrdScience)) / 5 
            AS content, s.strSesName AS session FROM tblSession AS s 
            LEFT JOIN tblLearner as l ON s.intSesId = l.intLearSesId 
            LEFT JOIN tblGrade AS g ON l.strLearCode = g.strGrdLearCode WHERE s.blSesDelete = 0 GROUP BY s.strSesName ');
        $seslearners = DB::select('SELECT count(l.strLearCode) AS content, s.strSesName AS session FROM tblSession as s
                LEFT JOIN tblLearner as l ON s.intSesId = l.intLearSesId
            WHERE s.blSesDelete = 0 GROUP BY s.strSesName  ORDER BY s.strSesName ');

        $loclears = DB::select('SELECT count(l.strLearCode) AS content, lc.strLCLocation AS location FROM tblLearningCenter as lc
                LEFT JOIN tblSchool AS s ON lc.intLCId = s.intSchLCId
                LEFT JOIN tblLearner as l ON s.intSchId = l.intLearSchId
            WHERE lc.blLCDelete = 0 AND l.blLearDelete = 0 GROUP BY lc.strLCLocation  ORDER BY lc.strLCLocation');
        $proglears = DB::select('SELECT count(l.strLearCode) AS content, p.strProgName AS program FROM tblProgram as p
                LEFT JOIN tblSession AS s ON p.intProgId = s.intSesProgId
                LEFT JOIN tblLearner as l ON s.intSesId = l.intLearSesId
            WHERE p.blProgDelete = 0 GROUP BY p.strProgName  ORDER BY p.strProgName');

        for($intCounter = 0; $intCounter < sizeOf($seslearners); $intCounter++){
            if($sespresents[$intCounter]->content == 0 || $seslearners[$intCounter]->content == 0 || $sesdays[$intCounter]->content == 0){
                $sespresents[$intCounter]->attendance = 0;
            } else{
                $value = $sespresents[$intCounter]->content / $seslearners[$intCounter]->content;
                $finalValue = ($value / $sesdays[$intCounter]->content ) * 100;
                $sespresents[$intCounter]->attendance = $finalValue;
            }
            
        }
        return view('pages.dashboard',['intLearners' => $intLearners,'intDonors'=>$intDonors,'dblAmount'=>$dblAmount,'dblAverage'=>round($dblAverage),'sesgrades'=>$sesgrades,'seslearners'=>$seslearners,'sesattendance'=>$sespresents,'loclears'=>$loclears,'proglears'=>$proglears]);
    }
}
