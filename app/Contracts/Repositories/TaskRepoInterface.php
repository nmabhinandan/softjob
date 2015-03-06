<?php namespace Softjob\Contracts\Repositories;

interface TaskRepoInterface {

	public function createTask($task);

	public function findTaskById($taskId);
}