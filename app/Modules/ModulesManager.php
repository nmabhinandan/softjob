<?php  namespace Softjob\Modules;


use Softjob\Contracts\Modules\ExposesSidebarItems;

class ModulesManager {

	protected $modules = [
		'User',
	    'Project'
	];

	public function boot( )
	{
		$this->registerPermissions();
	}


	/**
	 * Aggrigate all sidebar items and provide
	 *
	 * @return array
	 */
	public function getSideBarItems( )
	{
		$sideBarItems = array();
		foreach($this->modules as $module) {
			$moduleInstance = $this->getModuleInstance($module);
			if(in_array('Softjob\Contracts\Modules\ExposesSidebarItems', class_implements($moduleInstance))) {
				$sideBarItems[] = $this->cleanSidebarItems($moduleInstance->sideBarItems());
			}
		}
		return $sideBarItems;
	}

	/**
	 * Clean the sidebar items
	 *
	 * @param $arr
	 * @return mixed
	 */
	function cleanSidebarItems($arr) {
		$newArr = [];
		foreach($arr as $key => $value) {
			if(is_array($value)) {
				$newArr[strip_tags($key)] = cleanArr($value);
			} else {
				$newArr[strip_tags($key)] = strip_tags($value);
			}
		}
		return $newArr;
	}


	/**
	 * Get all the permissions from the modules
	 */
	private function registerPermissions()
	{
		foreach($this->modules as $module) {
			$moduleInstance = $this->getModuleInstance( $module );
			$permissions = $moduleInstance->setPermissions();
			$this->actuallyRegisterPermissions( $permissions );
		}
	}

	/**
	 * Register the permissions to the db
	 *
	 * @param $permissions
	 */
	private function actuallyRegisterPermissions( $permissions )
	{
		$repo = \App::make('\Softjob\Contracts\Repositories\PermissionsReoInterface');
		if ( is_array( $permissions ) ) {
			foreach ( $permissions as $permission ) {
				$repo->createOrUpdatePermission($permission);
			}
		} else {
			$repo->createOrUpdatePermission($permissions);
		}
	}

	/**
	 * @param $module
	 *
	 * @return mixed
	 */
	private function getModuleInstance( $module )
	{
		$klass = __NAMESPACE__ . '\\' . $module . 's' . '\\' . $module . 'Module';
		$moduleInstance = new $klass;

		return $moduleInstance;
	}
}