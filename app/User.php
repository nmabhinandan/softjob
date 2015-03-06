<?php namespace Softjob;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	/**
	 * Get the role to which the user belong to
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function role( )
	{
		return $this->belongsTo('Softjob\Role');
	}

	/**
	 * Get the organization to which the user belong to
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function organization( )
	{
		return $this->belongsTo('Softjob\Organization');
	}

	/**
	 * Get the group to which the user belong to
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function groups()
	{
		return $this->belongsToMany('Softjob\Group');
	}

	/**
	 * Get all the projects the user belong to
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function projects( )
	{
		return $this->belongsToMany('Softjob\Project');
	}

	/**
	 * Get all the projects the user own
	 *
	 * @return array
	 */
	public function ownProjects( )
	{
		return Project::where('owner_type', '=', 'user')->where('owner_id', '=', $this->id)->get();
	}

	/**
	 * Get all the projects the user manage
	 *
	 * @return array
	 */
	public function managesProjects( )
	{
		return Project::where('project_manager_id', '=', $this->id)->get();
	}

	public function todos()
	{
		return $this->hasMany('Softjob\UserTodo');
	}

	public function permissions()
	{
		return $this->belongsToMany('Softjob\Permission');
	}

}
