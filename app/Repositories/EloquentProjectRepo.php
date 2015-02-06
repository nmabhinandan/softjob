<?php  namespace Softjob\Repositories;


use Softjob\Contracts\Repositories\ProjectsRepoInterface;
use Softjob\Project;
use Softjob\User;

class EloquentProjectRepo implements ProjectsRepoInterface{

	/**
	 * @var Project
	 */
	private $model;
	/**
	 * @var User
	 */
	private $user;

	/**
	 * @param Project $project
	 * @param User $user
	 */
	function __construct(Project $project, User $user)
	{
		$this->model = $project;
		$this->user = $user;
	}


	/**
	 * Return all the projects related to the user
	 *
	 * @param $userId
	 *
	 * @return mixed
	 */
	public function projectsOfUser( $userId )
	{
		return $this->user->find(21)->projects()->with('tags')->get();
	}

	/**
	 * Return all the projects belonging to the role
	 *
	 * @param $roleId
	 *
	 * @return mixed
	 */
	public function projectsOfRole( $roleId )
	{

	}
}