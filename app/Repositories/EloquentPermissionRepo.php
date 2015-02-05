<?php  namespace Softjob\Repositories;


use Softjob\Repositories\PermissionsRepoInterface;
use Softjob\Permission;

class EloquentPermissionRepo implements PermissionsRepoInterface {


	/**
	 * @var Permission
	 */
	protected $model;

	function __construct(Permission $model)
	{

		$this->model = $model;
	}

	public function createOrUpdatePermission($permission)
	{
		$this->model->updateOrCreate([
			'permission' => $permission
		]);
	}
}