<?php

namespace App\Notifications\Channels;

use Illuminate\Support\Facades\Http;

class TelegramChannel
{
    public function send($notifiable, $notification)
    {
        if (!$telegramId = $notifiable->telegram_id) {
            return;
        }

        $message = $notification->toTelegram($notifiable);

        Http::post("https://api.telegram.org/bot{$this->botToken}/sendMessage", [
            'chat_id' => $telegramId,
            'text' => $message->content,
            'parse_mode' => 'HTML',
        ]);
    }
}