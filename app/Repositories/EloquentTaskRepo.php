<?php  namespace Softjob\Repositories;


use Softjob\Contracts\Repositories\TaskRepoInterface;
use Softjob\Task;

class EloquentTaskRepo implements TaskRepoInterface {

	/**
	 * @var Task
	 */
	private $model;


	/**
	 * @param Task $model
	 *
	 * @internal param Task $task
	 */
	function __construct(Task $model)
	{
		$this->model = $model;
	}

	public function createTask( $task )
	{
		$this->model->create($task);
	}
}