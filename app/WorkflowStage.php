<?php namespace Softjob;

use Illuminate\Database\Eloquent\Model;

class WorkflowStage extends Model {

	protected $guarded = ['id'];
	public function workflow( )
	{
		return $this->belongsTo('Softjob\Workflow');
	}

	public function tasks( )
	{
		return $this->hasMany('Softjob\Task');
	}

}
