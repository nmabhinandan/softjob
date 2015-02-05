<?php namespace Softjob\Events;

use Softjob\Events\Event;
use Illuminate\Queue\SerializesModels;

class UserContextOptionsRequested extends Event {

	use SerializesModels;

	/**
	 * @var
	 */
	public $userId;

	/**
	 * Create a new event instance.
	 *
	 * @param $userId
	 */
	public function __construct($userId)
	{
		$this->userId = $userId;
	}

}
