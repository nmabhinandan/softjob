<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class OrganizationTableSeeder extends Seeder {

	public function run( )
	{
		$faker = Faker::create();
		DB::table('organizations')->delete();
		Softjob\Organization::create([
			'id'    => 1,
			'name'  => 'Organization One',
			'slug'  => 'org1',
			'email' => null,
			'logo'  => 'default'
		]);
	}

}