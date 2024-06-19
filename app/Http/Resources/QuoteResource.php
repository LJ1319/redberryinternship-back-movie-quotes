<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuoteResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id'                  => $this->id,
			'title'               => $this->title,
			'image'               => $this->getFirstMediaUrl(),
			'username'            => $this->user->username,
			'user_avatar'         => $this->user->getFirstMediaUrl(),
			'movie_title'         => $this->movie->title,
			'movie_year'          => $this->movie->year,
			'likes'               => $this->likes->count(),
			'isLiked'             => $this->isLiked(),
			'comments'            => CommentResource::collection($this->comments->sortByDesc('created_at')),
			'translations'        => $this->translations,
		];
	}
}
