<?php

namespace App\Http\Controllers;

use DB;
use Validator;
use App\LearningCenter AS LearningCenter;
use App\School AS School;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
use Redirect;
class LearningCenterController extends Controller{
    
    

    public function index() {
        $lc = DB::select('SELECT * FROM tblLearningCenter WHERE blLCDelete = ?', [0]);
        return view('learningcenter.index', ['LearningCenters' => $lc]);
    }

    public function create(Request $request){
        $rules = array(
            'txtLearningCenter' => 'required'
        );
        $messages = [
            'required' => 'The :attribute field is required.',
        ];
        $niceNames = array(
            'txtLearningCenter' => 'Learning Center'
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        try{
            $LearningCenters = new LearningCenter();
            $LearningCenters->strLCLocation = $request->input('txtLearningCenter');
            $LearningCenters->save();
        }catch (\Illuminate\Database\QueryException $e){
            $errMess = $e->getMessage();
            return Redirect::back()->withErrors($errMess);
        }

        //redirect
        $request->session()->flash('message', 'Successfully added.');    
        return redirect('/learningcenter');
    }

    public function delete(){
        $id = $_POST['id'];
        $User = DB::select('SELECT id FROM users WHERE intULCId = ? AND blUDelete = 0', [$id]);
        $School = DB::select('SELECT intSchId FROM tblSchool WHERE intSchLCId = ? AND blSchDelete = 0', [$id]);
        if($School || $User){
            return Redirect::back()->withErrors("Cannot delete this record, because it is used by another record.");
        } else{
            try{
              $LearningCenters = LearningCenter::find($id);
                $LearningCenters->blLCDelete = '1';
                $LearningCenters->save();  
            }catch (\Illuminate\Database\QueryException $e){
                $errMess = $e->getMessage();
                return Redirect::back()->withErrors($errMess);
            }
            
        }
        //redirect
        return redirect('/learningcenter');
    }
    public function edit(Request $request, $id){
        // //store
        $lc = DB::select('SELECT * FROM tblLearningCenter WHERE blLCDelete = ? AND intLCId = ?', [0,$id]);
        return view('learningcenter.edit', ['LearningCenters' => $lc]);
    }
    public function update(Request $request){
        $rules = array(
            'txtLearningCenter' => 'required'
        );
        $messages = [
            'required' => 'The :attribute field is required.',
        ];
        $niceNames = array(
            'txtLearningCenter' => 'Learning Center'
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        try{
            DB::table('tblLearningCenter')
            ->where('intLCId', $request->input('id'))
            ->update(['strLCLocation' => $request->input('txtLearningCenter')]);
        }catch (\Illuminate\Database\QueryException $e){
            $errMess = $e->getMessage();
            return Redirect::back()->withErrors($errMess);
        }
        $request->session()->flash('message', 'Successfully updated.');    
        return Redirect::back();
    }
}
