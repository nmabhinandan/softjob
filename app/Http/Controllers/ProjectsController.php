<?php namespace Softjob\Http\Controllers;


use Softjob\Commands\getProjectsOfUser;
use Softjob\Http\Requests\GetProjectsOfUserRequest;

class ProjectsController extends Controller {

	public function getProjectsOfUser($userId)
	{
		$validator = \Validator::make([
			'id' => $userId
		],[
			'id' => 'required|numeric|exists:users,id'
		]);
		if($validator->fails()) {
			return \Response::json([
				'status' => 'error',
			    'message' => 'Invalid user id'
			], 400);
		}
		return $this->dispatch(new getProjectsOfUser($userId));
	}

}