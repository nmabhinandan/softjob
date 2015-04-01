<?php namespace Softjob\Handlers\Commands;

use Carbon\Carbon;
use Softjob\Commands\CalculateSprintBurndown;

use Illuminate\Queue\InteractsWithQueue;
use Softjob\Contracts\Repositories\SprintRepoInterface;

class CalculateSprintBurndownHandler {

	/**
	 * @var SprintRepoInterface
	 */
	private $sprintRepo;

	/**
	 * Create the command handler.
	 *
	 * @param SprintRepoInterface $sprintRepo
	 */
	public function __construct( SprintRepoInterface $sprintRepo )
	{
		$this->sprintRepo = $sprintRepo;
	}

	/**
	 * Handle the command.
	 *
	 * @param  CalculateSprintBurndown $command
	 *
	 * @return void
	 */
	public function handle( CalculateSprintBurndown $command )
	{
//		$project                    = $this->projectRepo->getProjectById($command->projectId);
		$sprint = $this->sprintRepo->getSprint($command->sprintId);
//		$tasks                      = $project->tasks()->get();
		$tasks                      = $sprint->tasks()->get();
		$totalComplexity            = 0;
		$status                     = [ ];
		$status['current_velocity'] = [ ];
		$status['ideal_velocity']   = [ ];
		$dates                      = [ ];

		$duration = Carbon::parse($sprint->deadline)->diffInDays(Carbon::parse($sprint->created_at));
//		$duration = Carbon::parse($sprint->deadline)->day - Carbon::parse($sprint->created_at)->day;

		foreach ($tasks as $task) {
			$totalComplexity += $task->complexity_point;
		}


		if ($duration != 0 && $totalComplexity != 0) {
			$idealVelFactor = $totalComplexity / $duration;
		} else {
			return [
				'current_velocity' => 0,
				'ideal_velocity'   => 0
			];
		}


		for ($i = $totalComplexity; $i > - 1; $i -= $idealVelFactor) {
			if ($i < 0) {
				$i = 0;
			}
			array_push($status['ideal_velocity'], $i);
		}

		for ($i = 0; $i < $duration; $i ++) {

			if((Carbon::parse($sprint->created_at)->addDays($i)->gt(Carbon::today()))) {
				break;
			}
			array_push($dates, Carbon::parse($sprint->created_at)->addDays($i)->toDateString());
		}

		$vel = $totalComplexity;

		foreach ($dates as $date) {

//			$t = $task->where('completed_at','=',$date)->get()->toArray() != [] ? $task->where('completed_at','=',$date)->get()->toArray() : [['complexity_point' => 0]];
			$t = [ ];
			foreach ($tasks as $task) {
				if (Carbon::parse($task['completed_at'])->toDateString() == Carbon::parse($date)->toDateString()) {
					array_push($t, $task);
				}
			}

			foreach ($t as $tsk) {
				$vel -= $tsk['complexity_point'];
			}
			array_push($status['current_velocity'], $vel);
		}

		return $status;
	}
}
