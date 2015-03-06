<?php namespace Softjob\Modules;

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
		return [
			'project.create',
		    'project.edit',
		    'sprint.create'
		];
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