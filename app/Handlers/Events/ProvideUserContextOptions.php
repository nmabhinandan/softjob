<?php namespace Softjob\Handlers\Events;

use Softjob\Events\UserContextOptionsRequested;
use Softjob\Modules\ModulesManager;

class ProvideUserContextOptions {

	/**
	 * @var ModulesManager
	 */
	private $moduleManager;

	/**
	 * Create the event handler.
	 *
	 * @param ModulesManager $moduleManager
	 */
	public function __construct( ModulesManager $moduleManager ) {

		$this->moduleManager = $moduleManager;
	}

	/**
	 * Handle the event.
	 *
	 * @param  UserContextOptionsRequested $event
	 *
	 * @return void
	 */
	public function handle( $event ) {

		$this->moduleManager->getSideBarItems();
	}

	private function getOptionsFromKlass( $klass, $userId ) {

		$obj = new $klass;

		return call_user_func_array( [ $obj, 'userContextOptions' ], [ $userId ] );
	}

}
