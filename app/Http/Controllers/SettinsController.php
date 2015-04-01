<?php namespace Softjob\Http\Controllers;

use Softjob\Contracts\Repositories\SettingRepoInterface;
use Softjob\Http\Requests;
use Softjob\Http\Requests\SetSettingsRequest;

class SettinsController extends Controller {

	/**
	 * @var SettingRepoInterface
	 */
	private $settingRepo;


	/**
	 * @param SettingRepoInterface $settingRepo
	 */
	function __construct( SettingRepoInterface $settingRepo )
	{
		$this->settingRepo = $settingRepo;
	}

	public function getSetting( $setting )
	{
		if (is_array($setting)) {

		}
		$validator = \Validator::make([
			'name' => $setting
		], [
			'name' => 'required|string|exists:settings,name'
		]);

		if ($validator->fails()) {
			return \Response::json([
				'status'  => 'error',
				'message' => 'Invalid setting string'
			], 404);
		}

		return $this->settingRepo->get($setting);
	}

	public function setSetting( SetSettingsRequest $request )
	{
		$this->settingRepo->set($request->all());
	}
}
