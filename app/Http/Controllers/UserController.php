<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
			$imageName = $this->processImage($request['avatar']);
			$user->clearMediaCollection();
			$user->addMedia(storage_path('app/public/' . $imageName))->toMediaCollection();
		}

		return new UserResource($user);
	}

	private function processImage(string $image_64): string
	{
		$extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
		$replace = substr($image_64, 0, strpos($image_64, ',') + 1);
		$image = str_replace($replace, '', $image_64);
		$image = str_replace(' ', '+', $image);
		$imageName = Str::random(10) . '.' . $extension;
		Storage::disk('public')->put($imageName, base64_decode($image));

		return $imageName;
	}
}
