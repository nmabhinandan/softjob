<?php namespace Softjob\Contracts\Repositories;

interface ProjectRepoInterface {


	/**
	 * Get project based on project id
	 *
	 * @param $id
	 *
	 * @return mixed
	 */
	public function getProjectById($id);

	/**
	 * Return the project by slug
	 *
	 * @param $slug
	 *
	 * @return mixed
	 */
	public function getProjectBySlug( $slug );

	/**
	 * Return all the projects related to the user
	 *
	 * @param $userId
	 *
	 * @return mixed
	 */
	public function projectsOfUser( $userId );

	/**
	 * Return all the projects belonging to the role
	 *
	 * @param $roleId
	 *
	 * @return mixed
	 */
	public function projectsOfRole( $roleId );

	/**
	 * Return tasks of the project
	 *
	 * @param $projectId
	 *
	 * @return mixed
	 */
	public function tasksOfProject( $projectId );


	/**
	 * Return tasks of the project which arent associated with any sprint cycles
	 *
	 * @param $projectId
	 *
	 * @return mixed
	 */
	public function availableTasksOfProject( $projectId );
}