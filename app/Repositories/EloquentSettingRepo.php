<?php  namespace Softjob\Repositories;


use Softjob\Contracts\Repositories\SettingRepoInterface;
use Softjob\Services\AuthService;
use Softjob\Setting;
use Softjob\User;

class EloquentSettingRepo implements SettingRepoInterface {

	/**
	 * @var Setting
	 */
	private $setting;

	/**
	 * @param Setting $setting
	 */
	function __construct(Setting $setting)
	{
		$this->setting = $setting;
	}


	/**
	 * Get setting stored in db
	 *
	 * @param $setting
	 *
	 * @return mixed
	 */
	public function get( $setting )
	{
		return $this->setting->where('name', '=', $setting)->get();
	}

	/**
	 * Set setting in db
	 *
	 * @param $data
	 *
	 * @return mixed
	 */
	public function set( $data )
	{
		$this->setting->updateOrCreate([
			'name' => $data['setting'],
		    'value' => $data['value'],
		    'organization_id' => User::find(AuthService::$loggedInUser)->toArray()['organization_id']
		]);
	}
}