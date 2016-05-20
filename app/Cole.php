<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Cole extends Model{
	protected $table = 'tblColearner';
	protected $primaryKey = 'intColeId';
	public $timestamps = false;
}