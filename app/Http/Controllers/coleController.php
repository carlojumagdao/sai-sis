<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cole AS Cole;
use DB;
use Validator;
use Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class coleController extends Controller
{
    public function index(){
        $result = DB::select('SELECT * FROM tblColearner WHERE blColeDelete = ?', [0]);
        return view('cole.index', ['coles' => $result]);
    }
    public function create(Request $request){
    	$rules = array(
			'datBdate' => 'required|before:today',
			'txtFname' => 'required',
            'txtLname' => 'required',
            'rdGender' => 'required',
            'txtContact' => 'required|digits:11'
		);
		$messages = [
		    'required' => 'The :attribute field is required.',
		    'digits' => 'The :attribute field must be a 11 digit characters.',
		];
		$niceNames = array(
		    'datBdate' => 'Birthdate',
			'txtFname' => 'First Name',
            'txtLname' => 'Last Name',
            'rdGender' => 'Gender',
            'txtContact' => 'Contact'
		);
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        try{
            $Cole = new Cole();
            $Cole->strColeFname = $request->input('txtFname');
            $Cole->strColeLname = $request->input('txtLname');
            $Cole->blColeGender = $request->input('rdGender');
            $Cole->strColeContact = $request->input('txtContact');
            $Cole->datColeBirthDate = $request->input('datBdate');
            $Cole->save();
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

        $Session = DB::select('SELECT intSesId FROM tblSession WHERE intSesColeId = ? AND blSesDelete = 0', [$id]);
        if($Session){
            return Redirect::back()->withErrors("Cannot delete this record, because it is used by another record.");
        } else{           
            $Cole = Cole::find($id);
            $Cole->blColeDelete = '1';
            $Cole->save();
        }
        //redirect
        return Redirect::back();
    }
    public function edit(Request $request, $id){
        // //store
        $result = DB::select('SELECT * FROM tblColearner WHERE blColeDelete = ? AND intColeId = ?', [0,$id]);
        return view('cole.edit', ['coles' => $result]);
    }   
    public function update(Request $request){
        $rules = array(
			'datBdate' => 'required|before:today',
			'txtFname' => 'required',
            'txtLname' => 'required',
            'rdGender' => 'required',
            'txtContact' => 'required|digits:11'
		);
		$messages = [
		    'required' => 'The :attribute field is required.',
		    'digits' => 'The :attribute field must be a 11 digit characters.',
		];
		$niceNames = array(
		    'datBdate' => 'Birthdate',
			'txtFname' => 'First Name',
            'txtLname' => 'Last Name',
            'rdGender' => 'Gender',
            'txtContact' => 'Contact'
		);
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        $Cole = Cole::find($request->input('id'));
        if($Cole) {
            try{
                $Cole->strColeFname = $request->input('txtFname');
                $Cole->strColeLname = $request->input('txtLname');
                $Cole->blColeGender = $request->input('rdGender');
                $Cole->strColeContact = $request->input('txtContact');
                $Cole->datColeBirthDate = $request->input('datBdate');
                $Cole->save();
            }catch (\Illuminate\Database\QueryException $e){
                $errMess = $e->getMessage();
                return Redirect::back()->withErrors($errMess);
            }
            
        }

        $request->session()->flash('message', 'Successfully updated.');    
        return Redirect::back();
    }
}
