<?php  namespace Softjob\Modules;


use Softjob\Contracts\Modules\ExposesPermissionsInterface;

class SprintModule implements ExposesPermissionsInterface {


	/**
	 * Set permissions for the module
	 *
	 * @return mixed
	 */
	public function setPermissions()
	{
		return [
			'sprint.create'
		];
	}
}