<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Quote;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		Quote::all()->each(fn () => Comment::factory(rand(2, 5))->create());
	}
}
