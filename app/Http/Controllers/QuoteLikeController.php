<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;

class QuoteLikeController extends Controller
{
	public function store(string $locale, Quote $quote): JsonResponse
	{
		if (!$quote->isLiked()) {
			$quote->likes()->create([
				'user_id' => auth()->id(),
			]);
		}

		return response()->json(['message' => 'Liked quote successfully'], 201);
	}

	public function destroy(string $locale, Quote $quote): JsonResponse
	{
		if ($quote->isLiked()) {
			$like = Like::where('user_id', auth()->id())
					->where('likeable_type', Quote::class)
					->where('likeable_id', $quote->id)
					->first();

			$like->delete();
		}

		return response()->json(['message' => 'Unliked quote successfully']);
	}
}
