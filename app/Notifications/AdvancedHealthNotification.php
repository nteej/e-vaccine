<?php

namespace App\Notifications;

class AdvancedHealthNotification extends Notification
{
    use Queueable;

    protected $data;
    protected $priority;

    public function __construct($data, $priority = 'normal')
    {
        $this->data = $data;
        $this->priority = $priority;
    }

    public function via($notifiable)
    {
        $channels = ['database'];
        $preferences = $notifiable->notification_preferences;

        // Base channels
        if ($preferences['email']['enabled'] ?? false) {
            $channels[] = 'mail';
        }
        if ($preferences['sms']['enabled'] ?? false) {
            $channels[] = 'vonage';
        }

        // Additional channels based on priority
        if ($this->priority === 'high') {
            if ($preferences['telegram']['enabled'] ?? false) {
                $channels[] = TelegramChannel::class;
            }
            if ($preferences['push']['enabled'] ?? false) {
                $channels[] = WebPushChannel::class;
            }
        }

        // Emergency channels
        if ($this->priority === 'emergency') {
            $channels = array_merge($channels, ['emergency_contact', 'healthcare_provider']);
        }

        return $channels;
    }

    public function toMail($notifiable)
    {
        $template = NotificationTemplate::getEmailTemplate(
            'health_alert',
            [
                'name' => $notifiable->first_name,
                'condition' => $this->data['condition'],
                'message' => $this->data['message']
            ]
        );

        $mail = (new MailMessage)
            ->subject($template['subject'])
            ->greeting($template['greeting']);

        foreach ($template['content'] as $line) {
            $mail->line($line);
        }

        if ($this->priority === 'high') {
            $mail->priority(1);
        }

        return $mail->action($template['action']['text'], url($template['action']['url']));
    }

    public function toTelegram($notifiable)
    {
        $content = "🚨 *Health Alert*\n\n";
        $content .= "Condition: {$this->data['condition']}\n";
        $content .= "Message: {$this->data['message']}\n";
        $content .= "\nPlease check your email for more details.";

        return (new TelegramMessage())
            ->content($content)
            ->button('View Details', url('/health/alerts/' . $this->data['alert_id']));
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'health_alert',
            'priority' => $this->priority,
            'data' => $this->data,
            'timestamp' => now()->toISOString()
        ];
    }
}