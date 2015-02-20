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
		return false;
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
//		    'owner_type' = 'string'
		];
	}

}
