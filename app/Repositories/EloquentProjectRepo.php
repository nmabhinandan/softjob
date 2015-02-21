<?php  namespace Softjob\Repositories;


use Softjob\Contracts\Repositories\ProjectRepoInterface;
use Softjob\Project;
use Softjob\User;

class EloquentProjectRepo implements ProjectRepoInterface{

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
	 * Get project based on project id
	 *
	 * @param $id
	 *
	 * @return mixed
	 */
	public function getProjectById( $id )
	{
		return $this->model->find($id);
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
		return $this->user->find($userId)->projects()->with('tasks','tags')->get();
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

	/**
	 * Return tasks of the project
	 *
	 * @param $projectId
	 *
	 * @return mixed
	 */
	public function tasksOfProject( $projectId )
	{
		return $this->model->find($projectId)->tasks()->get();
	}

	/**
	 * Return the project by slug
	 *
	 * @param $slug
	 *
	 * @return mixed
	 */
	public function getProjectBySlug( $slug )
	{
		$result = $this->model->whereSlug($slug)->with('tasks')->get()->toArray();

		return array_pop($result);
	}


	/**
	 * Return tasks of the project which arent associated with any sprint cycles
	 *
	 * @param $projectId
	 *
	 * @return mixed
	 */
	public function availableTasksOfProject( $projectId )
	{
		return $this->model->find($projectId)->tasks()->whereNotIn('');
	}

	/**
	 * Return the sprints of the project
	 *
	 * @param $projectId
	 *
	 * @return mixed
	 */
	public function sprintsOfProject( $projectId )
	{
		return $this->model->find($projectId)->sprints()->with('tasks')->get();
	}

	/**
	 * Create project
	 *
	 * @param $data
	 *
	 * @return mixed
	 */
	public function createProject( $data )
	{
		$this->model->create($data);
	}
}