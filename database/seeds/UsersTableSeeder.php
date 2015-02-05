<?php

// Composer: "fzaninotto/faker": "v1.4.0"
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();
		DB::table('users')->delete();
		$organization = new Softjob\Organization;
		$organizationIds = $organization->lists('id');
		foreach(range(1, 20) as $index) {
			Softjob\User::create([
				'id' => $index,
				'organization_id' => 1,
				'email' => $faker->email,
			    'username' => $faker->userName,
			    'password' => Hash::make('protected'),
			    'first_name' => $faker->firstName,
			    'last_name' => $faker->lastName,
			    'avatar' => 'default.jpg'
			]);
		}
		Softjob\User::create([
			'id' => 21,
			'organization_id' => 1,
			'email' => 'nmabhinandan@gmail.com',
			'username' => 'nmabhinandan',
			'password' => Hash::make('protected'),
			'first_name' => 'Abhinandan',
		    'last_name' => 'NM',
		    'avatar' => 'default.jpg'
		]);
	}
}
