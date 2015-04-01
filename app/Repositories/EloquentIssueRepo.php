<?php namespace Softjob\Repositories;


use Softjob\Contracts\Repositories\IssueRepoInterface;
use Softjob\Issue;
use Softjob\IssueStage;

class EloquentIssueRepo implements IssueRepoInterface {

	/**
	 * @var Issue
	 */
	private $issue;
	/**
	 * @var IssueStage
	 */
	private $issueStage;

	/**
	 * @param Issue $issue
	 *
	 * @param IssueStage $issueStage
	 *
	 * @internal param $Issue $
	 */
	function __construct( Issue $issue, IssueStage $issueStage )
	{
		$this->issue      = $issue;
		$this->issueStage = $issueStage;
	}


	/**
	 * Create a new issue
	 *
	 * @param $data
	 *
	 * @return mixed
	 */
	public function createIssue( $data )
	{
		$this->issue->create([
			'name'           => $data['name'],
			'slug'           => $data['slug'],
			'description'    => $data['description'],
			'product_id'     => $data['productId'],
			'issue_stage_id' => 1,
			'issue_status'   => 0
		]);
	}

	/**
	 * Get a specific issue by it's id
	 *
	 * @param $id
	 *
	 * @return mixed
	 */
	public function getIssueById( $id )
	{
		return $this->issue->with('stage')->find($id);
	}

	/**
	 * Create issue from external sources
	 *
	 * @param $data
	 *
	 * @return mixed
	 */
	public function createIssueFromExternal( $data )
	{
		// TODO: Implement createIssueFromExternal() method.
	}

	/**
	 * Get all issue stages
	 *
	 * @return mixed
	 */
	public function getIssueStages()
	{
		$stages                                    = $this->issueStage->orderBy('order')->get()->toArray();
		$stages[ (count($stages) - 1) ]['is_last'] = true;

		return $stages;
	}
}