<?php namespace Softjob;

use Illuminate\Database\Eloquent\Model;

class Sprint extends Model {

	public function workflow( )
	{
		return $this->hasOne('Softjob\Workflow');
	}

	public function tasks( )
	{
		return $this->hasMany('Softjob\Task');
	}

}
