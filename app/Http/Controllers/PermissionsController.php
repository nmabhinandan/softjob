<?php namespace Softjob\Http\Controllers;

use Softjob\Contracts\Repositories\PermissionRepoInterface;
use Softjob\Http\Requests;
use Softjob\Http\Controllers\Controller;

use Illuminate\Http\Request;

class PermissionsController extends Controller {

	/**
	 * @var PermissionRepoInterface
	 */
	private $permissionRepo;


	/**
	 * @param PermissionRepoInterface $permissionRepo
	 */
	function __construct( PermissionRepoInterface $permissionRepo )
	{
		$this->permissionRepo = $permissionRepo;
	}

	public function getAllPermissions()
	{
		return $this->permissionRepo->getAllPermissions();
	}

	public function setPermission( $permission )
	{

	}

	public function checkPermission( $permission )
	{

	}
}
