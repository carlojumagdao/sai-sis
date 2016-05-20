<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Session AS Session;
use DB;
use Validator;
use Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class sessionController extends Controller
{
     public function index(){
        $result = DB::select('SELECT s.intSesId, s.strSesName, c.strColeFname, c.strColeLname,sc.strSchName, p.strProgName FROM tblSession AS s 
        	LEFT JOIN tblColearner AS c 
        		ON s.intSesColeId = c. intColeId 
            LEFT JOIN tblSchool AS sc
                ON sc.intSchId = s.intSesSchId
        	LEFT JOIN tblProgram AS p 
        		ON s.intSesProgId = p.intProgId 
        	WHERE s.blSesDelete = ?', [0]);
        $cole_options = DB::table('tblColearner')
            ->where('blColeDelete', 0)
            ->lists(DB::raw('concat(strColeFname," ",strColeLname) AS Name'), 'intColeId');
        $program_options = DB::table('tblProgram')
        ->where('blProgDelete', 0)
        ->lists('strProgName', 'intProgId');
        $school_options = DB::table('tblSchool')
        ->where('blSchDelete', 0)
        ->lists('strSchName', 'intSchId');
        return view('session.index', ['sessions' => $result, 'cole_options' => $cole_options, 'program_options' => $program_options,'school_options'=>$school_options]);
    }
    public function create(Request $request){
        $rules = array(
            'txtSession' => 'required',
            'selCole' => 'required',
            'selProgram' => 'required',
            'selSchool' => 'required'
        );
        $messages = [
            'required' => 'The :attribute field is required.'
        ];
        $niceNames = array(
            'txtSession' => 'Session',
            'selCole' => 'Colearner',
            'selProgram' => 'Program',
            'selSchool' => 'School'
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        try{
            $Session = new Session();
            $Session->strSesName = $request->input('txtSession');
            $Session->intSesColeId = $request->input('selCole');
            $Session->intSesProgId = $request->input('selProgram');
            $Session->intSesSchId = $request->input('selSchool');
            $Session->save();
        }catch (\Illuminate\Database\QueryException $e){
            $errMess = $e->getMessage();
            return Redirect::back()->withErrors($errMess);
        }
        //redirect
        $request->session()->flash('message', 'Successfully added.');    
        return Redirect::back();
    }
    public function delete(){
        $id = $_POST['id'];

        $Learner = DB::select('SELECT strLearCode FROM tblLearner WHERE intLearSesId = ? AND blLearDelete = 0', [$id]);
        if($Learner){
            return Redirect::back()->withErrors("Cannot delete this record, because it is used by another record.");
        } else{
            try{
                $Session = Session::find($id);
                $Session->blSesDelete = '1';
                $Session->save();
            }catch (\Illuminate\Database\QueryException $e){
                $errMess = $e->getMessage();
                return Redirect::back()->withErrors($errMess);
            }
        }
        //redirect
        return Redirect::back();
    }
    public function edit(Request $request, $id){
        // //store
        $result = DB::select('SELECT * FROM tblSession 
        	WHERE blSesDelete = ? AND intSesId = ?', [0,$id]);
        $cole_options = DB::table('tblColearner')
            ->where('blColeDelete', 0)
            ->lists(DB::raw('concat(strColeFname," ",strColeLname) AS Name'), 'intColeId');
        $program_options = DB::table('tblProgram')
        ->where('blProgDelete', 0)
        ->lists('strProgName', 'intProgId');
        
        $school_options = DB::table('tblSchool')
        ->where('blSchDelete', 0)
        ->lists('strSchName', 'intSchId');
        return view('session.edit', ['sessions' => $result, 'cole_options' => $cole_options, 'program_options' => $program_options,'school_options'=>$school_options]);
    } 
    public function update(Request $request){
        $rules = array(
            'txtSession' => 'required',
            'selCole' => 'required',
            'selProgram' => 'required',
            'selSchool' => 'required'
        );
        $messages = [
            'required' => 'The :attribute field is required.'
        ];
        $niceNames = array(
            'txtSession' => 'Session',
            'selCole' => 'Colearner',
            'selProgram' => 'Program',
            'selSchool' => 'School'
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        $Session = Session::find($request->input('id'));

        if($Session) {
            try{
                $Session->strSesName = $request->input('txtSession');
                $Session->intSesColeId = $request->input('selCole');
                $Session->intSesProgId = $request->input('selProgram');
                $Session->intSesSchId = $request->input('selSchool');
                $Session->save();
            }catch (\Illuminate\Database\QueryException $e){
                $errMess = $e->getMessage();
                return Redirect::back()->withErrors($errMess);
            }
        }
       
        $request->session()->flash('message', 'Successfully updated.');    
        return Redirect::back();
    }
}
