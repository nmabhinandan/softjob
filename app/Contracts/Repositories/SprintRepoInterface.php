<?php namespace Softjob\Contracts\Repositories;

interface SprintRepoInterface {

	/**
	 * Get sprint by sprint id
	 *
	 * @param $id
	 *
	 * @return mixed
	 */
	public function getSprint( $id );

	/**
	 * Get sprints of a project
	 *
	 * @param $projectId
	 *
	 * @return mixed
	 */
	public function getSprintsOfProject( $projectId );

	/**
	 * Create a new sprint
	 *
	 * @param $sprint
	 *
	 * @return mixed
	 */
	public function createSprint( $sprint );

	/**
	 * Get all workflows
	 *
	 * @return mixed
	 */
	public function getWorkflows();


	/**
	 * Get a single workflow stage
	 *
	 * @param $workflowStageId
	 *
	 * @return mixed
	 */
	public function getWorkflowStageById( $workflowStageId );

	/**
	 * Get all stages of the workflow
	 *
	 * @param $workflowId
	 *
	 * @return mixed
	 */
	public function getWorkflowStages( $workflowId );
}