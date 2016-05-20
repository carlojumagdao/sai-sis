<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class LearningCenter extends Model{
	protected $table = 'tblLearningCenter';
	protected $primaryKey = 'intLCId';
	public $timestamps = false;
}