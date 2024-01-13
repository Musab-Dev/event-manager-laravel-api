<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EventRemainderNotificaiton extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public User $user,
        public Event $event
    )
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Remainder: You have an upcoming event!')
                    ->greeting("Hello {$this->user->name},")
                    ->line('You have an event to attend in the next 24 hours.')
                    ->action('View Event Details', route('events.show', ['event' => $this->event->id]))
                    ->line("The event {$this->event->name} will start at {$this->event->start_date}")
                    ->line('See you there!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'event_id' => $this->event->id,
            'event_name' => $this->event->name,
            'event_start_date' => $this->event->start_date,
        ];
    }
}
