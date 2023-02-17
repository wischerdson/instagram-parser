<?php

namespace Database\Factories;

use App\Models\Mailing;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
	protected $model = Mailing::class;

	public function definition()
	{
		$rPauseMin = fake()->numberBetween(10, 60);

		return [
			'name' => fake()->sentence(3),
			'keywords' => implode(', ', fake()->words(4)),
			'message_body' => fake()->realText(),
			'attachment_path' => null,// fake()->image(null, 640, 480),
			'active' => fake()->boolean(),
			'active_time' => '0 8 * * *:0 17 * * *',
			'random_pause' => $rPauseMin . ':' . fake()->numberBetween($rPauseMin + 1, 300),
		];
	}
}
