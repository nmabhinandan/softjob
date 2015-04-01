<?php namespace Softjob\Http\Controllers;

use Illuminate\Http\Response;
use Softjob\Commands\CheckPermissionCommand;
use Softjob\Contracts\Repositories\PermissionRepoInterface;
use Softjob\Http\Requests;
use Softjob\Http\Requests\EditPermissionRequest;
use Softjob\Services\AuthService;

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

	public function getUserPermissions( $userId )
	{
		$validator = \Validator::make([
			'id' => $userId
		], [
			'id' => 'required|numeric|exists:users,id'
		]);

		if ($validator->fails()) {
			return \Response::json([
				'status'  => 'error',
				'message' => 'Invalid user id'
			], 404);
		}

		return $this->permissionRepo->getUserPermissions($userId);
	}

	public function editPermission( EditPermissionRequest $request )
	{
		$this->permissionRepo->setPermission($request->all());
	}

	public function checkPermission( $permission )
	{
		$validator = \Validator::make([
			'permission' => $permission
		], [
			'permission' => 'required|string|exists:permissions,permission'
		]);

		if ($validator->fails()) {
			return \Response::json([
				'status'  => 'error',
				'message' => 'Invalid permission string'
			], 404);
		}

		return Response::create([
			'granted' => ($this->dispatch(new CheckPermissionCommand($permission, AuthService::$loggedInUser))) ? true : false
		]);

	}

	public function getRolePermissions( $roleId )
	{
		$validator = \Validator::make([
			'id' => $roleId
		], [
			'id' => 'required|numeric|exists:roles,id'
		]);

		if ($validator->fails()) {
			return \Response::json([
				'status'  => 'error',
				'message' => 'Invalid Role Id'
			], 404);
		}

		return $this->permissionRepo->getRolePermission($roleId);
	}
}
