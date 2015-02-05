<?php  namespace Softjob\Contracts\Repositories;


interface UserRepoInterface {

	/**
	 * Get a User by its id
	 *
	 * @param $id
	 *
	 * @return mixed
	 */
	public function getUser($id);

	/**
	 * Get a User by its username
	 *
	 * @param $username
	 *
	 * @return mixed
	 */
	public function getUserByUsername($username);

	/**
	 * Check whether the given username and password are valid or not
	 *
	 * @param $username
	 * @param $password
	 *
	 * @return mixed
	 */
	public function checkUsernameAndPassword($username, $password);

	/**
	 * Returns the avatar of the given user
	 *
	 * @param $id
	 *
	 * @return mixed
	 */
	public function getAvatar($id);
} 