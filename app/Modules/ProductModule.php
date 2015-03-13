<?php  namespace Softjob\Modules;


use Softjob\Contracts\Modules\ExposesPermissionsInterface;
use Softjob\Contracts\Modules\ExposesSidebarItems;
use Softjob\Contracts\Modules\Module;

class ProductModule implements Module, ExposesSidebarItems, ExposesPermissionsInterface{

	/**
	 * Return the side bar items to be rendered.
	 *
	 * @return array
	 */
	public function sideBarItems()
	{
		return [
//			'Issues' => 'dashboard.issues'
		];
	}

	/**
	 * Set permissions for the module
	 *
	 * @return mixed
	 */
	public function setPermissions()
	{

	}
}