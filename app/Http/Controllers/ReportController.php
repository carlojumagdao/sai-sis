<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Validator;
use PDF;
use Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function attendance(){
    	$ses_options = DB::table('tblSession')
            ->where('blSesDelete', 0)
            ->lists('strSesName', 'intSesId');
    	return view('report.attendance',['ses_options' => $ses_options] );
    }
    public function grades(){
    	$ses_options = DB::table('tblSession')
            ->where('blSesDelete', 0)
            ->lists('strSesName', 'intSesId');
    	return view('report.grades',['ses_options' => $ses_options] );
    }
    public function grdGenerate(Request $request){
    	$intSesId = $request->input('selSession');
    	$intQuarter = $request->input('selQuarter');
    	$intLevel = $request->input('txtLevel');

    	$rules = array(
            'txtLevel' => 'required|integer|between:1,12',
            'selQuarter' => 'required',
            'selSession' => 'required'
        );
        $messages = [
            'required' => 'The :attribute field is required.',
            'digits' => 'The :attribute field must be between 1 and 12',
        ];
        $niceNames = array(
            'txtLevel' => 'Level',
            'selQuarter' => 'Quarter',
            'selSession' => 'Session'
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        $sessions = DB::select('SELECT strSesName FROM tblSession WHERE intSesId = ?',[$intSesId]);	
        $schools = DB::select('SELECT sc.strSchName FROM tblSchool AS sc LEFT JOIN tblSession AS s ON s.intSesSchId = sc.intSchId WHERE s.intSesId = ?',[$intSesId]);
        $programs = DB::select('SELECT p.strProgName FROM tblProgram AS P LEFT JOIN tblSession AS s ON p.intProgId = s.intSesProgId WHERE s.intSesId = ?',[$intSesId]);
        $coles = DB::select('SELECT CONCAT(c.strColeFname," ",c.strColeLname) AS Name FROM tblColearner AS c LEFT JOIN tblSession AS s ON s.intSesColeId = c.intColeId WHERE s.intSesId = ? ',[$intSesId]);
        if($intQuarter == 5){
        	$learners = DB::select('SELECT CONCAT(l.strLearFname," ", l.strLearLname) as Name, 	 AVG(g.dblGrdFilipino) 	 as dblGrdFilipino,
					    AVG(g.dblGrdMath) 		as dblGrdMath,
			            AVG(g.dblGrdScience) 	as dblGrdScience,
			            AVG(g.dblGrdEnglish) 	as dblGrdEnglish,
			            AVG(g.dblGrdMakabayan) 	as dblGrdMakabayan
				FROM tblGrade AS g
						LEFT JOIN tblLearner AS l ON l.strLearCode = g.strGrdLearCode
			        	LEFT JOIN tblSession AS s ON s.intSesId = l.intLearSesId
			        	WHERE g.intGrdLvl = ? AND s.intSesId = ?
			        	GROUP BY l.strLearFname;',[$intLevel,$intSesId]);
        	$intQuarter = "All";	
        } else{
        	$learners = DB::select('SELECT CONCAT(l.strLearFname," ", l.strLearLname) as Name, 	 AVG(g.dblGrdFilipino) 	 as dblGrdFilipino,
					    AVG(g.dblGrdMath) 		as dblGrdMath,
			            AVG(g.dblGrdScience) 	as dblGrdScience,
			            AVG(g.dblGrdEnglish) 	as dblGrdEnglish,
			            AVG(g.dblGrdMakabayan) 	as dblGrdMakabayan
				FROM tblGrade AS g
						LEFT JOIN tblLearner AS l ON l.strLearCode = g.strGrdLearCode
			        	LEFT JOIN tblSession AS s ON s.intSesId = l.intLearSesId
			        	WHERE g.intGrdLvl = ? AND s.intSesId = ? AND g.intGrdQtr = ?
			        	GROUP BY l.strLearFname;',[$intLevel,$intSesId,$intQuarter]);
        }
        $pdf = PDF::loadView('pdf.grades', ['learners' => $learners,'coles'=>$coles,'sessions'=>$sessions,'schools'=>$schools,'programs'=>$programs,'quarter'=>$intQuarter,'level'=>$intLevel]);
        return $pdf->stream();
    }
    public function attGenerate(Request $request){
    	$intSesId = $request->input('selSession');
    	$datFrom = $request->input('datFrom');
    	$datTo = $request->input('datTo');

    	$rules = array(
            'datFrom' => 'required|date|before:today',
            'datTo' => 'required|date|after:datFrom',
            'selSession' => 'required'
        );
        $messages = [
            'required' => 'The :attribute field is required.',
        ];
        $niceNames = array(
            'datFrom' => 'From',
            'datTo' => 'To',
            'selSession' => 'Session'
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        $sessions = DB::select('SELECT strSesName FROM tblSession WHERE intSesId = ?',[$intSesId]);	
        $schools = DB::select('SELECT sc.strSchName FROM tblSchool AS sc LEFT JOIN tblSession AS s ON s.intSesSchId = sc.intSchId WHERE s.intSesId = ?',[$intSesId]);
        $programs = DB::select('SELECT p.strProgName FROM tblProgram AS P LEFT JOIN tblSession AS s ON p.intProgId = s.intSesProgId WHERE s.intSesId = ?',[$intSesId]);
        $schDays = DB::select('SELECT COUNT(intSDSesId) AS days FROM tblSchoolDay WHERE intSDSesId = ? AND (datSchoolDay BETWEEN ? AND ?)',[$intSesId,$datFrom,$datTo]);
        $coles = DB::select('SELECT CONCAT(c.strColeFname," ",c.strColeLname) AS Name FROM tblColearner AS c LEFT JOIN tblSession AS s ON s.intSesColeId = c.intColeId WHERE s.intSesId = ? ',[$intSesId]);
    	$learners = DB::select('SELECT CONCAT(l.strLearFname," ", l.strLearLname) as Name, COUNT(a.intAttId) AS Attendance FROM tblLearner AS l
		LEFT JOIN tblSession AS s ON l.intLearSesId = s.intSesId
        LEFT JOIN tblAttendance AS a ON l.strLearCode = a.strAttLearCode
        LEFT JOIN tblSchoolDay AS sd ON sd.intSDId = a.intAttSDId
	WHERE s.intSesId = ? AND l.blLearDelete = 0 AND (sd.datSchoolDay BETWEEN ? AND ?)
    GROUP BY l.strLearFname
    ORDER BY l.strLearFname',[$intSesId,$datFrom,$datTo]);
            
        $pdf = PDF::loadView('pdf.attendance', ['learners' => $learners,'schDays'=>$schDays,'coles'=>$coles,'sessions'=>$sessions,'schools'=>$schools,'from'=>$datFrom,'to'=>$datTo,'programs'=>$programs]);
        return $pdf->stream();

    }
}
