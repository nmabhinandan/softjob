<?php namespace Softjob\Http\Requests;

use Softjob\Http\Requests\Request;

class TranferTaskRequest extends Request {

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
			'stage_id' => 'required|numeric|exists:workflow_stages,id',
		    'workflow_id' => 'required|numeric|exists:workflows,id',
		    'task_id' => 'required|numeric|exists:tasks,id'
		];
	}

	public function response(array $errors)
	{
		return Response::create([
			'status' => 'error',
			'message' => $errors
		],400);
	}

}
