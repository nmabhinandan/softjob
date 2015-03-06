<?php namespace Softjob\Contracts\Repositories;

interface RoleRepoInterface {

	/**
	 * Get all roles
	 *
	 * @return mixed
	 */
	public function getAllRoles();

	/**
	 * Get role by ID
	 *
	 * @param $roleId
	 *
	 * @return mixed
	 */
	public function getRoleById( $roleId );

	/**
	 * Create a new role
	 *
	 * @param $role
	 *
	 * @return mixed
	 */
	public function createRole( $role );

	/**
	 * Edit an existing role
	 *
	 * @param $role
	 *
	 * @return mixed
	 */
	public function editRole( $role );

	/**
	 * Delete the role
	 *
	 * @param $roleId
	 *
	 * @return mixed
	 *
	 */
	public function deleteRole( $roleId );

}