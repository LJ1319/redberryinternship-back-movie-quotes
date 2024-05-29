<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Localization
{
	/**
	 * Handle an incoming request.
	 *
	 * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
	 */
	public function handle(Request $request, Closure $next): Response
	{
		$locale = $request->segment(2);

		if (isset($locale) && in_array($locale, config('app.available_locales'))) {
			app()->setLocale($locale);
		} else {
			$fallback = app()->getFallbackLocale();

			app()->setLocale($fallback);
		}

		return $next($request);
	}
}
