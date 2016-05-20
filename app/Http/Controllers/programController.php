<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Program AS Program;
use DB;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Redirect;
class programController extends Controller
{
    public function index(){ 
        $result = DB::select('SELECT * FROM tblProgram WHERE blProgDelete = ?', [0]);
        return view('program.index', ['programs' => $result]);
    }
    public function create(Request $request){
        $rules = array(
            'txtProgram' => 'required'
        );
        $messages = [
            'required' => 'The :attribute field is required.',
        ];
        $niceNames = array(
            'txtProgram' => 'Program'
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        try{
           $Program = new Program();
            $Program->strProgName = $request->input('txtProgram');
            $Program->save(); 
        }catch (\Illuminate\Database\QueryException $e){
            $errMess = $e->getMessage();
            return Redirect::back()->withErrors($errMess);
        }
        

        //redirect
        $request->session()->flash('message', 'Successfully added.');    
        return redirect('/program');
    } 
    public function delete(){
        $id = $_POST['id'];

        $Session = DB::select('SELECT intSesId FROM tblSession WHERE intSesProgId = ? AND blSesDelete = 0', [$id]);
        if($Session){
            return Redirect::back()->withErrors("Cannot delete this record, because it is used by another record.");
        } else{
            $Program = Program::find($id);
            $Program->blProgDelete = '1';
            $Program->save();
        }
        //redirect
        return Redirect::back();
    }
     public function edit(Request $request, $id){
        // //store
        $result = DB::select('SELECT * FROM tblProgram WHERE blProgDelete = ? AND intProgId = ?', [0,$id]);
        return view('program.edit', ['programs' => $result]);
    } 
     public function update(Request $request){
        $rules = array(
            'txtProgram' => 'required'
        );
        $messages = [
            'required' => 'The :attribute field is required.'
        ];
        $niceNames = array(
            'txtProgram' => 'Program'
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        $Program = Program::find($request->input('id'));
        if($Program) {
            try{
                $Program->strProgName = $request->input('txtProgram');
                $Program->save();  
            }catch (\Illuminate\Database\QueryException $e){
                $errMess = $e->getMessage();
                return Redirect::back()->withErrors($errMess);
            }
        }

        $request->session()->flash('message', 'Successfully updated.');    
        return Redirect::back();
    }
}
