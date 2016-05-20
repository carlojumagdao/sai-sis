<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Program extends Model{
	protected $table = 'tblProgram';
	protected $primaryKey = 'intProgId';
	public $timestamps = false;
}