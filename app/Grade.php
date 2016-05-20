<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model{
	protected $table = 'tblGrade';
	protected $primaryKey = 'intGrdId';
	public $timestamps = false;
}