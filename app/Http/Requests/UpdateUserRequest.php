<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
	 */
	public function rules(): array
	{
		return [
			'avatar'   => ['nullable', 'image'],
			'username' => ['nullable', 'min:3', 'max:15', 'regex:/^[a-z0-9]+$/i', 'unique:users,username'],
			'email'    => ['nullable', 'email', 'unique:users,email'],
			'password' => ['nullable', 'min:8', 'max:15', 'regex:/^[a-z0-9]+$/i', 'confirmed'],
		];
	}
}
