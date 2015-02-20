<?php

use Illuminate\Database\Seeder;
use Softjob\Sprint;

class SprintsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker\Factory::create();

		foreach(range(1,7) as $index) {
			Sprint::create([
				'id' => $index,
			    'name' => $faker->word . 'SprintCycle',
			    'project_id' => $index,
			]);
			Sprint::create([
				'id' => $index + 7,
				'name' => $faker->word . 'SprintCycle',
				'project_id' => $index,
			]);
		}
		foreach (range(13,24) as $taskId) {
			$task = \Softjob\Task::find($taskId);
			Sprint::find(7)->tasks()->save($task);
		}

		foreach (range(25,30
		) as $taskId) {
			$task = \Softjob\Task::find($taskId);
			Sprint::find(14)->tasks()->save($task);
		}

	}
}