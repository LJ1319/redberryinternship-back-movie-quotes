<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Http\Resources\MovieListResource;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class MovieController extends Controller
{
	public function index(): AnonymousResourceCollection
	{
		$movies = Movie::latest()->paginate(10);

		return MovieListResource::collection($movies);
	}

	public function get(string $locale, Movie $movie): MovieResource
	{
		return new MovieResource($movie);
	}

	public function store(string $locale, StoreMovieRequest $request): JsonResponse
	{
		$validated = $request->validated();

		$movie = Movie::create([
			'user_id'            => auth()->id(),
			'title'              => $validated['title'],
			'year'               => $validated['year'],
			'directors'          => $validated['directors'],
			'description'        => $validated['description'],
		]);

		$movie->genres()->attach(collect($validated['genres'])->pluck('id'));
		$this->associateImage($movie, $validated['image']->store());

		return response()->json(['message' => 'Movie added successfully'], 201);
	}

	public function update(string $locale, Movie $movie, UpdateMovieRequest $request)
	{
		$validated = $request->validated();

		$movie->update($validated);
		$movie->genres()->sync(collect($validated['genres'])->pluck('id'));

		if (isset($validated['image'])) {
			$this->associateImage($movie, $validated['image']->store());
		}

		return response()->json(['message' => 'Movie updated successfully']);
	}

	public function destroy(string $locale, Movie $movie): JsonResponse
	{
		$movie->genres()->detach();
		$movie->delete();

		return response()->json(['message' => 'Movie deleted successfully']);
	}

	private function associateImage(Movie $movie, string $path): void
	{
		$movie->clearMediaCollection();
		$movie->addMedia(storage_path('app/' . $path))->toMediaCollection();
	}
}
