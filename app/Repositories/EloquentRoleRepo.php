<?php  namespace Softjob\Repositories;

use Softjob\Contracts\Repositories\RoleRepoInterface;
use Softjob\Role;

class EloquentRoleRepo implements RoleRepoInterface {

	/**
	 * @var Role
	 */
	private $model;


	/**
	 * @param Role $model
	 */
	function __construct(Role $model)
	{
		$this->model = $model;
	}

	public function getAllRoles()
	{
		return $this->model->all();
	}

	public function getRoleById($roleId)
	{
		return $this->model->with('users')->find($roleId);
	}

	/**
	 * Create a new role
	 *
	 * @param $role
	 *
	 * @return mixed
	 */
	public function createRole( $role )
	{
		$this->model->create($role);
	}

	/**
	 * Edit an existing role
	 *
	 * @param $role
	 *
	 * @return mixed
	 */
	public function editRole( $role )
	{
		$r = $this->model->find($role['id']);
		$r->update([
			'name' => $role['name'],
		    'description' => $role['description']
		]);
		$r->save();
	}

	/**
	 * Delete the role
	 *
	 * @param $roleId
	 *
	 * @return mixed
	 *
	 */
	public function deleteRole( $roleId )
	{
		$this->model->find($roleId)->delete();
	}
}