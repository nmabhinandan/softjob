<?php namespace Softjob\Http\Controllers;

use Illuminate\Http\Response;
use Softjob\Commands\TranferTask;
use Softjob\Contracts\Repositories\TaskRepoInterface;
use Softjob\Http\Requests;
use Softjob\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Softjob\Http\Requests\CreateTaskRequest;
use Softjob\Http\Requests\TranferTaskRequest;

class TaskController extends Controller {

	/**
	 * @var TaskRepoInterface
	 */
	private $taskRepo;

	/**
	 * @param TaskRepoInterface $taskRepo
	 */
	function __construct(TaskRepoInterface $taskRepo)
	{
		$this->taskRepo = $taskRepo;
	}


	/**
	 * @param CreateTaskRequest $request
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
	public function createTask(CreateTaskRequest $request)
	{
		try {
			$this->taskRepo->createTask($request->all());
		} catch (\Exception $e) {
			return Response::create([
				'status' => 'error',
			    'message' => 'Server problem'
			], 500);
		}
	}

	/**
	 * @param TranferTaskRequest $request
	 *
	 * @return mixed
	 */
	public function tranferTask( TranferTaskRequest $request)
	{
		return $this->dispatch(new TranferTask($request->all()));
	}
}
