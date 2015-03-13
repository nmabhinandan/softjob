<?php namespace Softjob\Http\Requests;

use Illuminate\Http\Response;
use Softjob\Http\Requests\Request;

class EditPermissionRequest extends Request {

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
			'permission' => 'required|string|exists:permissions,permission',
			'userId' => 'required_without_all:roleId|numeric|exists:users,id',
			'roleId' => 'required_without_all:userId|numeric|exists:roles,id',
		    'granted' => 'required|boolean'
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
