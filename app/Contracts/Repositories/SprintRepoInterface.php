<?php namespace Softjob\Contracts\Repositories;

interface SprintRepoInterface {

	/**
	 * Get sprint by sprint id
	 *
	 * @param $id
	 *
	 * @return mixed
	 */
	public function getSprint( $id );

	/**
	 * Get sprints of a project
	 *
	 * @param $projectId
	 *
	 * @return mixed
	 */
	public function getSprintsOfProject($projectId);
}