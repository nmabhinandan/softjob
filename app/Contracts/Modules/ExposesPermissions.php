<?php namespace Softjob\Contracts\Modules;

interface ExposesPermissionsInterface {

	/**
	 * Set permissions for the module
	 *
	 * @return mixed
	 */
	public function setPermissions();
}