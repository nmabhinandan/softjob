<?php  namespace Softjob\Modules\Users;


use Softjob\Contracts\Modules\ExposesSidebarItems;
use Softjob\Contracts\Modules\Module;

class UserModule implements Module, ExposesSidebarItems{

	/**
	 * Return the side bar items to be rendered.
	 *
	 * @return array
	 */
	public function sideBarItems()
	{
		return [
			'Dashboard' => 'dashboard',
			'Admin' => 'admin'
//			'Settings' => 'dashboard.settings'
		];
	}
}