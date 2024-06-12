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
		$username = $googleUser->name;

		$target = User::where('google_id', $googleUser->id)->first();
		$avatar = null;
		if ($target) {
			$username = $target['username'];
			$avatar = $target->getFirstMedia();
		}

		$user = User::updateOrCreate(
			['google_id' => $googleUser->id],
			[
				'username'          => $username,
				'email'             => $googleUser->email,
				'email_verified_at' => now(),
				'password'          => Str::password(8),
			]
		);

		if (!$avatar) {
			$user->clearMediaCollection();
			$user->addMediaFromUrl($googleUser->avatar_original)
				 ->toMediaCollection();
		}

		Auth::login($user);

		return response()->json(['message' => 'Google Auth Successful']);
	}
}
