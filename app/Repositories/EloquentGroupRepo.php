<?php namespace Softjob\Repositories;


use Softjob\Contracts\Repositories\GroupRepoInterface;
use Softjob\Group;
use Softjob\User;

class EloquentGroupRepo implements GroupRepoInterface {

	/**
	 * @var Group
	 */
	private $model;

	/**
	 * @param Group $model
	 */
	function __construct( Group $model )
	{
		$this->model = $model;
	}


	/**
	 * Get all groups
	 *
	 * @return mixed
	 */
	public function getAllGroups()
	{
		return $this->model->all();
	}

	/**
	 * Get group by ID
	 *
	 * @param $groupId
	 *
	 * @return mixed
	 */
	public function getGroupById( $groupId )
	{
		return $this->model->with('users')->find($groupId);
	}

	/**
	 * Create a new group
	 *
	 * @param $group
	 *
	 * @return mixed
	 */
	public function createGroup( $group )
	{
		$this->model->create($group);
	}

	/**
	 * Edit an existing group
	 *
	 * @param $group
	 *
	 * @return mixed
	 */
	public function editGroup( $group )
	{
		$g = $this->model->find($group['id']);
		$g->update([
			'name'        => $group['name'],
			'description' => $group['description']
		]);
		$g->save();
	}

	/**
	 * Delete the group
	 *
	 * @param $groupId
	 *
	 * @return mixed
	 *
	 */
	public function deleteGroup( $groupId )
	{
		$this->model->find($groupId)->delete();
	}

	/**
	 * Return all users who aren't in the provided group
	 *
	 * @param $groupId
	 *
	 * @return mixed
	 */
	public function usersNotInGroup( $groupId )
	{
		/**
		 * This should be extracted to SQL query
		 */

		$u1 = User::all()->toArray();

		$result = array_filter($u1, function ( $elt ) use ( $groupId ) {
			$u2 = Group::find($groupId)->users()->get()->toArray();
			foreach ($u2 as $user) {
				if ($elt['id'] == $user['id']) {
					return false;
				}
			}

			return true;
		});

		return $result;
	}

	/**
	 * Add users to the group
	 *
	 * @param $groupId
	 * @param $users
	 *
	 * @return mixed
	 */
	public function addUsers( $groupId, $users )
	{
		$this->model->find($groupId)->users()->sync($users);
	}
}