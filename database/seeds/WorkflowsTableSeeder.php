<?php

use Illuminate\Database\Seeder;
use Softjob\Workflow;

class WorkflowsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker\Factory::create();

		foreach (range(1, 14) as $index) {
			Workflow::create([
				'id' => $index,
				'name' => $faker->word,
			    'sprint_id' => $index
			]);
		}
	}
}