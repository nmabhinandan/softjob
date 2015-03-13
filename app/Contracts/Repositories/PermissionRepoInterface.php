<?php namespace Softjob\Contracts\Repositories;

interface PermissionRepoInterface {

	/**
	 * Create or update the given permission
	 *
	 * @param $permission
	 *
	 * @return mixed
	 */
	public function createOrUpdatePermission( $permission );

	/**
	 * Get all of the permissions
	 *
	 * @param $userId
	 *
	 * @return mixed
	 */
	public function getUserPermissions($userId);

	/**
	 * Set the permission to a user/role
	 *
	 * @param $data
	 *
	 * @return mixed
	 */
	public function setPermission( $data );

	/**
	 * Check whether the use has the permission or not
	 *
	 * @param $permission
	 *
	 * @return mixed
	 */
	public function checkPermission( $permission );

	/**
	 * Get permissions of the role
	 *
	 * @param $roleId
	 *
	 * @return mixed
	 */
	public function getRolePermission( $roleId );
}