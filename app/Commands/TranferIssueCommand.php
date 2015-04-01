<?php namespace Softjob\Commands;

class TranferIssueCommand extends Command {

	/**
	 * @var
	 */
	public $issueId;
	/**
	 * @var
	 */
	public $stageId;

	/**
	 * Create a new command instance.
	 *
	 * @param $issueId
	 * @param $stageId
	 */
	public function __construct( $issueId, $stageId )
	{
		$this->issueId = $issueId;
		$this->stageId = $stageId;
	}

}
