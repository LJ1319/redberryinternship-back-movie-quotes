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
			'username'  => 'test',
			'email'     => 'test@test.com',
			'password'  => '11111111',
		]);
	}
}