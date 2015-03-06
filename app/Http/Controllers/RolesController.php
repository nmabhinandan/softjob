<?php namespace Softjob\Http\Controllers;

use Softjob\Contracts\Repositories\RoleRepoInterface;
use Softjob\Http\Requests;
use Softjob\Http\Requests\CreateRoleRequest;
use Softjob\Http\Requests\EditRoleRequest;

class RolesController extends Controller {

	/**
	 * @var RoleRepoInterface
	 */
	private $roleRepo;


	/**
	 * @param RoleRepoInterface $roleRepo
	 */
	function __construct( RoleRepoInterface $roleRepo )
	{
		$this->roleRepo = $roleRepo;
	}

	public function getAllRoles()
	{
		return $this->roleRepo->getAllRoles();
	}

	public function getRole( $roleId )
	{
		$validator = \Validator::make([
			'id' => $roleId
		], [
			'id' => 'required|numeric|exists:roles,id'
		]);

		if ($validator->fails()) {
			return \Response::json([
				'status'  => 'error',
				'message' => 'Invalid role id'
			], 404);
		}

		return $this->roleRepo->getRoleById($roleId);
	}

	public function setRole( CreateRoleRequest $request )
	{
		$this->roleRepo->createRole($request->all());
	}

	public function updateRole( EditRoleRequest $request )
	{
		$this->roleRepo->editRole($request->all());
	}

	public function deleteRole( $roleId )
	{
		$validator = \Validator::make([
			'id' => $roleId
		], [
			'id' => 'required|numeric|exists:roles,id'
		]);

		if ($validator->fails()) {
			return \Response::json([
				'status'  => 'error',
				'message' => 'Invalid role id'
			], 404);
		}

		$this->roleRepo->deleteRole($roleId);
	}
}
