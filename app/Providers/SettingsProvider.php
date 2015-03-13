<?php namespace Softjob\Providers;

use Illuminate\Support\ServiceProvider;
use Softjob\Services\SettingsService;

class SettingsProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		if(! $this->app->runningInConsole()) {
			$settingService = new SettingsService();
			$settingService->initialize();
		}
		
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

}
