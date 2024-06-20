<?php

namespace Database\Factories;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quote>
 */
class QuoteFactory extends Factory
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
			'movie_id'     => Movie::inRandomOrder()->first()->id,
			'title'        => [
				'en' => fake()->sentence(),
				'ka' => fake('ka_GE')->realTextBetween(25, 50, 2),
			],
		];
	}
}
