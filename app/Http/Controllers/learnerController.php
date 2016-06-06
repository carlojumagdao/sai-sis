<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Learner AS Learner;
use App\Grade AS Grade;
use App\Attendance AS Attendance;
use App\Story AS Story;
use DB;
use Storage;
use AWS;
use Validator;
use Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class learnerController extends Controller
{
    public function index(){
        if(session('admin')){
            $result = DB::select('SELECT l.strLearCode, CONCAT(l.strLearFname," ",l.strLearLname) AS Name, s.strSesName, p.strProgName,c.strSchName FROM tblLearner AS l LEFT JOIN tblSession AS s
                            ON l.intLearSesId = s.intSesId
                        LEFT JOIN tblProgram AS p
                            ON s.intSesProgId = p.intProgId
                        LEFT JOIN tblSchool AS c
                            ON c.intSchId = l.intLearSchId
                        WHERE l.blLearDelete = 0;');
        } else{
            $result = DB::select('SELECT l.strLearCode, CONCAT(l.strLearFname," ",l.strLearLname) AS Name, s.strSesName, p.strProgName,c.strSchName FROM tblLearner AS l LEFT JOIN tblSession AS s
                ON l.intLearSesId = s.intSesId
            LEFT JOIN tblProgram AS p
                ON s.intSesProgId = p.intProgId
            LEFT JOIN tblSchool AS c
                ON c.intSchId = l.intLearSchId
            LEFT JOIN tblLearningCenter AS x
                ON x.intLCId = c.intSchLCId
            WHERE l.blLearDelete = 0 AND x.intLCId = ?',[session('lc')]);
        }
        
        return view('learner.index', ['learners' => $result]);
    }
    public function newlearner(){
        $result = DB::select('SELECT strLearCode FROM tblLearner ORDER BY strLearCode');
        $ses_options = DB::table('tblSession')
            ->where('blSesDelete', 0)
            ->lists('strSesName', 'intSesId');
        $sch_options = DB::table('tblSchool')
        ->where('blSchDelete', 0)
        ->lists('strSchName', 'intSchId');
        $strLatestCode = "";
        foreach ($result as $value) {
            foreach ($value as $key ) {
                $strLatestCode = $key;
            }
        }
        $strNewCode = $this->smartcounter($strLatestCode);
        return view('learner.create', ['strNewCode' => $strNewCode, 'ses_options' => $ses_options, 'sch_options' => $sch_options]);
    }
    public function profile($id){
        $strGotCode = $id;
        $result = DB::select('SELECT * FROM tblLearner WHERE strLearCode = ?',[$strGotCode]);
        $grades = DB::select('SELECT AVG(dblGrdFilipino) as dblGrdFilipino,AVG(dblGrdMath) as dblGrdMath,AVG(dblGrdScience) as dblGrdScience,AVG(dblGrdEnglish) as dblGrdEnglish,AVG(dblGrdMakabayan) as dblGrdMakabayan, intGrdLvl, intGrdId FROM tblGrade WHERE strGrdLearCode = ? AND blGrdDelete = 0 GROUP BY intGrdLvl ORDER BY intGrdLvl',[$strGotCode]);
        $attendance = DB::select('SELECT MONTH(s.datSchoolDay) AS month, YEAR(s.datSchoolDay) AS year, DAY(s.datSchoolDay) as day, a.intAttId, s.datSchoolDay, a.blAttStatus FROM tblAttendance AS a LEFT JOIN tblSchoolDay AS s ON a.intAttSDId = s.intSDId WHERE blAttDelete = 0 AND strAttLearCode = ? ORDER BY s.datSchoolDay DESC',[$strGotCode]);
        $schDays = DB::select('SELECT MONTH(s.datSchoolDay) AS month, YEAR(s.datSchoolDay) AS year, DAY(s.datSchoolDay) as day, s.datSchoolDay, s.intSDId FROM tblLearner as l
            INNER JOIN tblSchoolDay as s ON l.intLearSesId = s.intSDSesId WHERE l.strLearCode = ? AND s.intSDId NOT IN (SELECT intAttSDId FROM tblAttendance WHERE strAttLearCode = ?) ORDER BY s.datSchoolDay DESC',[$strGotCode,$strGotCode]);
        $stories = DB::select('SELECT * FROM tblStory WHERE strStoLearCode = ?',[$strGotCode]);
        $procGrades = $this->ProcessGrades($grades);
        $ses_options = DB::table('tblSession')
            ->where('blSesDelete', 0)
            ->lists('strSesName', 'intSesId');
        $sch_options = DB::table('tblSchool')
        ->where('blSchDelete', 0)
        ->lists('strSchName', 'intSchId');
        $attPresent = DB::select('SELECT COUNT(*) AS present FROM tblAttendance WHERE strAttLearCode = ?',[$strGotCode]);
        $attAbsent = DB::select('SELECT COUNT(s.intSDId) AS absent FROM tblLearner as l
            INNER JOIN tblSchoolDay as s ON l.intLearSesId = s.intSDSesId WHERE l.strLearCode = ? AND s.intSDId NOT IN (SELECT intAttSDId FROM tblAttendance WHERE strAttLearCode = ?) ORDER BY s.datSchoolDay DESC',[$strGotCode,$strGotCode]);
        $donor = DB::select('SELECT d.strDonorName FROM tblDonor AS d 
                LEFT JOIN tblDonorLearner AS dl ON d.intDonorId = dl.intDLDonorId
                LEFT JOIN tblLearner AS l ON l.strLearCode = dl.strDLLearCode
            WHERE l.strLearCode = ?',[$strGotCode]);
        $donorName = "None";
        foreach ($donor as $value) {
            $donorName = $value->strDonorName;
        }
        return view('learner.profile',['absent' => $attAbsent,'present' => $attPresent,'infos' => $result, 'stories' => $stories,'schDays' => $schDays, 'days' => $attendance, 'grades' => $procGrades, 'ses_options' => $ses_options, 'sch_options' => $sch_options,'donorName' => $donorName]);
    }
    public function delete(Request $request, $id){

        $Donee = DB::select('SELECT intDLId FROM tblDonorLearner WHERE strDLLearCode = ?', [$id]);
        if($Donee){
            return Redirect::back()->withErrors("Cannot delete this record, because it is used by another record.");
        } else{   
            $Learner = Learner::find($id);
            $Learner->blLearDelete = '1';
            $Learner->save();
        }
        //redirect
        $request->session()->flash('message', 'Successfully deleted.');   
        return Redirect::back();
    }
    public function update(Request $request){
        $rules = array(
            'txtCode' => 'required',
            'txtFname' => 'required',
            'txtLname' => 'required',
            'datBdate' => 'required|before:today',
            'selSes' => 'required',
            'selSchool' => 'required',
            'rdGender' => 'required',
            'pic' => 'mimes:jpeg,jpg,png,bmp|max:10000',
            'txtVision' => 'required',
            'txtContact' => 'digits:11'
        );
        $messages = [
            'required' => 'The :attribute field is required.',
            'digits' => 'The :attribute field must be a 11 digit characters.'
        ];
        $niceNames = array(
            'txtCode' => 'Student Code',
            'txtFname' => 'First Name',
            'txtLname' => 'Last Name',
            'datBdate' => 'Birthdate',
            'selSes' => 'Session',
            'selSchool' => 'School',
            'rdGender' => 'Gender',
            'pic' => 'Image',
            'txtVision' => 'Vision',
            'txtContact' => 'Contact'
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        } else{
            if($request->file('pic') == null){
                try{
                    $Learner = Learner::find($request->input('txtCode'));
                    if($Learner){
                        $Learner->strLearCode = $request->input('txtCode');
                        $Learner->strLearFname = $request->input('txtFname');
                        $Learner->strLearLname = $request->input('txtLname');
                        $Learner->datLearBirthDate = $request->input('datBdate');
                        $Learner->blLearGender = $request->input('rdGender');
                        $Learner->strLearDream = $request->input('txtDream');
                        $Learner->strLearVision = $request->input('txtVision');
                        $Learner->strLearContact = $request->input('txtContact');
                        $Learner->intLearSesId = $request->input('selSes');
                        $Learner->intLearSchId = $request->input('selSchool');
                        $Learner->save();
                    }
                }catch (\Illuminate\Database\QueryException $e){
                    $errMess = $e->getMessage();
                    return Redirect::back()->withErrors($errMess);
                }
            }
            else if($request->file('pic')->isValid()) {
                $destinationPath = 'assets/images/uploads'; // upload path
                $extension = $request->file('pic')->getClientOriginalExtension(); // getting image extension
                $date = date("Ymdhis");
                $fileName = $date.'-'.rand(111111,999999).'.'.$extension; // renameing image
                $request->file('pic')->move($destinationPath, $fileName); // uploading file to given path
                $s3 = AWS::createClient('s3');
                $s3->putObject(array(
                    'Bucket'     => 'sai-sis-files',
                    'Key'        => 'learner/'.$fileName,
                    'SourceFile' => 'assets/images/uploads/'.$fileName,
                    'ACL'        => 'public-read'
                ));
                $file = $destinationPath.'/'.$fileName;
                unlink($file);
                try{
                    $Learner = Learner::find($request->input('txtCode'));
                    if($Learner){
                        $Learner->strLearCode = $request->input('txtCode');
                        $Learner->strLearFname = $request->input('txtFname');
                        $Learner->strLearLname = $request->input('txtLname');
                        $Learner->datLearBirthDate = $request->input('datBdate');
                        $Learner->blLearGender = $request->input('rdGender');
                        $Learner->strLearDream = $request->input('txtDream');
                        $Learner->strLearVision = $request->input('txtVision');
                        $Learner->strLearContact = $request->input('txtContact');
                        $Learner->strLearPicPath = $fileName;
                        $Learner->intLearSesId = $request->input('selSes');
                        $Learner->intLearSchId = $request->input('selSchool');
                        $Learner->save();
                    }
                    
                }catch (\Illuminate\Database\QueryException $e){
                    $errMess = $e->getMessage();
                    return Redirect::back()->withErrors($errMess);
                }
            } else{
                return Redirect::back()->withErrors("uploaded file is not valid");
            }
        }
        //redirect
        $request->session()->flash('message', 'Successfully updated.');    
        return Redirect::back();
    }
    public function create(Request $request){
        $rules = array(
            'txtCode' => 'required',
            'txtFname' => 'required',
            'txtLname' => 'required',
            'datBdate' => 'required|before:today',
            'selSes' => 'required',
            'selSchool' => 'required',
            'rdGender' => 'required',
            'pic' => 'required|mimes:jpeg,jpg,png,bmp|max:10000',
            'txtVision' => 'required',
            'txtContact' => 'digits:11'
        );
        $messages = [
            'required' => 'The :attribute field is required.',
            'digits' => 'The :attribute field must be a 11 digit characters.'
        ];
        $niceNames = array(
            'txtCode' => 'Student Code',
            'txtFname' => 'First Name',
            'txtLname' => 'Last Name',
            'datBdate' => 'Birthdate',
            'selSes' => 'Session',
            'selSchool' => 'School',
            'rdGender' => 'Gender',
            'pic' => 'Image',
            'txtVision' => 'Vision',
            'txtContact' => 'Contact'
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        } else{
            if ($request->file('pic')->isValid()) {
                $destinationPath = 'assets/images/uploads'; // upload path
                $extension = $request->file('pic')->getClientOriginalExtension(); // getting image extension
                $date = date("Ymdhis");
                $fileName = $date.'-'.rand(111111,999999).'.'.$extension; // renameing image
                $request->file('pic')->move($destinationPath, $fileName); // uploading 
                $s3 = AWS::createClient('s3');
                $s3->putObject(array(
                    'Bucket'     => 'sai-sis-files',
                    'Key'        => 'learner/'.$fileName,
                    'SourceFile' => 'assets/images/uploads/'.$fileName,
                    'ACL'        => 'public-read'
                ));
                $file = $destinationPath.'/'.$fileName;
                unlink($file);
                try{
                    $Learner = new Learner();
                    $Learner->strLearCode = $request->input('txtCode');
                    $Learner->strLearFname = $request->input('txtFname');
                    $Learner->strLearLname = $request->input('txtLname');
                    $Learner->datLearBirthDate = $request->input('datBdate');
                    $Learner->blLearGender = $request->input('rdGender');
                    $Learner->strLearPicPath = $fileName;
                    $Learner->strLearDream = $request->input('txtDream');
                    $Learner->strLearVision = $request->input('txtVision');
                    $Learner->strLearContact = $request->input('txtContact');
                    $Learner->intLearSesId = $request->input('selSes');
                    $Learner->intLearSchId = $request->input('selSchool');
                    $Learner->save();
                }catch (\Illuminate\Database\QueryException $e){
                    $errMess = $e->getMessage();
                    return Redirect::back()->withErrors($errMess);
                }
            } else{
                return Redirect::back()->withErrors("uploaded file is not valid");
            }
        }
        //redirect
        $request->session()->flash('message', 'Successfully added.');    
        return Redirect::back();
    }
    public function deleteGrade(Request $request){
        $intGrdId = $request->input('id');
        try{
            $result = DB::select('DELETE FROM tblGrade WHERE intGrdId = ?', [$intGrdId]);
        }catch (\Illuminate\Database\QueryException $e){
            $errMess = $e->getMessage();
            return view('learner.grade')->withErrors($errMess);
        }
        return 1;
    }
    public function deleteAttendance(Request $request){
        $intAttId = $request->input('id');
        $strGotCode = $request->input('code');
        $fname = $request->input('fname');
        try{
            $result = DB::select('DELETE FROM tblAttendance WHERE intAttId = ?', [$intAttId]);
        }catch (\Illuminate\Database\QueryException $e){
            $errMess = $e->getMessage();
            return view('learner.attendance')->withErrors($errMess);
        }
        $attendance = DB::select('SELECT a.intAttId, s.datSchoolDay, a.blAttStatus FROM tblAttendance AS a LEFT JOIN tblSchoolDay AS s ON a.intAttSDId = s.intSDId WHERE blAttDelete = 0 AND strAttLearCode = ? ORDER BY s.datSchoolDay DESC',[$strGotCode]);
        $schDays = DB::select('SELECT s.datSchoolDay, s.intSDId FROM tblLearner as l
            INNER JOIN tblSchoolDay as s ON l.intLearSesId = s.intSDSesId WHERE l.strLearCode = ? AND s.intSDId NOT IN (SELECT intAttSDId FROM tblAttendance WHERE strAttLearCode = ?) ORDER BY s.datSchoolDay DESC',[$strGotCode,$strGotCode]);
        return view('learner.attendance',['days' => $attendance,'schDays'=>$schDays,'fname'=>$fname]);
    }
    public function addGrade(Request $request){
        $rules = array(
            'txtLevel' => 'required|integer|between:1,13',
            'txtQuarter' => 'required|integer|between:1,4',
            'txtFilipino' => 'required|integer|between:70,99',
            'txtEnglish' => 'integer|between:70,99',
            'txtScience' => 'integer|between:70,99',
            'txtMath' => 'integer|between:70,99',
            'txtMakabayan' => 'integer|between:70,99',
        );
        $messages = [
            'digits' => 'The :attribute field must be between 70 and 99',
        ];
        $niceNames = array(
            'txtLevel' => 'Grade Level',
            'txtQuarter' => 'Quarter',
            'txtFilipino' => 'Filipino',
            'txtEnglish' => 'English',
            'txtScience' => 'Science',
            'txtMath' => 'Math',
            'txtMakabayan' => 'Makabayan',
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return view('learner.grade')->withErrors($validator);
        }
        try{
            $Grade = new Grade();
            $Grade->intGrdQtr = $request->input('txtQuarter');
            $Grade->intGrdLvl = $request->input('txtLevel');
            $Grade->strGrdLearCode = $request->input('code');
            $Grade->dblGrdFilipino = $request->input('txtFilipino');
            $Grade->dblGrdEnglish = $request->input('txtEnglish');
            $Grade->dblGrdMakabayan = $request->input('txtMakabayan');
            $Grade->dblGrdScience = $request->input('txtScience');
            $Grade->dblGrdMath = $request->input('txtMath');
            $Grade->save();
        }catch (\Illuminate\Database\QueryException $e){
            $errMess = $e->getMessage();
            return view('learner.grade')->withErrors($errMess);
        }
        //redirect
        $strGotCode = $request->input('code');
        $fname = $request->input('fname');
        $grades = DB::select('SELECT AVG(dblGrdFilipino) as dblGrdFilipino,AVG(dblGrdMath) as dblGrdMath,AVG(dblGrdScience) as dblGrdScience,AVG(dblGrdEnglish) as dblGrdEnglish,AVG(dblGrdMakabayan) as dblGrdMakabayan, intGrdLvl, intGrdId FROM tblGrade WHERE strGrdLearCode = ? AND blGrdDelete = 0 GROUP BY intGrdLvl ORDER BY intGrdLvl',[$strGotCode]);
        $procGrades = $this->ProcessGrades($grades);
        return view('learner.grade',['grades' => $procGrades, 'fname' => $fname, 'code' => $strGotCode]);
    }
    public function addStory(Request $request){
        $rules = array(
            'txtTitle' => 'required',
            'txtContent' => 'required',
            'txtAuthor' => 'required',
        );
        $messages = [
            'required' => 'The :attribute field is required',
        ];
        $niceNames = array(
            'txtTitle' => 'Title',
            'txtContent' => 'Content',
            'txtAuthor' => 'Author',
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return view('learner.story')->withErrors($validator);
        }
        try{
            $Story = new Story();
            $Story->strStoTitle = $request->input('txtTitle');
            $Story->strStoLearCode = $request->input('code');
            $Story->strStoContent = $request->input('txtContent');
            $Story->strStoAuthor = $request->input('txtAuthor');
            $Story->save();
        }catch (\Illuminate\Database\QueryException $e){
            $errMess = $e->getMessage();
            return view('learner.story')->withErrors($errMess);
        }
        //redirect
        $strGotCode = $request->input('code');
        $fname = $request->input('fname');
        $stories = DB::select('SELECT * FROM tblStory WHERE strStoLearCode = ?',[$strGotCode]);
        return view('learner.story',['stories' => $stories, 'fname' => $fname, 'code' => $strGotCode]);
    }
    public function deleteStory(Request $request){
        $intStoId = $request->input('id');
        $strGotCode = $request->input('code');
        $fname = $request->input('fname');
        try{
            $result = DB::select('DELETE FROM tblStory WHERE intStoId = ?', [$intStoId]);
        }catch (\Illuminate\Database\QueryException $e){
            $errMess = $e->getMessage();
            return view('learner.story')->withErrors($errMess);
        }
        $stories = DB::select('SELECT * FROM tblStory WHERE strStoLearCode = ?',[$strGotCode]);
        return view('learner.story',['stories' => $stories, 'fname' => $fname, 'code' => $strGotCode]);
    }
    public function updateStory(Request $request){
        $rules = array(
            'txtTitle' => 'required',
            'txtContent' => 'required',
            'txtAuthor' => 'required',
        );
        $messages = [
            'required' => 'The :attribute field is required',
        ];
        $niceNames = array(
            'txtTitle' => 'Title',
            'txtContent' => 'Content',
            'txtAuthor' => 'Author',
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return view('learner.story')->withErrors($validator);
        }
        try{
            $Story = Story::find($request->input('idStory'));
            if($Story){
                $Story->strStoTitle = $request->input('txtTitle');
                $Story->strStoLearCode = $request->input('code');
                $Story->strStoContent = $request->input('txtContent');
                $Story->strStoAuthor = $request->input('txtAuthor');
                $Story->save();
            }
        }catch (\Illuminate\Database\QueryException $e){
            $errMess = $e->getMessage();
            return view('learner.story')->withErrors($errMess);
        }
        //redirect
        $strGotCode = $request->input('code');
        $fname = $request->input('fname');
        $stories = DB::select('SELECT * FROM tblStory WHERE strStoLearCode = ?',[$strGotCode]);
        return view('learner.story',['stories' => $stories, 'fname' => $fname, 'code' => $strGotCode]);
    }
    public function addAttendance(Request $request){
        $rules = array(
            'attendance' => 'required',
        );
        $messages = [
            'required' => 'The :attribute field is required.'
        ];
        $niceNames = array(
            'attendance' => 'Grade Level',
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return view('learner.attendance')->withErrors($validator);
        }
        $presents = $request->input('attendance');
        $counter = 0;
        foreach ($presents as $present) {  
            $one[$counter] = array('strAttLearCode'=>$request->input('code'), 'intAttSDId'=>$present);
            $counter++;
        }
        try{
            $Attendance = new Attendance();
            $Attendance->insert($one);

        }catch (\Illuminate\Database\QueryException $e){
            $errMess = $e->getMessage();
            return view('learner.attendance')->withErrors($errMess);
        }
        $strGotCode = $request->input('code');
        $fname = $request->input('fname');
        $attendance = DB::select('SELECT a.intAttId, s.datSchoolDay, a.blAttStatus FROM tblAttendance AS a LEFT JOIN tblSchoolDay AS s ON a.intAttSDId = s.intSDId WHERE blAttDelete = 0 AND strAttLearCode = ? ORDER BY s.datSchoolDay DESC',[$strGotCode]);
        $schDays = DB::select('SELECT s.datSchoolDay, s.intSDId FROM tblLearner as l
            INNER JOIN tblSchoolDay as s ON l.intLearSesId = s.intSDSesId WHERE l.strLearCode = ? AND s.intSDId NOT IN (SELECT intAttSDId FROM tblAttendance WHERE strAttLearCode = ?) ORDER BY s.datSchoolDay DESC',[$strGotCode,$strGotCode]);
        return view('learner.attendance',['days' => $attendance,'schDays'=>$schDays,'fname'=>$fname]);
    }
    public function ViewGrades($intGrdLvl, $strLearCode){
        $result = DB::select('SELECT * FROM tblGrade WHERE strGrdLearCode = ? AND intGrdLvl = ? ORDER BY intGrdQtr',[$strLearCode,$intGrdLvl]);
        return view('learner.gradebreakdown',['grades' => $result,'intGrdLvl'=>$intGrdLvl,'strLearCode'=>$strLearCode]);
    }
    public function updateGrades(Request $request){
        $rules = array(
            'txtFilipino' => 'required|integer|between:70,99',
            'txtEnglish' => 'integer|between:70,99',
            'txtScience' => 'integer|between:70,99',
            'txtMath' => 'integer|between:70,99',
            'txtMakabayan' => 'integer|between:70,99',
        );
        $messages = [
            'digits' => 'The :attribute field must be between 70 and 99',
        ];
        $niceNames = array(
            'txtFilipino' => 'Filipino',
            'txtEnglish' => 'English',
            'txtScience' => 'Science',
            'txtMath' => 'Math',
            'txtMakabayan' => 'Makabayan',
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return view('learner.grade')->withErrors($validator);
        }
        try{
            $Grade = Grade::find($request->input('gradeId'));
            if($Grade){
                $Grade->dblGrdFilipino = $request->input('txtFilipino');
                $Grade->dblGrdEnglish = $request->input('txtEnglish');
                $Grade->dblGrdMakabayan = $request->input('txtMakabayan');
                $Grade->dblGrdScience = $request->input('txtScience');
                $Grade->dblGrdMath = $request->input('txtMath');
                $Grade->save();
                $request->session()->flash('message', 'Successfully updated.'); 
            }
        }catch (\Illuminate\Database\QueryException $e){
            $errMess = $e->getMessage();
        }
        return 1;
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
    function smartcounter($strLatestCode){
        if(empty($strLatestCode) || $strLatestCode == " "){
            return "CODE001";
        }
        $chNumValue = str_split($strLatestCode);
        $intStrLength = strlen($strLatestCode);
        $blnProof = 0;

        try {
            for($intCounter = $intStrLength-1; $intCounter > -1; $intCounter--){
                if(is_numeric($chNumValue[$intCounter]) && $chNumValue[$intCounter] != '9'){
                    $chNumValue[$intCounter]++;
                    $blnProof = 1;
                    break;
                } elseif (is_numeric($chNumValue[$intCounter])) {
                    $chNumValue[$intCounter] = '0';
                } elseif (!(is_numeric($chNumValue[$intCounter])) && $blnProof == 1) {
                    break;
            }
        }
        $strNewCode = implode("", $chNumValue); 
        } catch (Exception $e) {
            echo "ERROR:". $e.getMessage();
        }
        if($strLatestCode == $strNewCode){
            $strNewCode = $strNewCode."0";
        }
        return $strNewCode;
    } 
}
