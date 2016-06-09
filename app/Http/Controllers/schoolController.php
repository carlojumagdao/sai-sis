<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\School AS School;
use DB;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
use Redirect;
class schoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = DB::select('SELECT s.intSchId, s.strSchName, s.strSchCoorName, l.strLCLocation FROM tblSchool AS s LEFT JOIN tblLearningCenter AS l ON s.intSchLCId = l.intLCId WHERE s.blSchDelete = ?', [0]);
        $area_options = DB::table('tblLearningCenter')
            ->where('blLCDelete', 0)
            ->lists('strLCLocation', 'intLCId');
        return view('school.index', ['schools' => $result, 'area_options' => $area_options]);
    }
    public function create(Request $request){
        $rules = array(
            'txtSchool' => 'required|before:today',
            'selArea' => 'required',
            'txtContact' => 'digits:11'
        );
        $messages = [
            'required' => 'The :attribute field is required.',
            'digits' => 'The :attribute field must be a 11 digit characters.',
        ];
        $niceNames = array(
            'txtSchool' => 'School',
            'txtCoordinator' => 'Coordinator',
            'selArea' => 'Area',
            'txtContact' => 'Contact'
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        try{
            $School = new School();
            $School->strSchName = $request->input('txtSchool');
            $School->strSchPrinName = $request->input('txtPrincipal');
            $School->strSchCoorName = $request->input('txtCoordinator');
            $School->strSchContact = $request->input('txtContact');
            $School->intSchLCId = $request->input('selArea');
            $School->save();   
        }catch (\Illuminate\Database\QueryException $e){
            $errMess = $e->getMessage();
            return Redirect::back()->withErrors($errMess);
        }
        //redirect
        $request->session()->flash('message', 'Successfully added.');    
        return redirect('/school');
    }
    public function delete(){
        $id = $_POST['id'];

        $Learner = DB::select('SELECT strLearCode FROM tblLearner WHERE intLearSchId = ? AND blLearDelete = 0', [$id]);
        if($Learner){
            return Redirect::back()->withErrors("Cannot delete this record, because it is used by another record.");
        } else{   
            $School = School::find($id);
            $School->blSchDelete = '1';
            $School->save();
        }
        //redirect
        return Redirect::back();
    }
    public function edit(Request $request, $id){
        // //store
        $result = DB::select('SELECT * FROM tblSchool WHERE blSchDelete = ? AND intSchId = ?', [0,$id]);
        $area_options = DB::table('tblLearningCenter')
            ->where('blLCDelete', 0)
            ->lists('strLCLocation', 'intLCId');
        return view('school.edit', ['schools' => $result, 'area_options' => $area_options]);
    }    
    public function update(Request $request){
        $rules = array(
            'txtSchool' => 'required|before:today',
            'selArea' => 'required',
            'txtContact' => 'digits:11'
        );
        $messages = [
            'required' => 'The :attribute field is required.',
            'digits' => 'The :attribute field must be a 11 digit characters.',
        ];
        $niceNames = array(
            'txtSchool' => 'School',
            'txtCoordinator' => 'Coordinator',
            'selArea' => 'Area',
            'txtContact' => 'Contact'
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        
        $School = School::find($request->input('id'));
        if($School) {
            try{
               $School->strSchName = $request->input('txtSchool');
                $School->strSchPrinName = $request->input('txtPrincipal');
                $School->strSchCoorName = $request->input('txtCoordinator');
                $School->strSchContact = $request->input('txtContact');
                $School->intSchLCId = $request->input('selArea');
                $School->save(); 
            }catch (\Illuminate\Database\QueryException $e){
                $errMess = $e->getMessage();
                return Redirect::back()->withErrors($errMess);
            }
            
        }

        $request->session()->flash('message', 'Successfully updated.');    
        return Redirect::back();
    }
}
