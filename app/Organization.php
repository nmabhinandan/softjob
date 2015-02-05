<?php  namespace Softjob;


use Illuminate\Database\Eloquent\Model;

class Organization extends Model{


	public function users( )
	{
		return $this->hasMany('User');
	}
}