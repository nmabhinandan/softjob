<?php namespace Softjob\Contracts\Repositories;

interface ProjectsRepoInterface {

	/**
	 * Return all the projects related to the user
	 * @param $userId
	 *
	 * @return mixed
	 */
	public function projectsOfUser($userId);

	/**
	 * Return all the projects belonging to the role
	 * @param $roleId
	 *
	 * @return mixed
	 */
	public function projectsOfRole($roleId);
}