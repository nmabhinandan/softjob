<?php namespace Softjob\Modules\Projects;

use Softjob\Contracts\Modules\ExposesPermissionsInterface;
use Softjob\Contracts\Modules\ExposesSidebarItems;
use Softjob\Contracts\Modules\Module;


class ProjectModule implements Module, ExposesPermissionsInterface, ExposesSidebarItems {

	/**
	 * Set permissions for the module
	 *
	 * @return mixed
	 */
	public function setPermissions()
	{
		// TODO: Implement setPermissions() method.
	}

	/**
	 * Check whether the user has the permission or not
	 *
	 * @param $permission
	 *
	 * @return bool
	 */
	public function checkUserPermission( $permission )
	{
		// TODO: Implement checkUserPermission() method.
	}

	/**
	 * Check whether the role has the permission or not
	 *
	 * @param $permission
	 *
	 * @return bool
	 */
	public function checkRolePermission( $permission )
	{
		// TODO: Implement checkRolePermission() method.
	}

	/**
	 * Return the side bar items to be rendered.
	 *
	 * @return array
	 */
	public function sideBarItems()
	{
		return [
			'Projects' => 'dashboard.projects',
		    'Workspace' => 'dashboard.workspace'
		];
	}
}