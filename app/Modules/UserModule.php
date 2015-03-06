<?php  namespace Softjob\Modules;


use Softjob\Contracts\Modules\ExposesPermissionsInterface;
use Softjob\Contracts\Modules\ExposesSidebarItems;
use Softjob\Contracts\Modules\Module;

class UserModule implements Module, ExposesSidebarItems, ExposesPermissionsInterface{

	/**
	 * Return the side bar items to be rendered.
	 *
	 * @return array
	 */
	public function sideBarItems()
	{
		return [
			'Dashboard' => 'dashboard',
			'Admin' => 'dashboard.admin'
//			'Settings' => 'dashboard.settings'
		];
	}

	/**
	 * Set permissions for the module
	 *
	 * @return mixed
	 */
	public function setPermissions()
	{
		return [
			'user.create',
		    'user.edit',
		    'role.create',
		    'role.delete',
		    'group.create',
		    'group.delete'
		];
	}
}