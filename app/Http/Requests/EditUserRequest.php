<?php namespace Softjob\Http\Requests;

use Softjob\Http\Requests\Request;

class EditUserRequest extends Request {

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
			'id' => 'required|numeric|exists:users,id',
		    'first_name' => 'required|string',
		    'last_name' => 'required|string',
		    'email' => 'required|email',
		    'password' => 'required',
		    'role_id' => 'required|numeric|exists:roles,id'
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
