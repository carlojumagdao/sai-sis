<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class BirthdayController extends Controller
{
    public function index(){
    	$bdayLear = DB::select('SELECT CONCAT(strLearFname," ",strLearLname) AS Name, YEAR(CURRENT_TIMESTAMP) - YEAR(datLearBirthdate) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(datLearBirthdate, 5)) as Age FROM tblLearner WHERE MONTH(datLearBirthDate) = MONTH(NOW()) AND DAY(datLearBirthDate) = DAY(NOW()) AND blLearDelete = 0');
        $bdayCole = DB::select('SELECT CONCAT(strColeFname," ",strColeLname) AS Name, YEAR(CURRENT_TIMESTAMP) - YEAR(datColeBirthdate) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(datColeBirthdate, 5)) as Age FROM tblColearner WHERE MONTH(datColeBirthDate) = MONTH(NOW()) AND DAY(datColeBirthDate) = DAY(NOW()) AND blColeDelete = 0');
        $bdayDonor = DB::select('SELECT strDonorName as Name, YEAR(CURRENT_TIMESTAMP) - YEAR(datDonorBdate) - (RIGHT(CURRENT_TIMESTAMP, 5) < RIGHT(datDonorBdate, 5)) as Age FROM tblDonor WHERE MONTH(datDonorBDate) = MONTH(NOW()) AND DAY(datDonorBDate) = DAY(NOW()) AND blDonorDelete = 0');
        return view('pages.birthdays',['bdayLears' => $bdayLear,'bdayColes'=>$bdayCole,'bdayDonors'=>$bdayDonor]);
    }
}
