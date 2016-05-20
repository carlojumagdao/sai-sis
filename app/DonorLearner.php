<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class DonorLearner extends Model{
	protected $table = 'tblDonorLearner';
	protected $primaryKey = 'intDLId';
	public $timestamps = false;
}