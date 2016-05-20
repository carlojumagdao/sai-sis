<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User AS User;
use Hash;
use DB;
use Validator;
use Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class userController extends Controller
{
    public function index(){
        $result = DB::select('SELECT u.id,u.name, u.email, l.strLCLocation FROM users AS u
                LEFT JOIN tblLearningCenter AS l ON u.intULCId = l.intLCId  WHERE u.blUDelete = 0');
        $lc_options = DB::table('tblLearningCenter')
        ->where('blLCDelete', 0)
        ->lists('strLCLocation', 'intLCId');
        return view('users.index', ['users' => $result, 'lc_options' => $lc_options]);
    }   
    public function create(Request $request){
        $rules = array(
            'txtName' => 'required',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'selLC' => 'required',
            'pic' => 'mimes:jpeg,jpg,png,bmp|max:10000'
        );
        $messages = [
            'required' => 'The :attribute field is required.'
        ];
        $niceNames = array(
            'txtName' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'selLC' => 'Lerning Center',
            'pic' => 'Image'
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        } else{
            if($request->file('pic')->isValid()) {
                $destinationPath = 'assets/images/user-uploads'; // upload path
                $extension = $request->file('pic')->getClientOriginalExtension(); // getting image extension
                $fileName = rand(11111,99999).'.'.$extension; // renameing image
                $request->file('pic')->move($destinationPath, $fileName); // uploading file to given path
                try{
                    $User = new User();
                    $User->name = $request->input('txtName');
                    $User->email = $request->input('email');
                    $User->password = bcrypt($request->input('password'));
                    if($request->input('admin') == 1){
                       $User->admin = $request->input('admin'); 
                    }
                    $User->intULCId = $request->input('selLC');
                    $User->strPicPath = $fileName;
                    $User->save();
                }catch (\Illuminate\Database\QueryException $e){
                    $errMess = $e->getMessage();
                    return Redirect::back()->withErrors($errMess);
                }
            } else{
                return Redirect::back()->withErrors("uploaded file is not valid");
            }
        }
        //redirect
        $request->session()->flash('message', 'Successfully Added.');    
        return Redirect::back();
    }
    public function update(Request $request){
        $rules = array(
            'txtName' => 'required',
            'email' => 'required|email|max:255'
        );
        $messages = [
            'required' => 'The :attribute field is required.'
        ];
        $niceNames = array(
            'txtName' => 'Name',
            'email' => 'Email',
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        } else{
            try{
                $User = User::find(session('id'));
                if($User) {
                    try{
                        $User->email = $request->input('email');
                        $User->name = $request->input('txtName');
                        $User->save();  
                        session(['name' => $request->input('txtName')]);
                    }catch (\Illuminate\Database\QueryException $e){
                        $errMess = $e->getMessage();
                        return Redirect::back()->withErrors($errMess);
                    }
                }
            }catch (\Illuminate\Database\QueryException $e){
                $errMess = $e->getMessage();
                return Redirect::back()->withErrors($errMess);
            }
        }
        //redirect
        $request->session()->flash('message', 'Successfully Updated.');    
        return Redirect::back();
    }

    public function changepassword(Request $request){
        $rules = array(
            'old_password' => 'required|min:6',
            'password' => 'required|confirmed|min:6',
        );
        $messages = [
            'required' => 'The :attribute field is required.'
        ];
        $niceNames = array(
            'password' => 'Password',
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        } else{
            try{
                $User = new User();    
                $result = DB::select('SELECT password from users where id = ?',[session('id')]);
            }catch (\Illuminate\Database\QueryException $e){
                $errMess = $e->getMessage();
                return Redirect::back()->withErrors($errMess);
            }
            foreach ($result as $value) {
                $password = $value->password;
            }
            if (Hash::check($request->input('old_password'), $password)) {
                $User = User::find(session('id'));
                $User->password = bcrypt($request->input('password'));
                $User->save();
            } else{
                return Redirect::back()->withErrors("Old password didn't match.");
            }
            $request->session()->flash('message', 'Password Changed.');    
            return Redirect::back();
        }
    }

    public function delete(Request $request){
        $id = $request->input('id');
        try{
            $User = User::find($id);
            $User->blUDelete = '1';
            $User->save();  
        }catch (\Illuminate\Database\QueryException $e){
            $errMess = $e->getMessage();
            return Redirect::back()->withErrors($errMess);
        }
        //redirect
        return Redirect::back();
    }
    public function profile(){
        $id = session('id');
        $result = DB::select('SELECT u.id,u.name, u.email, u.admin,u.strPicPath,u.intULCId, l.strLCLocation FROM users AS u LEFT JOIN tblLearningCenter AS l ON u.intULCId = l.intLCId  WHERE u.id = ?',[$id]);
        $lc_options = DB::table('tblLearningCenter')
        ->where('blLCDelete', 0)
        ->lists('strLCLocation', 'intLCId');
        
        return view('users.profile', ['users' => $result, 'lc_options' => $lc_options]);
    }
}
