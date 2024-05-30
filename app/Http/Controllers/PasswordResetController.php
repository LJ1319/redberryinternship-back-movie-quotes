<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordForgotRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\Mail\PasswordForgot;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordResetController extends Controller
{
	public function forgot(PasswordForgotRequest $request): JsonResponse
	{
		$credentials = $request->validated();

		$user = User::whereEmail($credentials['email'])->first();

		if (!$user) {
			return response()->json([
				'message' => __('messages.no_email'),
			], 422);
		}

		$token = Password::createToken($user);
		$locale = app()->getLocale();

		Mail::to($user)->send(new PasswordForgot($user, $token, $locale));

		return response()->json(['message' => 'Password reset link sent']);
	}

	public function reset(PasswordUpdateRequest $request): JsonResponse
	{
		$credentials = $request->validated();

		if (!request()->hasValidSignature()) {
			return response()->json(['message' => 'Invalid password reset link.'], 403);
		}

		$user = User::whereEmail($credentials['email'])->first();

		if (Hash::check($credentials['password'], $user->password)) {
			return response()->json(['message' => __('messages.different_passwords')], 422);
		}

		$status = Password::reset(
			$credentials,
			function ($user, string $password) {
				$user->forceFill([
					'password' => Hash::make($password),
				])->setRememberToken(Str::random(60));

				$user->save();

				event(new PasswordReset($user));
			}
		);

		return $status === Password::PASSWORD_RESET
			? response()->json(['message' => __($status)])
			: response()->json(['message' => __($status)], 422);
	}
}
