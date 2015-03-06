<?php namespace Softjob;

use Illuminate\Database\Eloquent\Model;

class UserTodo extends Model {

	protected $guarded = ['id'];

	public function user()
	{
		return $this->belongsTo('Softjob\User');
	}
}
