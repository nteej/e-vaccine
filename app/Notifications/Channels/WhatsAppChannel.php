<?php
namespace App\Notifications\Channels;

use Illuminate\Support\Facades\Http;

class WhatsAppChannel
{
    protected $client;
    
    public function __construct()
    {
        $this->client = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.whatsapp.token'),
            'Content-Type' => 'application/json',
        ])->baseUrl('https://graph.facebook.com/v13.0/');
    }

    public function send($notifiable, $notification)
    {
        if (!$whatsappNumber = $notifiable->whatsapp_number) {
            return;
        }

        $message = $notification->toWhatsApp($notifiable);

        return $this->client->post(config('services.whatsapp.phone_number_id') . '/messages', [
            'messaging_product' => 'whatsapp',
            'to' => $whatsappNumber,
            'type' => 'template',
            'template' => [
                'name' => $message->template,
                'language' => [
                    'code' => $message->language ?? 'en'
                ],
                'components' => $message->components
            ]
        ]);
    }
}
