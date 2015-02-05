<?php namespace Softjob\Http\Controllers;

use Softjob\Commands\GetUserContextOptionsCommand;
use Softjob\Http\Requests;
use Softjob\Http\Controllers\Controller;

class ContextOptionController extends Controller {

	public function getUserOptions($userId)
	{
		return $this->dispatch(new GetUserContextOptionsCommand($userId));
	}

	public function getProjectOptions($projectId)
	{
		
	}
}
