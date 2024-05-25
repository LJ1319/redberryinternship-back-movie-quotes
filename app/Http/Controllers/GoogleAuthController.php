<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
	public function redirect(): string
	{
		return Socialite::driver('google')->stateless()->redirect()->getTargetUrl();
	}

	public function callback(): JsonResponse
	{
		$googleUser = Socialite::driver('google')->stateless()->user();

		$user = User::updateOrCreate(
			['google_id' => $googleUser->id],
			[
				'username'          => $googleUser->name,
				'email'             => $googleUser->email,
				'password'          => Str::password(8),
				'email_verified_at' => now(),
			]
		);

		Auth::login($user);

		return response()->json(['message' => 'Google Auth Successful']);
	}
}
