<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SchoolDay AS SchoolDay;
use App\Attendance AS Attendance;
use DB;
use Validator;
use Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class schooldayController extends Controller
{
    public function index(Request $request, $id, $sesname){
        $result = DB::select('SELECT * FROM tblSchoolDay WHERE blSDDelete = ? AND intSDSesId = ? ORDER BY datSchoolDay DESC', [0,$id]);
        return view('schoolday.index', ['days' => $result, 'sesid' => $id,'sesname' => $sesname]);
    }
    public function create(Request $request){
        $rules = array(
            'datSchoolDate' => 'required'
        );
        $messages = [
            'required' => 'The :attribute field is required.'
        ];
        $niceNames = array(
            'datSchoolDate' => 'School Date'
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        try{
        	$SchoolDay = new SchoolDay();
	        $SchoolDay->datSchoolDay = $request->input('datSchoolDate');
	       	$SchoolDay->intSDSesId = $request->input('id');
	       	$SchoolDay->save();
	       	$request->session()->flash('message', 'Successfully Added.'); 
        }
		catch (\Illuminate\Database\QueryException $e){
			$errMess = $e->getMessage();
			return Redirect::back()->withErrors($errMess);
		}
        return Redirect::back();
    }
    public function delete(Request $request){
    	$id = $request->input('id');
    	$result = DB::select('DELETE FROM tblSchoolDay WHERE intSDId = ?', [$id]);
        //redirect
        return Redirect::back();
    }
    public function learner(Request $request){
        $sesid = $request->input('sesid');
        $sdid = $request->input('sdid');
        $date = $request->input('date');
        $result = DB::select('SELECT strLearCode, CONCAT(strLearFname," ", strLearLname) AS strLearName FROM tblLearner WHERE intLearSesId = ? AND blLearDelete = 0 AND strLearCode NOT IN (SELECT strAttLearCode FROM tblAttendance WHERE intAttSDId = ?)', [$sesid,$sdid]);
        return view('schoolday.learners', ['learners' => $result,'date'=>$date,'sdid'=>$sdid]);
    }
    public function addPresentLearners(Request $request){
        $learners = $request->input('learners');
        $sdid = $request->input('sdid');
        $counter = 0;   
        foreach ($learners as $learner) {  
            $one[$counter] = array('intAttSDId'=>$sdid, 'strAttLearCode'=>$learner);
            $counter++;
        }
        try{
            $Attendance = new Attendance();
            $Attendance->insert($one);
        }catch (\Illuminate\Database\QueryException $e){
            $errMess = $e->getMessage();
            return view('schoolday.index')->withErrors($errMess);
        }
    }
}
