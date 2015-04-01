<?php namespace Softjob\Handlers\Commands;

use Carbon\Carbon;
use Softjob\Commands\TranferTask;
use Softjob\Contracts\Repositories\SprintRepoInterface;
use Softjob\Contracts\Repositories\TaskRepoInterface;
use Softjob\Services\AuthService;

class TranferTaskHandler {

	/**
	 * @var TaskRepoInterface
	 */
	private $taskRepo;
	/**
	 * @var SprintRepoInterface
	 */
	private $sprintRepo;

	/**
	 * Create the command handler.
	 *
	 * @param TaskRepoInterface $taskRepo
	 * @param SprintRepoInterface $sprintRepo
	 */
	public function __construct( TaskRepoInterface $taskRepo, SprintRepoInterface $sprintRepo )
	{
		$this->taskRepo   = $taskRepo;
		$this->sprintRepo = $sprintRepo;
	}

	/**
	 * Handle the command.
	 *
	 * @param  TranferTask $command
	 *
	 * @return void
	 */
	public function handle( TranferTask $command )
	{
		$task = $this->taskRepo->findTaskById($command->data['task_id']);
//		$stages = $this->sprintRepo->getWorkflowStages($command->data['workflow_id']);
		$stage = $this->sprintRepo->getWorkflowStageById($command->data['stage_id']);
		if (isset($stage['is_last'])) {
			if ($stage['is_last'] == true) {
				return;
			}
		}
		$nextStage = $this->sprintRepo->getWorkflowStageById(($command->data['stage_id']) + 1);
		if (isset($nextStage['is_last'])) {
			if ($nextStage['is_last'] == true) {
				$task->workflow_stage_id = $command->data['stage_id'] + 1;
				$task->task_status       = 1;
				$task->completed_at      = Carbon::now();
				$task->completed_by      = AuthService::$loggedInUser;
				$task->save();
			}
		} else {
			$task->workflow_stage_id = $command->data['stage_id'] + 1;
			$task->save();
		}
	}

}
