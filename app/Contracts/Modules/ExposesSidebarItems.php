<?php namespace Softjob\Contracts\Modules;

interface ExposesSidebarItems {

	/**
	 * Return the side bar items to be rendered.
	 *
	 * @return array
	 */
	public function sideBarItems();
}