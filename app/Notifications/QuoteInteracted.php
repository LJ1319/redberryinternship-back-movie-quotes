<?php

namespace App\Notifications;

use Illuminate\Broadcasting\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\SerializesModels;

class QuoteInteracted extends Notification implements ShouldQueue, ShouldBroadcast
{
	use Queueable, SerializesModels;

	/**
	 * Create a new notification instance.
	 */
	public function __construct(
		public string $interaction,
		public string $quoteId,
		public string $userId,
		public string $username,
		public string $userAvatar
	) {
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @return array<int, string>
	 */
	public function via(object $notifiable): array
	{
		return ['database', 'broadcast'];
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(object $notifiable): array
	{
		return [
			'interaction'       => $this->interaction,
			'quote_id'          => $this->quoteId,
			'username'          => $this->username,
			'user_avatar'       => $this->userAvatar,
		];
	}

	public function toBroadcast(object $notifiable): BroadcastMessage
	{
		return new BroadcastMessage([
			'interaction'       => $this->interaction,
			'quote_id'          => $this->quoteId,
			'username'          => $this->username,
			'user_avatar'       => $this->userAvatar,
			'interacted_at'     => now()->diffForHumans(),
			'read_at'           => null,
		]);
	}

	/**
	 * Get the channels the notification should broadcast on.
	 *
	 * @return array<int, \Illuminate\Broadcasting\Channel>
	 */
	public function broadcastOn(): array
	{
		return [
			new Channel('quote-interactions' . '.' . $this->userId),
		];
	}

	public function broadcastAs(): string
	{
		return 'quote.interacted';
	}
}
