<?php namespace Softjob;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

	protected $guarded = ['id'];

	public function issues()
	{
		return $this->hasMany('Softjob\Issue');
	}
}
