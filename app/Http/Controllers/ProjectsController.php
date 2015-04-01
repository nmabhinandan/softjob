<?php namespace Softjob\Http\Controllers;


use Softjob\Commands\CalculateProjectsStatus;
use Softjob\Commands\CalculateProjectsVelocity;
use Softjob\Commands\getProjectBySlug;
use Softjob\Commands\getProjectsOfUser;
use Softjob\Contracts\Repositories\ProjectRepoInterface;
use Softjob\Http\Requests\AddUsersToProjectRequest;
use Softjob\Http\Requests\CreateProjectRequest;


class ProjectsController extends Controller {

	/**
	 * @var
	 */
	private $projectModel;


	/**
	 * @param ProjectRepoInterface $projectModel
	 */
	function __construct( ProjectRepoInterface $projectModel )
	{
		$this->projectModel = $projectModel;
	}

	public function getProject( $slug )
	{
		$validator = \Validator::make([
			'slug' => $slug
		], [
			'slug' => 'required|string|exists:projects,slug'
		]);
		if ($validator->fails()) {
			return \Response::json([
				'status'  => 'error',
				'message' => 'Invalid project slug'
			], 400);
		}

		return $this->projectModel->getProjectBySlug($slug);
	}

	public function getProjectById( $projectId )
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

		return $this->projectModel->getProjectById($projectId);
	}

	public function getProjectsOfUser( $userId )
	{
		$validator = \Validator::make([
			'id' => $userId
		], [
			'id' => 'required|numeric|exists:users,id'
		]);
		if ($validator->fails()) {
			return \Response::json([
				'status'  => 'error',
				'message' => 'Invalid user id'
			], 404);
		}

		return $this->projectModel->projectsOfUser($userId);
	}

	public function getProjectTasks( $projectId )
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

		return $this->projectModel->tasksOfProject($projectId);
	}

	public function createProject( CreateProjectRequest $request )
	{
		$this->projectModel->createProject($request->all());
	}

	public function getProjectsStatusOfUser( $userId )
	{
		$validator = \Validator::make([
			'id' => $userId
		], [
			'id' => 'required|numeric|exists:users,id'
		]);
		if ($validator->fails()) {
			return \Response::json([
				'status'  => 'error',
				'message' => 'Invalid user id'
			], 404);
		}

		return $this->dispatch(new CalculateProjectsStatus($userId));
	}


	public function getAvailableProjectTasks( $projectId )
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

		return $this->projectModel->availableTasksOfProject($projectId);
	}

	public function getProjectVelocity( $projectId )
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

		return $this->dispatch(new CalculateProjectsVelocity($projectId));
	}

	public function getProjectSprints( $projectId )
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

		return $this->projectModel->sprintsOfProject($projectId);
	}

	public function addUsersToProject( AddUsersToProjectRequest $request )
	{
		$this->projectModel->addUsers($request->all());
	}

}