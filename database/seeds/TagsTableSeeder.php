<?php
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Softjob\ProjectTag;

class TagsTableSeeder extends Seeder {

	public function run()
	{
		$faker  = Faker::create();
		$colors = [
			'#F44336',
			'#E91E63',
			'#9C27B0',
			'#673AB7',
			'#3F51B5',
			'#2196F3',
			'#03A9F4',
			'#00BCD4',
			'#009688',
			'#4CAF50',
			'#8BC34A',
			'#CDDC39',
			'#FFEB3B',
		    '#FFC107',
		    '#FF9800',
		    '#FF5722',
		    '#795548',
		    '#9E9E9E',
		    '#607D8B'
		];

		DB::table('project_tags')->delete();
		DB::table('project_project_tag')->delete();

		foreach (range(1, 5) as $index) {
			DB::table('tag_colors')->insert([
				'id'    => $index,
				'color' => $faker->randomElement($colors)
			]);
		}
		$colorIds = DB::table('tag_colors')->lists('id');
		foreach (range(1, 5) as $index) {
			ProjectTag::create([
				'id' => $index,
				'name' => $faker->word,
				'color_id' => $faker->randomElement($colorIds)
			]);
		}

	}
}