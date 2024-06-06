<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
	public function get(Request $request): UserResource
	{
		return new UserResource($request->user());
	}

	public function update(string $locale, string $id, UserUpdateRequest $request): UserResource
	{
		$user = User::findOrFail($id);
		$validated = $request->validated();
		$user->update($validated);

		if (isset($validated['avatar'])) {
			$path = $validated['avatar']->store('public');
			$user->clearMediaCollection();
			$user->addMedia(storage_path('app/' . $path))->toMediaCollection();
		}

		return new UserResource($user);
	}
}
