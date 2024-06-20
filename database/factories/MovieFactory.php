<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'user_id'      => User::inRandomOrder()->first()->id,
			'title'        => [
				'en' => fake()->sentence(),
				'ka' => fake('ka_GE')->realTextBetween(25, 50, 2),
			],
			'year'             => fake()->year(),
			'directors'        => [
				'en' => fake()->name(),
				'ka' => fake('ka_GE')->name(),
			],
			'description' => [
				'en' => fake()->paragraphs(3, true),
				'ka' => fake('ka_GE')->realTextBetween(200, 400),
			],
		];
	}
}
