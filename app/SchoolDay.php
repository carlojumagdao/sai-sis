<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class SchoolDay extends Model{
	protected $table = 'tblSchoolDay';
	protected $primaryKey = 'intSDId';
	public $timestamps = false;
}