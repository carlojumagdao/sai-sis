<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class doneeController extends Controller
{
    protected $strSubjName;

    public function index($code){
        $infos = DB::select('SELECT strLearCode, strLearPicPath, strLearDream, CONCAT(strLearFname," ",strLearLname) AS Name, strLearVision as Vision FROM tblLearner WHERE blLearDelete = 0 AND md5(strLearCode) = ?;',[$code]);
        if(!$infos){
            return redirect()->guest('notfound');
        }
        $countStories = DB::select('SELECT COUNT(intStoId) AS total FROM tblStory WHERE md5(strStoLearCode) = ?',[$code]);
        $attPresent = DB::select('SELECT COUNT(*) AS present FROM tblAttendance WHERE md5(strAttLearCode) = ?',[$code]);
        $attAbsent = DB::select('SELECT COUNT(s.intSDId) AS absent FROM tblLearner as l
            INNER JOIN tblSchoolDay as s ON l.intLearSesId = s.intSDSesId WHERE md5(l.strLearCode) = ? AND s.intSDId NOT IN (SELECT intAttSDId FROM tblAttendance WHERE md5(strAttLearCode) = ?) ORDER BY s.datSchoolDay DESC',[$code,$code]);
        foreach ($attPresent as $value) {
            $present = $value->present;
        }
        foreach ($attAbsent as $value) {
            $absent = $value->absent;
        }
        $intAttTotal = $absent + $present;
        if($intAttTotal == 0){
            $dblAttAverage = 0;
        } else{
            $dblAttAverage = ($present / $intAttTotal) * 100;
        }
        

        $grades = DB::select('SELECT AVG(dblGrdFilipino) as dblGrdFilipino,AVG(dblGrdMath) as dblGrdMath,AVG(dblGrdScience) as dblGrdScience,AVG(dblGrdEnglish) as dblGrdEnglish,AVG(dblGrdMakabayan) as dblGrdMakabayan, intGrdLvl, intGrdId FROM tblGrade WHERE md5(strGrdLearCode) = ? AND blGrdDelete = 0 GROUP BY intGrdLvl ORDER BY intGrdLvl',[$code]);
        
        $subject = DB::select('SELECT AVG(dblGrdFilipino) as filipino, AVG(dblGrdEnglish) as english, AVG(dblGrdMath) as math, AVG(dblGrdScience) as science, AVG(dblGrdMakabayan) as makabayan FROM tblGrade WHERE md5(strGrdLearCode) = ? AND blGrdDelete = 0 ORDER BY intGrdLvl',[$code]);

        $ProcGrades = $this->ProcessGrades($grades);
        $dblGradeAverage = $this->getGradeAverage($ProcGrades);
        $strHighestGrade = $this->getHighestSubjGrade($subject);
        $highestSubj = DB::select("SELECT $strHighestGrade,intGrdLvl FROM tblGrade WHERE md5(strGrdLearCode) = ? AND blGrdDelete = 0 GROUP BY intGrdLvl ORDER BY intGrdLvl",[$code]);
        $stories = DB::select('SELECT * FROM tblStory WHERE md5(strStoLearCode) = ?',[$code]);

        return view('donee.index', ['present'=>$present,'absent'=>$absent,'subjectName'=>$this->strSubjName,'subject' => $strHighestGrade,'highSubj' => $highestSubj,'grades' => $ProcGrades, 'stories' => $stories,'infos' => $infos,'countStories' => $countStories,'dblAttAverage' => round($dblAttAverage), 'dblGradeAverage' => $dblGradeAverage] );
    }

    function getHighestSubjGrade($subjGrades){
        $dblHighestGrade = 0;
        foreach ($subjGrades as $value) {
            $dblHighestGrade = max($value->filipino,$value->math,$value->english,$value->science,$value->makabayan);
            if($dblHighestGrade == $value->filipino){
                $this->strSubjName = "Filipino";
                $strHighSubj = "dblGrdFilipino";
            } else if($dblHighestGrade == $value->math){
                $this->strSubjName = "Math";
                $strHighSubj = "dblGrdMath";
            } else if($dblHighestGrade == $value->science){
                $this->strSubjName = "Science";
                $strHighSubj = "dblGrdScience";
            } else if($dblHighestGrade == $value->english){
                $this->strSubjName = "English";
                $strHighSubj = "dblGrdEnglish";
            } else{
                $this->strSubjName = "Makabayan";
                $strHighSubj = "dblGrdMakabayan";
            }
        }
        return $strHighSubj;
    }

    function getGradeAverage($ProcGrades){
        $dblAverage = 0;
        $intTotalCounter = 0;
        foreach ($ProcGrades as $grade) {
            $dblAverage += $grade->Average;
            $intTotalCounter++;
        }
        if($intTotalCounter == 0){
            $dblGradeAverage = 0;
        }else{
            $dblGradeAverage = $dblAverage / $intTotalCounter;
        }
        return round($dblGradeAverage);
    }

    function ProcessGrades($grades){
        foreach ($grades as $grade) {
            $intCounter = 5;
            if($grade->dblGrdFilipino == 0){
                $grade->dblGrdFilipino = '00';
                $intCounter--;
            }
            if($grade->dblGrdEnglish == 0){
                $grade->dblGrdEnglish = '00';
                $intCounter--;
            }
            if($grade->dblGrdMath == 0){
                $grade->dblGrdMath = '00';
                $intCounter--;
            }
            if($grade->dblGrdScience == 0){
                $grade->dblGrdScience = '00';
                $intCounter--;
            }
            if($grade->dblGrdMakabayan == 0){
                $grade->dblGrdMakabayan = '00';
                $intCounter--;
            }
            $grade->Average = ($grade->dblGrdMakabayan+$grade->dblGrdScience+$grade->dblGrdMath+$grade->dblGrdEnglish+$grade->dblGrdFilipino) / $intCounter;
        }
        return $grades;
    }
}
