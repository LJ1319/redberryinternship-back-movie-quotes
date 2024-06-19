<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;

class QuoteCommentController extends Controller
{
	public function store(string $locale, Quote $quote, StoreCommentRequest $request): JsonResponse
	{
		$quote->comments()->create([
			'user_id' => auth()->id(),
			'body'    => $request->validated()['body'],
		]);

		return response()->json(['message' => 'Comment created successfully'], 201);
	}
}
