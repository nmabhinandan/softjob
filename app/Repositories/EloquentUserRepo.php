<?php namespace Softjob\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Softjob\Contracts\Repositories\UserRepoInterface;
use Softjob\Group;
use Softjob\Role;
use Softjob\Services\AuthService;
use Softjob\User;
use Softjob\UserTodo;
use Symfony\Component\Debug\Exception\FatalErrorException;

class EloquentUserRepo implements UserRepoInterface {

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
			return $this->user->with('groups')->find($id)->toArray();
		} catch(\Exception $e) {
			return false;
		}

//		return true;
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

	/**
	 * Get all users sorted by roles
	 *
	 * @return mixed
	 */
	public function allUsers()
	{
		return Role::with('users.groups')->get();
	}

	/**
	 * Create a user
	 *
	 * @param $user
	 *
	 * @return mixed
	 */
	public function createUser( $user )
	{
		$user['password'] = Hash::make($user['password']);
		$this->user->create($user);
	}

	/**
	 * Edit the user
	 *
	 * @param $user
	 *
	 * @return mixed
	 */
	public function editUser( $user )
	{
		$user['password'] = \Hash::make($user['password']);
		$u = $this->user->find($user['id']);
		unset($user['id']);
		$u->update([
			'first_name' => $user['first_name'],
		    'last_name' => $user['last_name'],
		    'email' => $user['last_name'],
		    'avatar' => 'default.jpg',
		    'password' => $user['password'],
		    'role_id' => $user['role_id']
		]);
		$u->save();
	}

	/**
	 * Get all users in raw format
	 *
	 * @return mixed
	 */
	public function rawUsers()
	{
		return $this->user->all();
	}

	/**
	 * Get todos of the user
	 *
	 * @return mixed
	 */
	public function getTodos( $userId )
	{
		return $this->user->find($userId)->todos()->get();
	}

	/**
	 * Store a todoitem to the database
	 *
	 * @return mixed
	 */
	public function storeTodos( $todo )
	{
		UserTodo::create([
			'name' => $todo['todo'],
		    'user_id' => AuthService::$loggedInUser
		]);
	}

	/**
	 *
	 * @param $todoId
	 *
	 * @return mixed
	 */
	public function completeTodo( $todo )
	{
		$todo = UserTodo::find($todo['todoId']);
		$todo->done = 1;
		$todo->save();
	}

	/**
	 * Clear completed todos of the user
	 *
	 * @return mixed
	 */
	public function clearTodos()
	{
		$this->user->find(AuthService::$loggedInUser)->todos()->where('done', '=', 1)->delete();
	}
}