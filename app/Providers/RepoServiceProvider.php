<?php  namespace Softjob\Providers;


use Illuminate\Support\ServiceProvider;

class RepoServiceProvider extends ServiceProvider{

	public function register()
	{
		$this->app->bind(
			'\Softjob\Contracts\Repositories\UserRepoInterface',
			'\Softjob\Repositories\EloquentUserRepo'
		);

		$this->app->bind(
			'\Softjob\Contracts\Repositories\PermissionsReoInterface',
			'\Softjob\Repositories\EloquentPermissionRepo'
		);

		$this->app->bind(
			'\Softjob\Contracts\Repositories\ProjectsRepoInterface',
			'\Softjob\Repositories\EloquentProjectRepo'
		);

	}
}