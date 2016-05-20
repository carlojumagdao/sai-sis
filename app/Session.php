<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Session extends Model{
	protected $table = 'tblSession';
	protected $primaryKey = 'intSesId';
	public $timestamps = false;
}