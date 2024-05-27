<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
	public function get(Request $request): UserResource
	{
		return new UserResource($request->user());
	}
}
