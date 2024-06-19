<?php

namespace App\Models;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword, HasMedia
{
	use HasFactory;

	use Notifiable;

	use InteractsWithMedia;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'username',
		'email',
		'email_verified_at',
		'password',
		'google_id',
	];

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array<int, string>
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	 * Get the attributes that should be cast.
	 *
	 * @return array<string, string>
	 */
	protected function casts(): array
	{
		return [
			'email_verified_at' => 'datetime',
			'password'          => 'hashed',
		];
	}

	public function quotes(): HasMany
	{
		return $this->hasMany(Quote::class);
	}

	public function movies(): HasMany
	{
		return $this->hasMany(Movie::class);
	}

	public function likes(): HasMany
	{
		return $this->hasMany(Like::class);
	}

	public function comments(): HasMany
	{
		return $this->hasMany(Comment::class);
	}

	//	public function hasLikedQuote(Quote $quote): bool
	//	{
	//		return
	//			$this->likes->contains('likeable_type', Quote::class) &&
	//			$this->likes->contains('likeable_id', $quote->id);
	//	}
}
