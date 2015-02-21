<?php namespace Softjob;

use Illuminate\Database\Eloquent\Model;

class Task extends Model {

	protected $guarded = ['id'];

	public function project( )
	{
		return $this->belongsTo('Softjob\Project');
	}

	public function sprint( )
	{
		return $this->belongsTo('Softjob\Sprint');
	}
}
