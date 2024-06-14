<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMovieRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
	 */
	public function rules(): array
	{
		return [
			'title.en'        => ['required', 'regex:/^([\w\:-]+\s)*[\w\:-]+$/'],
			'title.ka'        => ['required', 'regex:/^([ა-ჰ0-9\:_-]+\s)*[ა-ჰ0-9\:_-]+$/'],
			'genres'          => ['required', 'array'],
			'year'            => ['required', 'numeric'],
			'directors.en'    => ['required', 'regex:/^([\w\:-]+\s)*[\w\:-]+$/'],
			'directors.ka'    => ['required', 'regex:/^([ა-ჰ0-9\:_-]+\s)*[ა-ჰ0-9\:_-]+$/'],
			'description.en'  => ['required', 'regex:/^([\w\:-]+\s)*[\w\:-]+$/'],
			'description.ka'  => ['required', 'regex:/^([ა-ჰ0-9\:_-]+\s)*[ა-ჰ0-9\:_-]+$/'],
			'image'           => ['image'],
		];
	}
}
