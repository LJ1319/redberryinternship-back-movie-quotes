<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NotificationController extends Controller
{
	public function index(): AnonymousResourceCollection
	{
		$notifications = auth()->user()->notifications;

		return NotificationResource::collection($notifications);
	}

	public function update(): JsonResponse
	{
		auth()->user()->unreadNotifications->markAsRead();

		return response()->json(['message' => 'Notifications marked as read successfully']);
	}
}
