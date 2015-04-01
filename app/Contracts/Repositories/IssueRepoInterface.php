<?php namespace Softjob\Contracts\Repositories;

interface IssueRepoInterface {

	/**
	 * Create a new issue
	 *
	 * @param $data
	 *
	 * @return mixed
	 */
	public function createIssue( $data );

	/**
	 * Get a specific issue by it's id
	 *
	 * @param $id
	 *
	 * @return mixed
	 */
	public function getIssueById( $id );

	/**
	 * Get all issue stages
	 *
	 * @return mixed
	 */
	public function getIssueStages();

	/**
	 * Create issue from external sources
	 *
	 * @param $data
	 *
	 * @return mixed
	 */
	public function createIssueFromExternal( $data );
}