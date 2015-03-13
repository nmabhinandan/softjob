<?php namespace Softjob\Contracts\Repositories;

interface SettingRepoInterface {

	/**
	 * Get setting stored in db
	 *
	 * @param $setting
	 *
	 * @return mixed
	 */
	public function get($setting);

	/**
	 * Set setting in db
	 *
	 * @param $data
	 *
	 * @return mixed
	 */
	public function set($data);

}