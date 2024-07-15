<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Quote;
use App\Notifications\QuoteInteracted;
use Illuminate\Http\JsonResponse;

class QuoteCommentController extends Controller
{
	public function store(string $locale, Quote $quote, StoreCommentRequest $request): JsonResponse
	{
		$comment = $quote->comments()->create([
			'user_id' => auth()->id(),
			'body'    => $request->validated()['body'],
		]);

		if ($comment->user_id !== $quote->user_id) {
			$quote->user->notify(
				new QuoteInteracted(
					'comment',
					$quote->id,
					$quote->user_id,
					$comment->user->username,
					$comment->user->getFirstMediaUrl()
				)
			);
		}

		return response()->json(['message' => 'Comment created successfully'], 201);
	}
}
