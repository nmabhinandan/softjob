<?php  namespace Softjob\Providers;


use Illuminate\Support\ServiceProvider;

class RepoServiceProvider extends ServiceProvider{

	public function register()
	{

		$repositories = [
			'Setting',
			'User',
		    'Permission',
		    'Project',
		    'Task',
		    'Sprint',
			'Product',
			'Issue',
		    'Role',
		    'Group'
		];

		foreach($repositories as $repo) {
			$this->app->bind(
				'\Softjob\Contracts\Repositories\\' . $repo . 'RepoInterface',
				'\Softjob\Repositories\Eloquent' . $repo . 'Repo'
			);
		}

//		$this->app->bind(
//			'\Softjob\Contracts\Repositories\UserRepoInterface',
//			'\Softjob\Repositories\EloquentUserRepo'
//		);
//
//		$this->app->bind(
//			'\Softjob\Contracts\Repositories\PermissionsReoInterface',
//			'\Softjob\Repositories\EloquentPermissionRepo'
//		);
//
//		$this->app->bind(
//			'\Softjob\Contracts\Repositories\ProjectRepoInterface',
//			'\Softjob\Repositories\EloquentProjectRepo'
//		);
//
//		$this->app->bind(
//			'\Softjob\Contracts\Repositories\TasksRepoInterface',
//			'\Softjob\Repositories\EloquentTaskProjectRepo'
//		);
//
//		$this->app->bind(
//			'\Softjob\Contracts\Repositories\SprintsRepoInterface',
//			'\Softjob\Repositories\EloquentSprintRepo'
//		);
	}
}