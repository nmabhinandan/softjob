<?php namespace Softjob;

use Illuminate\Database\Eloquent\Model;

class Issue extends Model {

	protected $guarded = [ 'id' ];

	public function stage()
	{
		return $this->belongsTo('Softjob\IssueStage');
	}

	public function product()
	{
		return $this->belongsTo('Softjob\Product');
	}
}
