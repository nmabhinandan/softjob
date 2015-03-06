<?php namespace Softjob\Contracts\Repositories;

interface GroupRepoInterface {


	/**
	 * Get all groups
	 *
	 * @return mixed
	 */
	public function getAllGroups();

	/**
	 * Get group by ID
	 *
	 * @param $groupId
	 *
	 * @return mixed
	 */
	public function getGroupById( $groupId );

	/**
	 * Create a new group
	 *
	 * @param $group
	 *
	 * @return mixed
	 */
	public function createGroup( $group );

	/**
	 * Edit an existing group
	 *
	 * @param $group
	 *
	 * @return mixed
	 */
	public function editGroup( $group );

	/**
	 * Delete the group
	 *
	 * @param $groupId
	 *
	 * @return mixed
	 *
	 */
	public function deleteGroup( $groupId );


	/**
	 * Return all users who aren't in the provided group
	 *
	 * @param $groupId
	 *
	 * @return mixed
	 */
	public function usersNotInGroup($groupId);

	/**
	 * Add users to the group
	 *
	 * @param $groupId
	 * @param $users
	 *
	 * @return mixed
	 */
	public function addUsers($groupId, $users);
}