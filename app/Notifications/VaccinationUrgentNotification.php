<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VaccinationUrgentNotification extends Notification
{
    use Queueable;
    private $vaccination;

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
            ->subject('URGENT: Critical Vaccination Overdue')
            ->line('URGENT: Your vaccination for ' . $this->vaccination->vaccine->name . ' is critically overdue')
            ->line('Was due on: ' . $this->vaccination->next_due_date)
            ->line('Days overdue: ' . $this->vaccination->days_overdue)
            ->line('Please contact your healthcare provider immediately')
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
