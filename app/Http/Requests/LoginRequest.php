<?php namespace Softjob\Http\Requests;

use Illuminate\Http\Response;

class LoginRequest extends Request {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'username' => 'required',
			'password' => 'required',
		];
	}

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	public function response(array $errors)
	{
		return Response::create([
			'status' => 'error',
		    'message' => 'Username and password fields are required'//$errors
		],400);
	}

}
