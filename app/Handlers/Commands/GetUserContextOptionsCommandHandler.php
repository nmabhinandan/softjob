<?php namespace Softjob\Handlers\Commands;

use Event;
use Softjob\Commands\GetUserContextOptionsCommand;

use Illuminate\Queue\InteractsWithQueue;
use Softjob\Events\UserContextOptionsRequested;
use Softjob\Repositories\UserRepoInterface;

class GetUserContextOptionsCommandHandler {

	/**
	 * @var UserRepoInterface
	 */

	/**
	 * Create the command handler.
	 *
	 */
	public function __construct()
	{

	}

	/**
	 * Handle the command.
	 *
	 * @param  GetUserContextOptionsCommand  $command
	 * @return array
	 */
	public function handle(GetUserContextOptionsCommand $command)
	{
		$options = Event::fire(new UserContextOptionsRequested($command->userId));
		return $this->normalize( $options );
	}

	/**
	 * @param $arr
	 *
	 * @return array
	 */
	private function normalize($arr)
	{
		$normalized = array();
		foreach($arr as $items) {
			foreach($items as $item) {
				$normalized[] = $this->clean($item);
			}
		}
		return $normalized;
	}

	/**
	 * @param $option
	 *
	 * @return array
	 */
	private function clean($option)
	{
		return array_map( function($item) {
			return strip_tags( $item );
		}, $option );
	}
}
