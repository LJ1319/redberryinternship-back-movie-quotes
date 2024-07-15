<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id'            => $this->id,
			'type'          => $this->type,
			'interaction'   => $this->data['interaction'],
			'quote_id'      => $this->data['quote_id'],
			'username'      => $this->data['username'],
			'user_avatar'   => $this->data['user_avatar'],
			'read_at'       => $this->read_at,
			'interacted_at' => $this->created_at->diffForHumans(),
		];
	}
}
