<?php namespace Softjob;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

	public function users( )
	{
		$this->belongsToMany('User');
	}
}
