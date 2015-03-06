<?php namespace Softjob\Http\Requests;

use Softjob\Http\Requests\Request;

class CompleteTodoRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'userId' => 'required|numeric|exists:users,id',
			'todoId' => 'required|numeric|exists:user_todos,id'
		];
	}

	public function response(array $errors)
	{
		return Response::create([
			'status' => 'error',
			'message' => 'Invalid input'
		],400);
	}
}
