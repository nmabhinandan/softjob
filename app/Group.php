<?php namespace Softjob;

use Illuminate\Database\Eloquent\Model;

class Group extends Model {

	protected $guarded = ['id'];

	public function users()
	{
		return $this->belongsToMany('Softjob\User');
	}

}
