<?php namespace Softjob\Http\Controllers;

use Softjob\Commands\CalculateSprintsStatus;
use Softjob\Http\Requests;
use Softjob\Http\Controllers\Controller;

use Illuminate\Http\Request;

class SprintsController extends Controller {


	function __construct()
	{
	}

	public function getSprint($sprintId)
	{
		$validator = \Validator::make([
			'id' => $sprintId
		], [
			'id' => 'required|numeric|exists:sprints,id'
		]);
		if ($validator->fails()) {
			return \Response::json([
				'status'  => 'error',
				'message' => 'Invalid sprint id'
			], 400);
		}


	}


	public function getSprintsStatusOfProject($projectId)
	{
		$validator = \Validator::make([
			'id' => $projectId
		], [
			'id' => 'required|numeric|exists:projects,id'
		]);

		if ($validator->fails()) {
			return \Response::json([
				'status'  => 'error',
				'message' => 'Invalid project id'
			], 404);
		}

		return $this->dispatch(new CalculateSprintsStatus($projectId));
	}

}
