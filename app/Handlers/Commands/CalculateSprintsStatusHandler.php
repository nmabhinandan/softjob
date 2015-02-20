<?php namespace Softjob\Handlers\Commands;

use Softjob\Commands\CalculateSprintsStatus;

use Illuminate\Queue\InteractsWithQueue;
use Softjob\Contracts\Repositories\ProjectRepoInterface;
use Softjob\Contracts\Repositories\SprintRepoInterface;
use Softjob\Project;

class CalculateSprintsStatusHandler {

	/**
	 * @var ProjectRepoInterface
	 */
	private $projectRepo;

	/**
	 * Create the command handler.
	 *
	 * @param ProjectRepoInterface $projectRepo
	 */
	public function __construct(ProjectRepoInterface $projectRepo)
	{
		$this->projectRepo = $projectRepo;
	}

	/**
	 * Handle the command.
	 *
	 * @param  CalculateSprintsStatus  $command
	 * @return void
	 */
	public function handle(CalculateSprintsStatus $command)
	{
		$sprints = Project::find(7)->sprints();
		$status = [];
		foreach ($sprints->with('tasks')->get()->toArray() as $sprint) {
			$totalComplexity = 0;
			$solvedComplexity = 0;
			foreach ($sprint['tasks'] as $task) {
				$totalComplexity += $task['complexity_point'];
				if($task['task_status'] == 1) {
					$solvedComplexity += $task['complexity_point'];
				}
			}
			$status[$sprint['name']] = floor(($solvedComplexity/$totalComplexity)*100);
		}

		return $status;
	}
}
