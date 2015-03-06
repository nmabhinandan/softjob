<?php namespace Softjob;

use Illuminate\Database\Eloquent\Model;

class Workflow extends Model {

	protected $guarded = ['id'];

	public function stages( )
	{
		return $this->hasMany('Softjob\WorkflowStage')->orderBy('order');
	}

}
