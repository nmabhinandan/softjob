<?php namespace Softjob\Handlers\Commands;

use Softjob\Commands\TranferIssueCommand;

use Illuminate\Queue\InteractsWithQueue;
use Softjob\Contracts\Repositories\IssueRepoInterface;
use Softjob\Services\AuthService;

class TranferIssueCommandHandler {

	/**
	 * @var IssueRepoInterface
	 */
	private $issueRepo;

	/**
	 * Create the command handler.
	 *
	 * @param IssueRepoInterface $issueRepo
	 */
	public function __construct(IssueRepoInterface $issueRepo)
	{
		$this->issueRepo = $issueRepo;
	}

	/**
	 * Handle the command.
	 *
	 * @param  TranferIssueCommand  $command
	 * @return void
	 */
	public function handle(TranferIssueCommand $command)
	{
		$issue = $this->issueRepo->getIssueById($command->issueId);
		$stages = $this->issueRepo->getIssueStages();
		$currentStage = null;
		$nextStage = null;
		foreach ($stages as $stage) {
			if($currentStage != null) {
				$nextStage = $stage;
				break;
			}
			if($stage['id'] == $issue->issue_stage_id) {
				$currentStage = $stage;
			}
		}

		if($nextStage == null) {
			return;
		}
		$issue->issue_stage_id = $nextStage['id'];
		if(isset($nextStage['is_last']) && $nextStage['is_last'] == true) {
			$issue->issue_status = 1;
			$issue->solved_by = AuthService::$loggedInUser;
		}

		$issue->save();
	}

}
