<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Movie extends Model implements HasMedia
{
	use HasFactory;

	use HasTranslations;

	use InteractsWithMedia;

	protected $guarded = ['id'];

	public array $translatable = ['title', 'directors', 'description'];

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	public function genres(): BelongsToMany
	{
		return $this->belongsToMany(Genre::class)->withTimestamps();
	}

	public function quotes(): HasMany
	{
		return $this->hasMany(Quote::class);
	}

	public function scopeOwner(Builder $query): void
	{
		$query->where('user_id', auth()->id());
	}
}
