<?php  namespace Softjob\Http\Controllers;

use Softjob\Contracts\Repositories\UserRepoInterface;
use Softjob\Http\Requests\CompleteTodoRequest;
use Softjob\Http\Requests\CreateTodoRequest;
use Softjob\Http\Requests\CreateUserRequest;
use Softjob\Http\Requests\EditUserRequest;
use Softjob\User;

class UserController extends Controller {

	protected $user;

	/**
	 * @param UserRepoInterface $user
	 */
	function __construct(UserRepoInterface $user)
	{

		$this->user = $user;
	}

	public function getAllUsers()
	{
		return $this->user->allUsers();
	}

	public function createUser(CreateUserRequest $request)
	{
		$this->user->createUser($request->all());
	}

	public function getUser($userId)
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

		return $this->user->getUser($userId);
	}

	public function editUser(EditUserRequest $request)
	{
		$this->user->editUser($request->all());
	}

	public function getRawUsers()
	{
		return $this->user->rawUsers();
	}

	public function getTodos($userId)
	{
		$validator = \Validator::make([
			'id' => $userId
		], [
			'id' => 'required|numeric|exists:users,id'
		]);

		if ($validator->fails()) {
			return \Response::json([
				'status'  => 'error',
				'message' => 'Invalid group id'
			], 404);
		}

		return $this->user->getTodos($userId);
	}

	public function createTodo(CreateTodoRequest $request)
	{
		$this->user->storeTodos($request->all());
	}

	public function completeTodo(CompleteTodoRequest $request)
	{
		$this->user->completeTodo($request->all());
	}

	public function clearTodos()
	{
		$this->user->clearTodos();
	}
}