<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteRequest;
use App\Http\Requests\UpdateQuoteRequest;
use App\Http\Resources\QuoteResource;
use App\Models\Quote;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class QuoteController extends Controller
{
	public function index(): AnonymousResourceCollection
	{
		$quotes = Quote::with(['media', 'user', 'movie', 'likes', 'comments', 'comments.user'])
						->latest()->paginate(10);

		return QuoteResource::collection($quotes);
	}

	public function get(string $locale, Quote $quote): QuoteResource
	{
		$quote->load(
			'media',
			'user',
			'movie',
			'likes',
			'comments',
			'comments.user'
		);

		return new QuoteResource($quote);
	}

	public function store(string $locale, StoreQuoteRequest $request): JsonResponse
	{
		$validated = $request->validated();

		$quote = Quote::create([
			'user_id'  => auth()->id(),
			'movie_id' => $validated['movie_id'],
			'title'    => $validated['title'],
		]);

		$this->associateImage($quote, $validated['image']->store());

		return response()->json(['message' =>'Quote added successfully'], 201);
	}

	public function update(string $locale, Quote $quote, UpdateQuoteRequest $request): JsonResponse
	{
		$validated = $request->validated();
		$quote->update($validated);

		if (isset($validated['image'])) {
			$this->associateImage($quote, $validated['image']->store());
		}

		return response()->json(['message' => 'Quote updated successfully']);
	}

	public function destroy(string $locale, Quote $quote): JsonResponse
	{
		$quote->likes()->delete();
		$quote->comments()->delete();
		$quote->delete();

		return response()->json(['message' =>'Quote deleted successfully']);
	}

	private function associateImage(Quote $quote, string $path): void
	{
		$quote->clearMediaCollection();
		$quote->addMedia(storage_path('app/' . $path))->toMediaCollection();
	}
}
