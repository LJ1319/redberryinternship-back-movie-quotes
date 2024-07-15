<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Quote;
use App\Notifications\QuoteInteracted;
use Illuminate\Http\JsonResponse;

class QuoteLikeController extends Controller
{
	public function store(string $locale, Quote $quote): JsonResponse
	{
		if (!$quote->isLiked()) {
			$like = $quote->likes()->create([
				'user_id' => auth()->id(),
			]);

			if ($like->user_id !== $quote->user_id) {
				$quote->user->notify(
					new QuoteInteracted(
						'like',
						$quote->id,
						$quote->user_id,
						$like->user->username,
						$like->user->getFirstMediaUrl()
					)
				);
			}
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
