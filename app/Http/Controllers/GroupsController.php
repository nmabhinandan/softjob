<?php namespace Softjob\Http\Controllers;

use Softjob\Contracts\Repositories\GroupRepoInterface;
use Softjob\Http\Requests;
use Softjob\Http\Requests\AddUsersToGroupRequest;
use Softjob\Http\Requests\CreateGroupRequest;
use Softjob\Http\Requests\EditGroupRequest;

class GroupsController extends Controller {

	/**
	 * @var GroupRepoInterface
	 */
	private $groupRepo;


	/**
	 * @param GroupRepoInterface $groupRepo
	 */
	function __construct( GroupRepoInterface $groupRepo )
	{
		$this->groupRepo = $groupRepo;
	}

	public function getAllGroups()
	{
		return $this->groupRepo->getAllGroups();
	}

	public function getGroup( $groupId )
	{
		$validator = \Validator::make([
			'id' => $groupId
		], [
			'id' => 'required|numeric|exists:groups,id'
		]);

		if ($validator->fails()) {
			return \Response::json([
				'status'  => 'error',
				'message' => 'Invalid group id'
			], 404);
		}

		return $this->groupRepo->getGroupById($groupId);
	}

	public function setGroup( CreateGroupRequest $request )
	{
		$this->groupRepo->createGroup($request->all());
	}

	public function updateGroup( EditGroupRequest $request )
	{
		$this->groupRepo->editGroup($request->all());
	}

	public function deleteGroup( $groupId )
	{
		$validator = \Validator::make([
			'id' => $groupId
		], [
			'id' => 'required|numeric|exists:groups,id'
		]);

		if ($validator->fails()) {
			return \Response::json([
				'status'  => 'error',
				'message' => 'Invalid group id'
			], 404);
		}

		$this->groupRepo->deleteGroup($groupId);
	}

	public function usersNotInGroup( $groupId )
	{
		$validator = \Validator::make([
			'id' => $groupId
		], [
			'id' => 'required|numeric|exists:groups,id'
		]);

		if ($validator->fails()) {
			return \Response::json([
				'status'  => 'error',
				'message' => 'Invalid group id'
			], 404);
		}

		return $this->groupRepo->usersNotInGroup($groupId);
	}

	public function addUsers( AddUsersToGroupRequest $request )
	{
		$this->groupRepo->addUsers($request->get('groupId'), $request->get('users'));
	}
}
