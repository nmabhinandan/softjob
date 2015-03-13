<?php  namespace Softjob\Services;

use Softjob\Setting;
use Softjob\User;

class SettingsService {

	/**
	 * Get setting value
	 *
	 * @param $setting
	 *
	 * @return mixed
	 */
	public static function get($setting)
	{
		return \Config::get($setting);
	}

	/**
	 *  Initialize config values from settings table
	 */
	public function initialize()
	{
		$this->setting->all()->each(function($setting) {
			\Config::set($setting->name, $setting->value);
		});
	}

}