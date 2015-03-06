<?php  namespace Softjob\Contracts\Repositories;


interface UserRepoInterface {


	/**
	 * Get all users sorted by roles
	 *
	 * @return mixed
	 */
	public function allUsers();

	/**
	 * Get a User by its id
	 *
	 * @param $id
	 *
	 * @return mixed
	 */
	public function getUser($id);

	/**
	 * Create a user
	 *
	 * @param $user
	 *
	 * @return mixed
	 */
	public function createUser($user);
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

	/**
	 * Edit the user
	 *
	 * @param $user
	 *
	 * @return mixed
	 */
	public function editUser($user);


	/**
	 * Get all users in raw format
	 *
	 * @return mixed
	 */
	public function rawUsers();

	/**
	 * Get todos of the user
	 *
	 * @return mixed
	 */
	public function getTodos($userId);

	/**
	 * Store a todoitem to the database
	 *
	 * @return mixed
	 */
	public function storeTodos($todo);

	/**
	 * Mark the todoItem as copleted
	 *
	 * @param $todoId
	 *
	 * @return mixed
	 */
	public function completeTodo($todoId);

	/**
	 * Clear completed todos of the user
	 *
	 * @return mixed
	 */
	public function clearTodos();
} 