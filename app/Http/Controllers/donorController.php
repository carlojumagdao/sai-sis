<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Donor AS Donor;
use App\DonorLearner AS DonorLearner;
use DB;
use Mail;
use PDF;
use App;
use Validator;
use Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class donorController extends Controller
{
    public function index(){
        $result = DB::select('SELECT * FROM tblDonor WHERE blDonorDelete = ? ORDER BY strDonorName', [0]);
        return view('donor.index', ['donors' => $result]);
    }
    public function create(Request $request){
        $rules = array(
            'txtName' => 'required',
            'txtAmount' => 'required:digit',
            'datBdate' => 'before:today',
            'txtEmail' => 'email',
        );
        $messages = [
            'required' => 'The :attribute field is required.',
        ];
        $niceNames = array(
            'datBdate' => 'Birthdate',
            'txtName' => 'Name',
            'txtEmail' => 'Email',
            'txtAmount' => 'Pledge Amount'
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        try{
            $Donor = new Donor();
            $Donor->strDonorName = $request->input('txtName');
            $Donor->strDonorEmail = $request->input('txtEmail');
            $Donor->dblDonorAmount = $request->input('txtAmount');
            $Donor->datDonorBdate = $request->input('datBdate');
            $Donor->save();
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
        $DonorLearner = DB::select('SELECT intDLDonorId FROM tblDonorLearner WHERE intDLDonorId = ? AND blDLDelete = 0', [$id]);
        if($DonorLearner ){
            return Redirect::back()->withErrors("Cannot delete this record, because it is used by another record.");
        } else{
            try{
                $Donor = Donor::find($id);
                $Donor->blDonorDelete = '1';
                $Donor->save(); 
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
        $sponsoredLearners = DB::select('SELECT d.intDLId, CONCAT(l.strLearFname," ",l.strLearLname) AS Name FROM tblDonorLearner AS d LEFT JOIN tblLearner AS l ON d.strDLLearCode = l.strLearCode WHERE d.intDLDonorId = ? AND d.blDLDelete = 0',[$id]);
        $learners = DB::select('SELECT l.strLearCode, CONCAT(l.strLearFname," ",l.strLearLname) AS Name, p.strProgName FROM tblLearner AS l LEFT JOIN tblSession AS s
                            ON l.intLearSesId = s.intSesId
                        LEFT JOIN tblProgram AS p
                            ON s.intSesProgId = p.intProgId
                        WHERE l.blLearDelete = 0 AND l.strLearCode NOT IN (SELECT strDLLearCode FROM tblDonorLearner) ORDER by p.strProgName;');
        $result = DB::select('SELECT * FROM tblDonor WHERE blDonorDelete = ? AND intDonorId = ?', [0,$id]);
        return view('donor.edit', ['donors' => $result,'learners' => $learners,'sponsored'=>$sponsoredLearners]);
    }  
    public function update(Request $request){
        $rules = array(
            'txtName' => 'required',
            'datBdate' => 'before:today',
            'txtEmail' => 'email',
            'txtAmount' => 'required:digit',
        );
        $messages = [
            'required' => 'The :attribute field is required.',
        ];
        $niceNames = array(
            'datBdate' => 'Birthdate',
            'txtName' => 'Name',
            'txtEmail' => 'Email',
            'txtAmount' => 'Pledge amount',
        );
        $validator = Validator::make($request->all(),$rules,$messages);
        $validator->setAttributeNames($niceNames); 
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }
        $Donor = Donor::find($request->input('id'));
        if($Donor) {
            try{
                $Donor->strDonorName = $request->input('txtName');
                $Donor->strDonorEmail = $request->input('txtEmail');
                $Donor->dblDonorAmount = $request->input('txtAmount');
                $Donor->datDonorBdate = $request->input('datBdate');
                $Donor->save();
            }catch (\Illuminate\Database\QueryException $e){
                $errMess = $e->getMessage();
                return Redirect::back()->withErrors($errMess);
            }
            
        }

        $request->session()->flash('message', 'Successfully updated.');    
        return Redirect::back();
    }
    public function addSponsoredLearners(Request $request){
        $learners = $request->input('learners');
        $id = $request->input('code');
        $counter = 0;   
        foreach ($learners as $learner) {  
            $one[$counter] = array('intDLDonorId'=>$id, 'strDLLearCode'=>$learner);
            $counter++;
        }
        try{
            $DonorLearner = new DonorLearner();
            $DonorLearner->insert($one);
        }catch (\Illuminate\Database\QueryException $e){
            $errMess = $e->getMessage();
            return view('donor.index')->withErrors($errMess);
        }
        $sponsoredLearners = DB::select('SELECT d.intDLId, CONCAT(l.strLearFname," ",l.strLearLname) AS Name FROM tblDonorLearner AS d LEFT JOIN tblLearner AS l ON d.strDLLearCode = l.strLearCode WHERE d.intDLDonorId = ? AND d.blDLDelete = 0',[$id]);
        $learners = DB::select('SELECT l.strLearCode, CONCAT(l.strLearFname," ",l.strLearLname) AS Name, p.strProgName FROM tblLearner AS l LEFT JOIN tblSession AS s
                            ON l.intLearSesId = s.intSesId
                        LEFT JOIN tblProgram AS p
                            ON s.intSesProgId = p.intProgId
                        WHERE l.blLearDelete = 0 AND l.strLearCode NOT IN (SELECT strDLLearCode FROM tblDonorLearner) ORDER by p.strProgName;');
        return view('donor.donee', ['learners' => $learners,'sponsored'=>$sponsoredLearners]);
    }
    public function deleteDonee(Request $request){
        $donLearId = $request->input('donLearId');
        $donorId = $request->input('donorId');
        try{
            $DonorLearner = DonorLearner::find($donLearId);
            $DonorLearner->delete();
        }catch (\Illuminate\Database\QueryException $e){
            $errMess = $e->getMessage();
            return view('donor.index')->withErrors($errMess);
        }
        $sponsoredLearners = DB::select('SELECT d.intDLId, CONCAT(l.strLearFname," ",l.strLearLname) AS Name FROM tblDonorLearner AS d LEFT JOIN tblLearner AS l ON d.strDLLearCode = l.strLearCode WHERE d.intDLDonorId = ? AND d.blDLDelete = 0',[$donorId]);
        $learners = DB::select('SELECT l.strLearCode, CONCAT(l.strLearFname," ",l.strLearLname) AS Name, p.strProgName FROM tblLearner AS l LEFT JOIN tblSession AS s
                            ON l.intLearSesId = s.intSesId
                        LEFT JOIN tblProgram AS p
                            ON s.intSesProgId = p.intProgId
                        WHERE l.blLearDelete = 0 AND l.strLearCode NOT IN (SELECT strDLLearCode FROM tblDonorLearner) ORDER by p.strProgName;');
        return view('donor.donee', ['learners' => $learners,'sponsored'=>$sponsoredLearners]);
    }
    public function EmailSend(Request $request)
    {   
        $id = $request->input('id');
        $email = $request->input('email');
        $donee = DB::select('SELECT d.strDonorName AS donorName,d.strDonorEmail AS email, dl.strDLLearCode as learnerCode, CONCAT(l.strLearFname," ",l.strLearLname) AS learname FROM tblDonorLearner AS dl INNER JOIN tblDonor as d ON d.intDonorId = dl.intDLDonorId INNER JOIN tblLearner AS l ON dl.strDLLearCode = l.strLearCode WHERE d.intDonorId = ?',[$id]);

        Mail::send('emails.donor', ['donees' => $donee], function ($message) use ($donee){
            foreach ($donee as $value) {
                $email = $value->email;
                break;
            }
            $message->to("$email")->subject('Your Silid Aralan Learner');
        });
    }
}


// line 161
// 4:35pm May 16
// I Added learner name in the query
