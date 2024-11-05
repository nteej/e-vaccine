<?php

namespace App\Notifications\Messages;

class TelegramMessage
{
    public $content;
    public $buttons = [];

    public function content($content)
    {
        $this->content = $content;
        return $this;
    }

    public function button($text, $url)
    {
        $this->buttons[] = [
            'text' => $text,
            'url' => $url
        ];
        return $this;
    }
}
