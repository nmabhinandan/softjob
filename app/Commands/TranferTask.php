<?php namespace Softjob\Commands;

use Softjob\Commands\Command;

class TranferTask extends Command {

	/**
	 * @var
	 */
	public $data;

	/**
	 * Create a new command instance.
	 *
	 * @param $data
	 */
	public function __construct($data)
	{
		$this->data = $data;
	}

}
