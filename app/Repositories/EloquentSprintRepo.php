<?php namespace Softjob\Repositories;


use Carbon\Carbon;
use Softjob\Contracts\Repositories\SprintRepoInterface;
use Softjob\Project;
use Softjob\Sprint;
use Softjob\Task;
use Softjob\Workflow;
use Softjob\WorkflowStage;

class EloquentSprintRepo implements SprintRepoInterface {

	/**
	 * @var Sprint
	 */
	private $model;

	/**
	 * @param Sprint $model
	 */
	function __construct( Sprint $model )
	{
		$this->model = $model;
	}


	/**
	 * Get sprint by sprint id
	 *
	 * @param $id
	 *
	 * @return mixed
	 */
	public function getSprint( $id )
	{
		return $this->model->with('workflow')->find($id);
	}

	/**
	 * Get sprints of a project
	 *
	 * @param $projectId
	 *
	 * @return mixed
	 */
	public function getSprintsOfProject( $projectId )
	{
		// TODO: Implement getSprintsOfProject() method.
	}

	/**
	 * Create a new sprint
	 *
	 * @param $sprint
	 *
	 * @return mixed
	 */
	public function createSprint( $sprint )
	{

		$s = $this->model->create([
			'name'       => $sprint['name'],
			'project_id' => $sprint['project_id'],
			'deadline'   => Carbon::parse($sprint['deadline'])
		]);

		$w      = Workflow::create([
			'name'      => $sprint['name'] . ' - Workflow',
			'sprint_id' => $s->id,
		]);
		$stages = [ 'Backlog', 'In Progress', 'Done' ];
		foreach (range(0, 2) as $key) {
			WorkflowStage::create([
				'name'        => $stages[ $key ],
				'order'       => $key,
				'workflow_id' => $w->id
			]);
		}


		$tasks = [ ];

		foreach ($sprint['tasks'] as $task) {
			$t      = Task::find($task);
			$wstage = WorkflowStage::where('workflow_id', '=', $w->id)->where('order', '=', 'o')->first();
			$t->workflowStage()->associate($wstage);
			array_push($tasks, $t);
		}

		$s->tasks()->saveMany($tasks);

	}

	/**
	 * Get all workflows
	 *
	 * @return mixed
	 */
	public function getWorkflows()
	{
		return Workflow::all();
	}

	/**
	 * Get all stages of the workflow
	 *
	 * @param $workflowId
	 *
	 * @return mixed
	 */
	public function getWorkflowStages( $workflowId )
	{
		$stages                                    = Workflow::find($workflowId)->stages()->with('tasks')->get()->toArray();
		$stages[ (count($stages) - 1) ]['is_last'] = true;

		return $stages;
	}

	/**
	 * Get a single workflow stage
	 *
	 * @param $workflowStageId
	 *
	 * @return mixed
	 */
	public function getWorkflowStageById( $workflowStageId )
	{
		$stage     = WorkflowStage::find($workflowStageId)->toArray();
		$allStages = $this->getWorkflowStages($stage['workflow_id']);
		foreach ($allStages as $as) {
			if ($as['id'] == $stage['id']) {
				return $as;
			}
		}

		return $stage;

	}
}