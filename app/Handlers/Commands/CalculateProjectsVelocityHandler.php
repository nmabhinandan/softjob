<?php namespace Softjob\Handlers\Commands;

use Carbon\Carbon;
use Softjob\Commands\CalculateProjectsVelocity;
use Softjob\Contracts\Repositories\ProjectRepoInterface;
use Softjob\Project;

class CalculateProjectsVelocityHandler {

	/**
	 * @var ProjectRepoInterface
	 */
	private $projectRepo;

	/**
	 * Create the command handler.
	 *
	 * @param ProjectRepoInterface $projectRepo
	 */
	public function __construct( ProjectRepoInterface $projectRepo )
	{
		//
		$this->projectRepo = $projectRepo;
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
		$project                    = $this->projectRepo->getProjectById($command->projectId);
		$tasks                      = $project->tasks()->get();
		$totalComplexity            = 0;
		$status                     = [ ];
		$status['current_velocity'] = [ ];
		$status['ideal_velocity'] = [ ];
		$dates = [];
		$duration = Carbon::parse($project->deadline)->diffInDays(Carbon::parse($project->created_at));
		foreach ($tasks as $task) {
			$totalComplexity += $task->complexity_point;
		}
		$idealVelFactor = $totalComplexity / ($duration+1);
		for($i=$totalComplexity;$i>=0;$i = $i-$idealVelFactor) {
			array_push($status['ideal_velocity'], $i);
		}

		for($i=0;$i<$duration;$i++) {
			array_push($dates, Carbon::parse($project->created_at)->addDays($i)->toDateTimeString());
		}
		foreach ($dates as $date) {
			$t = $task->where('completed_at','=',$date)->get()->toArray() != [] ? $task->where('completed_at','=',$date)->get()->toArray() : [['complexity_point' => 0]];
			$vel = 0;
			foreach ($t as $tsk) {
				$vel += $tsk['complexity_point'];
//				array_push($status['current_velocity'], $tsk['complexity_point']);
			}
			array_push($status['current_velocity'], $vel);
		}

		return $status;
	}

}
