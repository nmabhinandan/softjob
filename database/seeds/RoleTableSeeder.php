<?php

use Illuminate\Database\Seeder;
use Softjob\Role;

class RoleTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker\Factory::create();

		foreach (range(1, 4) as $id) {
			Role::create([
				'id' => $id,
			    'name' => $faker->word,
			    'description' => $faker->text()
			]);
		}

	}
}