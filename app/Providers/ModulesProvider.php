<?php namespace Softjob\Providers;

use Illuminate\Support\ServiceProvider;
use Softjob\Modules\ModulesManager;

class ModulesProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @param ModulesManager $manager
	 */
	public function boot( ModulesManager $manager )
	{
		if(! $this->app->runningInConsole()) {
			$manager->boot();
		}
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register() {

	}
}
