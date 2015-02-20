<?php  namespace Softjob\Repositories;


use Softjob\Contracts\Repositories\SprintRepoInterface;

class EloquentSprintRepo implements SprintRepoInterface{

	/**
	 * Get sprint by sprint id
	 *
	 * @param $id
	 *
	 * @return mixed
	 */
	public function getSprint( $id )
	{
		// TODO: Implement getSprint() method.
	}

	/**
	 * Get sprints of a project
	 *
	 * @param $projectId
	 *
	 * @return mixed
	 */
	public function getSprintsOfProject( $projectId )
	{
		// TODO: Implement getSprintsOfProject() method.
	}
}