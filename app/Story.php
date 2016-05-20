<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Story extends Model{
	protected $table = 'tblStory';
	protected $primaryKey = 'intStoId';
	public $timestamps = false;
}