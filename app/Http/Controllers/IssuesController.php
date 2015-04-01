<?php namespace Softjob\Http\Controllers;

use Softjob\Commands\TranferIssueCommand;
use Softjob\Contracts\Repositories\IssueRepoInterface;
use Softjob\Http\Requests;
use Softjob\Http\Requests\CreateIssueRequest;
use Softjob\Http\Requests\TranferIssueRequest;

class IssuesController extends Controller {

	/**
	 * @var IssueRepoInterface
	 */
	private $issueRepo;


	/**
	 * @param IssueRepoInterface $issueRepo
	 */
	function __construct( IssueRepoInterface $issueRepo )
	{
		$this->issueRepo = $issueRepo;
	}

	public function getIssueStages()
	{
		return $this->issueRepo->getIssueStages();
	}

	public function createIssue( CreateIssueRequest $request )
	{
		$this->issueRepo->createIssue($request->all());
	}

	public function tranferIssue( TranferIssueRequest $request )
	{
		$this->dispatch(new TranferIssueCommand($request->get('issueId'), $request->get('stageId')));
	}
}
