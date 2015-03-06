<?php namespace Softjob\Http\Requests;

use Illuminate\Http\Response;
use Softjob\Http\Requests\Request;

class AddUsersToGroupRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true
			;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'groupId' => 'required|exists:groups,id',
			'users' => 'required|array'
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
