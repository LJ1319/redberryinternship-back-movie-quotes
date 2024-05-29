<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class PasswordForgot extends Mailable implements ShouldQueue
{
	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 */
	public function __construct(public User $user, public string $token, public $locale)
	{
	}

	/**
	 * Get the message envelope.
	 */
	public function envelope(): Envelope
	{
		return new Envelope(
			subject: 'Password reset requested',
		);
	}

	/**
	 * Get the message content definition.
	 */
	public function content(): Content
	{
		$away = config('app.frontend_url') . '/' . $this->locale;

		$name = 'password.reset';
		$expiration = now()->addMinutes(Config::get('auth.passwords.users.expire', 120));
		$email = $this->user->email;

		$resetUrl = URL::temporarySignedRoute(
			$name,
			$expiration,
			[
				'locale' => $this->locale,
			]
		);

		return new Content(
			markdown: 'mail.password-reset',
			with: [
				'username'     => $this->user->username,
				'away'         => $away,
				'expiration'   => $expiration,
				'resetUrl'     => $resetUrl,
				'token'        => $this->token,
				'email'        => $email,
			]
		);
	}

	/**
	 * Get the attachments for the message.
	 *
	 * @return array<int, \Illuminate\Mail\Mailables\Attachment>
	 */
	public function attachments(): array
	{
		return [];
	}
}
