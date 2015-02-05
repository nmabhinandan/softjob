<?php namespace Softjob;

use Illuminate\Database\Eloquent\Model;

class ProjectTag extends Model {

	public function projects( )
	{
		return $this->belongsToMany('Softjob\Project');
	}

}
