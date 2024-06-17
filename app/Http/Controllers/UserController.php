<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
	public function get(Request $request): UserResource
	{
		return new UserResource($request->user());
	}

	public function update(string $locale, User $user, UpdateUserRequest $request): UserResource
	{
		$validated = $request->validated();
		$user->update($validated);

		if (isset($validated['avatar'])) {
			$path = $validated['avatar']->store();
			$user->clearMediaCollection();
			$user->addMedia(storage_path('app/' . $path))->toMediaCollection();
		}

		return new UserResource($user);
	}
}
