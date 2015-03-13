<?php namespace Softjob;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

	protected $guarded = ['id'];

	public function users( )
	{
		return $this->hasMany('Softjob\User');
	}

	public function permissions()
	{
		return $this->belongsToMany('Softjob\Permission');
	}
}
