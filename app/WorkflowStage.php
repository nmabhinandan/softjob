<?php namespace Softjob;

use Illuminate\Database\Eloquent\Model;

class WorkflowStage extends Model {

	public function workflow( )
	{
		return $this->belongsTo('Softjob\Workflow');
	}

}
