<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VaccinationDueNotification extends Notification
{
    use Queueable;
    private $vaccination;
    /**
     * Create a new notification instance.
     */
    public function __construct($vaccination)
    {
        $this->vaccination = $vaccination;
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
            ->subject('Upcoming Vaccination Due')
            ->line('You have an upcoming vaccination due for ' . $this->vaccination->vaccine->name)
            ->line('Due date: ' . $this->vaccination->next_due_date)
            ->action('Schedule Now', url('/vaccinations/schedule/' . $this->vaccination->id));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
