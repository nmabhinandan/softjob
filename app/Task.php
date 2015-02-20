<?php namespace Softjob;

use Illuminate\Database\Eloquent\Model;

class Task extends Model {

	public function project( )
	{
		return $this->belongsTo('Softjob\Project');
	}

	public function sprint( )
	{
		return $this->belongsTo('Softjob\Sprint');
	}
}
