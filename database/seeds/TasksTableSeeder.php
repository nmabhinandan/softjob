<?php

use Illuminate\Database\Seeder;
use Softjob\Task;

class TasksTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker\Factory::create();

		foreach (range(1, 6) as $index) {
			Task::create([
				'id'               => $index,
				'name'             => $faker->word . $index,
				'slug'             => $faker->slug,
				'description'      => $faker->sentence(),
				'project_id'       => $index,
				'complexity_point' => $faker->numberBetween(1, 10),
				'task_status'      => 0
			]);

		}

		foreach(range(7,12) as $index) {
			Task::create([
				'id'               => $index,
				'name'             => $faker->word . $index,
				'slug'             => $faker->slug,
				'description'      => $faker->sentence(),
				'project_id'       => $index-6,
				'complexity_point' => $faker->numberBetween(1, 10),
				'task_status'      => 0
			]);
		}

		foreach (range(13, 18) as $index) {
			Task::create([
				'id'                => $index,
				'name'              => $faker->word . $index,
				'slug'              => $faker->slug,
				'description'       => $faker->sentence(),
				'project_id'        => 7,
				'complexity_point'  => $faker->numberBetween(1, 20),
				'task_status'       => 0
			]);
		}

		foreach(range(19,24) as $index) {
			Task::create([
				'id'                => $index,
				'name'              => $faker->word . $index,
				'slug'              => $faker->slug,
				'description'       => $faker->sentence(),
				'dependent_task_id' => $index-6,
				'project_id'        => 7,
				'complexity_point'  => $faker->numberBetween(1, 20),
				'task_status'       => 0
			]);
		}

		foreach(range(25,31) as $index) {
			Task::create([
				'id'                => $index,
				'name'              => $faker->word . $index,
				'slug'              => $faker->slug,
				'description'       => $faker->sentence(),
				'project_id'        => 7,
				'complexity_point'  => $faker->numberBetween(1, 20),
				'task_status'       => 0
			]);
		}

		foreach(range(32,38) as $index) {
			Task::create([
				'id'                => $index,
				'name'              => $faker->word . $index,
				'slug'              => $faker->slug,
				'description'       => $faker->sentence(),
				'dependent_task_id' => $index-6,
				'project_id'        => 7,
				'complexity_point'  => $faker->numberBetween(1, 20),
				'task_status'       => 0
			]);
		}
	}
}