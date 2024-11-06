<?php

namespace App\Notifications;

use App\Models\Vaccination;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\VonageMessage;

class VaccinationScheduledNotification extends Notification implements ShouldQueue
{
    use Queueable;
    protected $vaccination;
    /**
     * Create a new notification instance.
     */
    public function __construct(Vaccination $vaccination)
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
        $channels = ['database', 'mail'];
        
        // Add SMS notification if phone number exists
        if ($notifiable->phone_number) {
            $channels[] = 'vonage';
        }

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $location = $this->vaccination->location;
        $appointmentDate = $this->vaccination->appointment_date;

        return (new MailMessage)
            ->subject('Vaccination Appointment Scheduled')
            ->greeting('Hello ' . $notifiable->first_name)
            ->line('Your vaccination appointment has been scheduled successfully.')
            ->line('Details:')
            ->line('Vaccine: ' . $this->vaccination->vaccine->name)
            ->line('Date: ' . $appointmentDate->format('l, F j, Y'))
            ->line('Time: ' . $appointmentDate->format('g:i A'))
            ->line('Location: ' . $location->name)
            ->line('Address: ' . $location->address)
            ->line('Important Instructions:')
            ->line('- Please arrive 10 minutes before your appointment')
            ->line('- Bring a valid ID and insurance card (if applicable)')
            ->line('- Wear a mask and maintain social distancing')
            ->action('View Appointment Details', url('/vaccinations'))
            ->line('Need to reschedule? Please contact us at least 24 hours before your appointment.');

    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toVonage($notifiable)
    {
        $appointmentDate = $this->vaccination->appointment_date;
        
        return (new VonageMessage)
            ->content('Your vaccination appointment for ' . 
                     $this->vaccination->vaccine->name . 
                     ' is scheduled for ' . 
                     $appointmentDate->format('M j, Y \a\t g:i A') . 
                     ' at ' . 
                     $this->vaccination->location->name);
    }

    public function toArray($notifiable)
    {
        $appointmentDate = $this->vaccination->appointment_date;
        
        return [
            'type' => 'vaccination_scheduled',
            'vaccination_id' => $this->vaccination->id,
            'vaccine_name' => $this->vaccination->vaccine->name,
            'appointment_date' => $appointmentDate->toISOString(),
            'location_name' => $this->vaccination->location->name,
            'location_address' => $this->vaccination->location->address,
            'message' => 'Vaccination appointment scheduled for ' . $appointmentDate->format('M j, Y \a\t g:i A')
        ];
    }

    /**
     * Get the calendar data for the notification.
     */
    public function toCalendar($notifiable)
    {
        $location = $this->vaccination->location;
        $appointmentDate = $this->vaccination->appointment_date;

        return [
            'title' => 'Vaccination Appointment - ' . $this->vaccination->vaccine->name,
            'description' => "Vaccination appointment at {$location->name}\n" .
                           "Address: {$location->address}\n" .
                           "Please arrive 10 minutes early and bring your ID.",
            'startTime' => $appointmentDate->toIso8601String(),
            'endTime' => $appointmentDate->addMinutes(30)->toIso8601String(),
            'location' => $location->address,
            'coordinates' => [
                'latitude' => $location->latitude,
                'longitude' => $location->longitude
            ],
            'reminders' => [
                ['type' => 'email', 'minutes' => 1440], // 24 hours before
                ['type' => 'notification', 'minutes' => 120], // 2 hours before
            ]
        ];
    }
}
