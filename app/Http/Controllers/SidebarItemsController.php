<?php namespace Softjob\Http\Controllers;


use Softjob\Commands\GetSidebarItems;
use Softjob\Http\Requests;
use Softjob\Http\Controllers\Controller;

use Illuminate\Http\Request;

class SidebarItemsController extends Controller {

	/**
	 *
	 */
	public function get()
	{
		return $this->dispatch(new GetSidebarItems());
	}
}
