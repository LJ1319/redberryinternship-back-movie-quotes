<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignupUserRequest extends FormRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
	 */
	public function rules(): array
	{
		return [
			'username' => ['required', 'min:3', 'max:15', 'regex:/^[a-z0-9]+$/i', 'unique:users,username'],
			'email'    => ['required', 'email', 'unique:users,email'],
			'password' => ['required', 'min:8', 'max:15', 'regex:/^[a-z0-9]+$/i', 'confirmed'],
		];
	}
}
