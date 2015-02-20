<?php

use Illuminate\Database\Seeder;
use Softjob\WorkflowStage;

class WorkflowStagesTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker\Factory::create();
		$workflowId = 1;
		foreach(range(1,14) as $index) {
			WorkflowStage::create([
				'id' => $index,
				'name' => $faker->word,
				'workflow_id' => $workflowId,
				'order' => 0
			]);
			$workflowId++;
		}
		$workflowId = 1;
		foreach(range(15,28) as $index) {
			WorkflowStage::create([
				'id' => $index,
				'name' => $faker->word,
				'workflow_id' => $workflowId,
				'order' => 1
			]);
			$workflowId++;
		}
		$workflowId = 1;
		foreach(range(29,42) as $index) {
			WorkflowStage::create([
				'id' => $index,
				'name' => $faker->word,
				'workflow_id' => $workflowId,
				'order' => 2
			]);
			$workflowId++;
		}
	}
}