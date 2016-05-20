<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model{
	protected $table = 'tblAttendance';
	protected $primaryKey = 'intAttId';
	public $timestamps = false;
}