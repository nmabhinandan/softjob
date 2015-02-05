<?php namespace Softjob\Handlers\Commands;

use Softjob\Commands\GetSidebarItems;

use Illuminate\Queue\InteractsWithQueue;
use Softjob\Modules\ModulesManager;

class GetSidebarItemsHandler {

	/**
	 * @var ModulesManager
	 */
	private $manager;

	/**
	 * Create the command handler.
	 *
	 * @param ModulesManager $manager
	 */
	public function __construct(ModulesManager $manager)
	{
		$this->manager = $manager;
	}

	/**
	 * Handle the command.
	 *
	 * @param  GetSidebarItems  $command
	 * @return void
	 */
	public function handle(GetSidebarItems $command)
	{
		return $this->manager->getSideBarItems();
	}

}
