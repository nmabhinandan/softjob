<?php  namespace Softjob\Modules\Products;


use Softjob\Contracts\Modules\ExposesSidebarItems;
use Softjob\Contracts\Modules\Module;

class ProductModule implements Module, ExposesSidebarItems{

	/**
	 * Return the side bar items to be rendered.
	 *
	 * @return array
	 */
	public function sideBarItems()
	{
		return [
			'Issues' => 'dashboard.issues'
		];
	}
}