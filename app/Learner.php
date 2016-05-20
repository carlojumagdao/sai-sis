<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Learner extends Model{
	protected $table = 'tblLearner';
	protected $primaryKey = 'strLearCode';
	public $timestamps = false;
}