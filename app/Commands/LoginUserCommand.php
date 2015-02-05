<?php namespace Softjob\Commands;

use Softjob\Commands\Command;

class LoginUserCommand extends Command {

	public $username;
	public $password;

	/**
	 * Create a new command instance.
	 *
	 * @param $username
	 * @param $password
	 */
	public function __construct($username, $password)
	{
		$this->username = $username;
		$this->password = $password;
	}

}
