<?php  namespace Softjob\Repositories;


use Softjob\Repositories\PermissionRepoInterface;
use Softjob\Permission;

class EloquentPermissionRepo implements PermissionRepoInterface {


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