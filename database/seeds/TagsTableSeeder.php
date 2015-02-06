<?php
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder {

	public function run()
	{
		DB::table('project_tags')->delete();

		$faker  = Faker::create();
//		$colors = [
//			'#F44336',
//			'#E91E63',
//			'#9C27B0',
//			'#673AB7',
//			'#3F51B5',
//			'#2196F3',
//			'#03A9F4',
//			'#00BCD4',
//			'#009688',
//			'#4CAF50',
//			'#8BC34A',
//			'#CDDC39',
//			'#FFEB3B',
//		    '#FFC107',
//		    '#FF9800',
//		    '#FF5722',
//		    '#795548',
//		    '#9E9E9E',
//		    '#607D8B'
//		];

		foreach (range(1, 6) as $index) {
			\Softjob\ProjectTag::create([
				'id' => $index,
			    'name' => $faker->word
			]);
		}
//		DB::table('project_project_tag')->delete();

//		foreach (range(1, 5) as $index) {
//			DB::table('tag_colors')->insert([
//				'id'    => $index,
//				'color' => $faker->randomElement($colors)
//			]);
//		}
//		$colorIds = DB::table('tag_colors')->lists('id');
	}
}