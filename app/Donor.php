<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Donor extends Model{
	protected $table = 'tblDonor';
	protected $primaryKey = 'intDonorId';
	public $timestamps = false;
}