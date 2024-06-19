<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Quote extends Model implements HasMedia
{
	use HasFactory;

	use HasTranslations;

	use InteractsWithMedia;

	protected $guarded = ['id'];

	public array $translatable = ['title'];

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	public function movie(): BelongsTo
	{
		return $this->belongsTo(Movie::class);
	}

	public function likes(): MorphMany
	{
		return $this->morphMany(Like::class, 'likeable');
	}

	public function comments(): MorphMany
	{
		return $this->morphMany(Comment::class, 'commentable');
	}

	public function isLiked(): bool
	{
		return $this->likes()->where('user_id', auth()->id())->exists();
	}
}
