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

class UserRegistered extends Mailable implements ShouldQueue
{
	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 */
	public function __construct(public User $user, public $locale)
	{
	}

	/**
	 * Get the message envelope.
	 */
	public function envelope(): Envelope
	{
		return new Envelope(
			subject: 'Please verify your email address',
		);
	}

	/**
	 * Get the message content definition.
	 */
	public function content(): Content
	{
		$away = config('app.frontend_url') . '/' . $this->locale;

		$name = 'verification.verify';
		$expiration = now()->addMinutes(Config::get('auth.verification.expire', 120));
		$id = $this->user->id;
		$email = $this->user->email;
		$hash = sha1($email);

		$verificationUrl = URL::temporarySignedRoute(
			$name,
			$expiration,
			[
				'locale' => $this->locale,
				'id'     => $id,
				'hash'   => $hash,
			]
		);

		return new Content(
			markdown: 'mail.email-verification',
			with: [
				'username'         => $this->user->username,
				'away'             => $away,
				'expiration'       => $expiration,
				'verificationUrl'  => $verificationUrl,
				'email'            => $email,
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
