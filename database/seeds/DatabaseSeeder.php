<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$seeds = [
			'OrganizationTableSeeder',
			'TagsTableSeeder',
			'RoleTableSeeder',
		    'UserTableSeeder',
		    'ProjectsTableSeeder',
		    'TasksTableSeeder',
		    'SprintsTableSeeder',
		    'WorkflowsTableSeeder',
		    'WorkflowStagesTableSeeder'
		];

		foreach($seeds as $seed) {
			$this->call($seed);
		}
	}
}
