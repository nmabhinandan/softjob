<?php namespace Softjob;

use Illuminate\Database\Eloquent\Model;

class Project extends Model {

	protected $guarded = ['id'];

	/**
	 * Get all the users who belong to the project
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function users( )
	{
		return $this->belongsToMany('Softjob\User');
	}

	/**
	 * Get the manager of the project
	 *
	 * @return \Illuminate\Support\Collection|null|static
	 */
	public function manager( )
	{
		return User::find($this->project_manager_id);
	}

	/**
	 * Get the owner of the project
	 *
	 * @return \Illuminate\Support\Collection|null|static
	 */
	public function owner( )
	{
		if($this->owner_type == 'user') {
			return User::find($this->owner_id);
		} else if($this->owner_type == 'role') {
			return Role::find($this->owner_id);
		} else {
			$model = ucwords($this->owner_type);
			$modelInstance = new $model;
			return $modelInstance->find($this->owner_id);
		}
	}

	public function tags( )
	{
		return $this->belongsToMany('Softjob\ProjectTag');
	}
}
