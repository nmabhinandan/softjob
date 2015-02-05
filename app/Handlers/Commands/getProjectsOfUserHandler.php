<?php namespace Softjob\Handlers\Commands;

use Softjob\Commands\getProjectsOfUser;

use Illuminate\Queue\InteractsWithQueue;
use Softjob\Contracts\Repositories\ProjectsRepoInterface;

class getProjectsOfUserHandler {

	/**
	 * @var ProjectsRepoInterface
	 */
	private $projects;

	/**
	 * Create the command handler.
	 *
	 * @param ProjectsRepoInterface $projects
	 *
	 * @internal param ProjectsRepoInterface $projectsRepo
	 */
	public function __construct(ProjectsRepoInterface $projects)
	{

		$this->projects = $projects;
	}

	/**
	 * Handle the command.
	 *
	 * @param  getProjectsOfUser  $command
	 * @return void
	 */
	public function handle(getProjectsOfUser $command)
	{
		return $this->projects->projectsOfUser($command->userId);
	}

}
