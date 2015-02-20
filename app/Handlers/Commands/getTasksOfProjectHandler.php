<?php namespace Softjob\Handlers\Commands;

use Softjob\Commands\getTasksOfProject;

use Illuminate\Queue\InteractsWithQueue;
use Softjob\Contracts\Repositories\ProjectRepoInterface;

class getTasksOfProjectHandler {

	/**
	 * @var ProjectsRepoInterface
	 */
	private $projectsRepo;

	/**
	 * Create the command handler.
	 *
	 * @param ProjectRepoInterface|ProjectsRepoInterface $projectsRepo
	 */
	public function __construct(ProjectRepoInterface $projectsRepo)
	{
		$this->projectsRepo = $projectsRepo;
	}

	/**
	 * Handle the command.
	 *
	 * @param  getTasksOfProject  $command
	 * @return void
	 */
	public function handle(getTasksOfProject $command)
	{
		return $this->projectsRepo->tasksOfProject($command->projectId);
	}

}
