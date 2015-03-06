<?php namespace Softjob\Handlers\Commands;

use Softjob\Commands\CalculateProjectsStatus;
use Softjob\Contracts\Repositories\ProjectRepoInterface;
use Softjob\Contracts\Repositories\UserRepoInterface;

class CalculateProjectsStatusHandler {

	/**
	 * @var ProjectRepoInterface
	 */
	private $projectRepo;

	/**
	 * Create the command handler.
	 *
	 * @param ProjectRepoInterface $projectRepo
	 *
	 * @internal param UserRepoInterface $userRepo
	 */
	public function __construct( ProjectRepoInterface $projectRepo )
	{
		$this->projectRepo = $projectRepo;
	}

	/**
	 * Handle the command.
	 *
	 * @param  CalculateProjectsStatus $command
	 *
	 * @return void
	 */
	public function handle( CalculateProjectsStatus $command )
	{

		$projects = $this->projectRepo->projectsOfUser($command->userId)->toArray();
		$status   = [ ]; //imp
		foreach ($projects as $project) {
			$totalComplexity   = 0;
			$currentComplexity = 0;
			foreach ($project['tasks'] as $task) {
				$totalComplexity += $task['complexity_point'];
				$currentComplexity += ($task['task_status'] == 1) ? $task['complexity_point'] : 0;
			}

			array_push($status, [
				"name"   => $project['name'],
				"status" => ($totalComplexity != 0) ? floor(($currentComplexity / $totalComplexity) * 100) : 0
			]);

		}

		return $status;
	}

}
