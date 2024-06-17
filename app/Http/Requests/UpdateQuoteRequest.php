<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuoteRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
	 */
	public function rules(): array
	{
		return [
			'title.en'  => ['required', 'regex:/^([\w\:-]+\s)*[\w\:-]+$/'],
			'title.ka'  => ['required', 'regex:/^([ა-ჰ0-9\:_-]+\s)*[ა-ჰ0-9\:_-]+$/'],
			'image'     => ['image'],
		];
	}
}
