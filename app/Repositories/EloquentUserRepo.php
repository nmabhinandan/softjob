<?php namespace Softjob\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Softjob\Contracts\Repositories\UserRepoInterface;
use Softjob\User;

class EloquentUserRepo implements  UserRepoInterface{

	/**
	 * @var \Softjob\User
	 */
	private $user;

	function __construct(User $user)
	{

		$this->user = $user;
	}

	/**
	 * @param $id
	 *
	 * @return mixed
	 */
	public function getUser($id)
	{
		try {
			return $this->user->find($id)->toArray();
		} catch(\Exception $e) {
			return false;
		}
	}

	/**
	 * Get User by username
	 * @param $username
	 *
	 * @return mixed
	 */
	public function getUserByUsername($username)
	{
		try {
			return $this->user->where('username', $username)->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}
	}


	/**
	 * Check whether the given username and password are valid or not
	 *
	 * @param $username
	 * @param $password
	 *
	 * @return mixed
	 */

	public function checkUsernameAndPassword($username, $password)
	{
		if( $this->getUserByUsername($username) != false && Hash::check($password, \Softjob\User::where('username', $username)->first()->password)) {
			return true;
		}
		return false;
	}

	/**
	 * Returns the avatar of the given user
	 *
	 * @param $id
	 *
	 * @return mixed
	 */
	public function getAvatar($id, $size = 70)
	{

	}
}