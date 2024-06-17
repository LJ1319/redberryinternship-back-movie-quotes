<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		User::factory()->create([
			'username'  => 'test1',
			'email'     => 'test1@test.com',
			'password'  => '11111111',
		]);

		User::factory()->create([
			'username'  => 'test2',
			'email'     => 'test2@test.com',
			'password'  => '22222222',
		]);
	}
}
