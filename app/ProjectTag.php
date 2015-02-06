<?php namespace Softjob;

use Illuminate\Database\Eloquent\Model;

class ProjectTag extends Model {

	protected $guarded = ['id'];

	public function projects( )
	{
		return $this->belongsToMany('Softjob\Project');
	}

}
