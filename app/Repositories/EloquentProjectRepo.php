<?php namespace Softjob\Repositories;


use Carbon\Carbon;
use Softjob\Contracts\Repositories\ProjectRepoInterface;
use Softjob\Project;
use Softjob\ProjectTag;
use Softjob\User;

class EloquentProjectRepo implements ProjectRepoInterface {

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
	function __construct( Project $project, User $user )
	{
		$this->model = $project;
		$this->user  = $user;
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
		return $this->model->with('users')->find($id);
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
		return $this->user->find($userId)->projects()->with('tasks', 'tags')->get();
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
		$result = array_pop($result);

		if ( ! empty($result['tasks'])) {
			$complete = true;

			foreach ($result['tasks'] as $task) {
				if ($task['task_status'] == 0) {
					$complete = false;
				}
			}
			if ($complete) {
				$result['project_completed'] = true;
			}
		}

		return $result;
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

		$proj = $this->model->create([
			'name'               => $data['name'],
			'slug'               => $data['slug'],
			'description'        => $data['description'],
			'owner_type'         => $data['owner_type'],
			'owner_id'           => $data['owner_id'],
			'organization_id'    => $data['organization_id'],
			'deadline'           => Carbon::parse($data['deadline']),
			'project_manager_id' => $data['project_manager_id']
		]);

		if ($data['owner_type'] == 'user') {
			$proj->users()->attach($data['owner_id']);
		}

		if (is_array($data['tags'])) {
			foreach ($data['tags'] as $tag) {
				$t = ProjectTag::updateOrCreate([
					'name' => trim($tag)
				]);

				$proj->tags()->attach($t->id);
			}

		}

		$proj->save();
	}

	/**
	 * Add users to the request
	 *
	 * @param $data
	 *
	 * @return mixed
	 */
	public function addUsers( $data )
	{
		$p = $this->model->find($data['id']);
		foreach ($data['users'] as $user) {
			$p->users()->attach($user['id']);
		}
		$p->save();

	}
}