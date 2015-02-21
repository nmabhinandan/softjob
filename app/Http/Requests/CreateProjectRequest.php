<?php namespace Softjob\Http\Requests;

use Softjob\Http\Requests\Request;

class CreateProjectRequest extends Request {

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
			'name' => 'string|required',
		    'slug' => 'string|required',
		    'owner_type' => 'required|string',
		    'owner_id' => 'required|numeric',
		    'organization_id' => 'required|numeric',
		    'project_manager_id' => 'required'
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