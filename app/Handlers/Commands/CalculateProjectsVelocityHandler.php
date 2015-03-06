<?php namespace Softjob\Handlers\Commands;

use Carbon\Carbon;
use Softjob\Commands\CalculateProjectsVelocity;
use Softjob\Contracts\Repositories\ProjectRepoInterface;
use Softjob\Contracts\Repositories\SprintRepoInterface;
use Softjob\Project;

class CalculateProjectsVelocityHandler {

	/**
	 * @var ProjectRepoInterface
	 */
	private $projectRepo;
	/**
	 * @var SprintRepoInterface
	 */
	private $sprintRepo;

	/**
	 * Create the command handler.
	 *
	 * @param ProjectRepoInterface $projectRepo
	 * @param SprintRepoInterface $sprintRepo
	 */
	public function __construct( ProjectRepoInterface $projectRepo, SprintRepoInterface $sprintRepo)
	{
		$this->projectRepo = $projectRepo;
		$this->sprintRepo = $sprintRepo;
	}

	/**
	 * Handle the command.
	 *
	 * @param  CalculateProjectsVelocity $command
	 *
	 * @return void
	 */
	public function handle( CalculateProjectsVelocity $command )
	{
		$sprints = $this->projectRepo->getProjectById($command->projectId)->sprints()->get()->toArray();
		$result = [];

		foreach ($sprints as $sprint) {
			$s = $this->sprintRepo->getSprint($sprint['id']);
			$t = $s->tasks()->get();
			$totalComplexity = 0;
			$solvedComplexity = 0;
			foreach ($t as $task) {
				$totalComplexity += $task['complexity_point'];
				$solvedComplexity += ($task['task_status'] == 1) ? $task['complexity_point'] : 0;
			}
			$sprint['total_complexity'] = $totalComplexity;
			$sprint['solved_complexity'] = $solvedComplexity;
			$result[] = $sprint;
		}
		return $result;
	}

}
