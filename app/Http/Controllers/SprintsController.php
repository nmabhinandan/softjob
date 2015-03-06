<?php namespace Softjob\Http\Controllers;

use Softjob\Commands\CalculateSprintBurndown;
use Softjob\Commands\CalculateSprintsStatus;
use Softjob\Contracts\Repositories\SprintRepoInterface;
use Softjob\Http\Requests;
use Softjob\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Softjob\Http\Requests\CreateSprintRequest;
use Softjob\Workflow;

class SprintsController extends Controller {

	/**
	 * @var SprintRepoInterface
	 */
	private $repo;


	/**
	 * @param SprintRepoInterface $repo
	 */
	function __construct(SprintRepoInterface $repo)
	{
		$this->repo = $repo;
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

		return $this->repo->getSprint($sprintId);

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

	public function createSprint( CreateSprintRequest $request)
	{
		$this->repo->createSprint($request->all());
	}

	public function getAllWorkflows()
	{
		return $this->repo->getWorkflows();
	}

	public function getSprintBurndown($sprintId)
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
		return $this->dispatch(new CalculateSprintBurndown($sprintId));
	}

	public function getWorkflowStages($workflowId)
	{
		$validator = \Validator::make([
			'id' => $workflowId
		], [
			'id' => 'required|numeric|exists:workflows,id'
		]);
		if ($validator->fails()) {
			return \Response::json([
				'status'  => 'error',
				'message' => 'Invalid workflow id'
			], 400);
		}

		return $this->repo->getWorkflowStages($workflowId);
	}

}
