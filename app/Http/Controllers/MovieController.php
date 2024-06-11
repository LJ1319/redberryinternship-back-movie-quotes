<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Models\Movie;

class MovieController extends Controller
{
	public function index()
	{
	}

	public function get()
	{
	}

	public function store(string $locale, StoreMovieRequest $request)
	{
		$validated = $request->validated();

		$movie = Movie::create([
			'user_id'            => auth()->id(),
			'title'              => $validated['title'],
			'year'               => $validated['year'],
			'directors'          => $validated['directors'],
			'description'        => $validated['description'],
		]);

		$path = $validated['image']->store();
		$movie->clearMediaCollection();
		$movie->addMedia(storage_path('app/' . $path))->toMediaCollection();

		return $validated;
	}

	public function update(string $locale, Movie $movie, UpdateMovieRequest $request)
	{
	}
}
