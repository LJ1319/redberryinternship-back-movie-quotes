<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Movie;
use App\Models\Quote;
use Illuminate\Database\Seeder;

class MovieQuoteSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$genres = Genre::all();

		$movies = Movie::factory(10)->create();
		$movies->each(function (Movie $movie) use ($genres) {
			$movie->genres()->attach(
				$genres->random(rand(1, $genres->count()))->pluck('id')->toArray()
			);
		});

		Quote::factory(30)->create();
	}
}
