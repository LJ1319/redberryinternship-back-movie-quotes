<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('{locale}')->middleware('localization')->group(function () {
	Route::middleware('guest')->group(function () {
		Route::controller(AuthController::class)->group(function () {
			Route::post('/signup', 'signup')->name('signup');
			Route::post('/login', 'login')->name('login');
		});

		Route::group(
			['controller' => EmailVerificationController::class, 'prefix' => 'email', 'as' => 'verification.'],
			function () {
				Route::get('/verify/{id}/{hash}', 'verify')->middleware('signed')->name('verify');
				Route::post('/verification-notification', 'resend')->middleware('throttle:6,1')->name('send');
			}
		);

		Route::group(
			['controller' => PasswordResetController::class, 'as' => 'password.'],
			function () {
				Route::post('/forgot-password', 'forgot')->name('email');
				Route::post('/reset-password', 'reset')->name('reset');
			}
		);

		Route::group(
			['controller' => GoogleAuthController::class, 'prefix' => 'auth/google', 'as' => 'auth.google.'],
			function () {
				Route::get('redirect', 'redirect')->name('redirect');
				Route::get('callback', 'callback')->name('callback');
			}
		);
	});

	Route::middleware('auth:sanctum')->group(function () {
		Route::controller(UserController::class)->name('user.')->group(function () {
			Route::get('/user', 'get')->name('get');
			Route::patch('/users/{user}', 'update')->name('update');
		});

		Route::group(
			['controller' => GenreController::class, 'prefix' => 'genres', 'as' => 'genres.'],
			function () {
				Route::get('/', 'index')->name('index');
			}
		);

		Route::group(
			['controller' => MovieController::class, 'prefix' => 'movies', 'as' => 'movies.'],
			function () {
				Route::get('/', 'index')->name('index');
				Route::get('/{movie}', 'get')->name('get');
				Route::post('/', 'store')->name('store');
				Route::patch('/{movie}', 'update')->name('update');
				Route::delete('/{movie}', 'destroy')->name('destroy');
			}
		);

		Route::group(
			['controller' => QuoteController::class, 'prefix' => 'quotes', 'as' => 'quotes.'],
			function () {
				Route::get('/', 'index')->name('index');
			}
		);

		Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
	});
});
