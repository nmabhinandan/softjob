<?php
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Softjob\Project;
use Softjob\ProjectTag;
use Softjob\User;

class ProjectsTableSeeder extends Seeder {

	public function run()
	{

		$faker = Faker::create();
		DB::table('projects')->delete();
		DB::table('project_user')->delete();
		DB::table('project_project_tag')->delete();

		$user    = new User();
		$userIds = $user->lists('id');
		$projectTagIds = ProjectTag::lists('id');
		foreach (range(1, 3) as $index) {
			$project = Project::create([
				'id'                 => $index,
				'name'               => $faker->bs,
				'slug'               => $faker->slug,
				'description'        => $faker->realText(),
				'organization_id'    => 1,
				'owner_type'         => 'user',
				'owner_id'           => $faker->randomElement($userIds),
				'project_manager_id' => $faker->randomElement($userIds),
				'deadline'           => Carbon::now()->addDays($faker->randomElement([ 1, 2, 3, 4 ]))
			]);
			$project->users()->sync($userIds);
			$project->tags()->sync([$index, ($index+1)]);
			$project->save();
		}
		foreach (range(4, 6) as $index) {
			$project = Project::create([
				'id'                 => $index,
				'name'               => $faker->bs,
				'slug'               => $faker->slug,
				'description'        => $faker->realText(),
				'organization_id'    => 1,
				'owner_type'         => 'user',
				'owner_id'           => $faker->randomElement($userIds),
				'project_manager_id' => $faker->randomElement($userIds),
				'deadline'           => Carbon::now()->addDays($faker->randomElement([ 1, 2, 3, 4 ]))
			]);
			$project->users()->sync($userIds);
			$project->tags()->attach($index);
			$project->save();
		}
		$index ++;
		$project = Project::create([
			'id'                 => $index,
			'name'               => $faker->bs,
			'slug'               => $faker->slug,
			'description'        => $faker->realText(),
			'organization_id'    => 1,
			'owner_type'         => 'user',
			'owner_id'           => 21,
			'project_manager_id' => 21,
			'deadline'           => Carbon::now()->addDays($faker->randomElement([ 1, 2, 3, 4 ]))
		]);
		$project->users()->sync($userIds);
		$project->tags()->sync($projectTagIds);
		$project->save();
	}
}