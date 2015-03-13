<?php  namespace Softjob\Modules;


use Softjob\Contracts\Modules\ExposesPermissionsInterface;
use Softjob\Contracts\Modules\Module;

class TaskModule implements Module, ExposesPermissionsInterface {

	/**
	 * Set permissions for the module
	 *
	 * @return mixed
	 */
	public function setPermissions()
	{

	}
}