<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id'           => $this->id,
			'image'        => $this->getFirstMediaUrl(),
			'title'        => $this->title,
			'year'         => $this->year,
			'genres'       => GenreResource::collection($this->genres),
			'directors'    => $this->directors,
			'description'  => $this->description,
			'quotes'       => QuoteResource::collection($this->quotes->sortByDesc('created_at')),
			'translations' => $this->translations,
		];
	}
}
