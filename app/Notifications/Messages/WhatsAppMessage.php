<?php
namespace App\Notifications\Messages;

class WhatsAppMessage
{
    public $template;
    public $language;
    public $components;

    public function __construct($template, $language = 'en')
    {
        $this->template = $template;
        $this->language = $language;
        $this->components = [];
    }

    public function component($type, $content)
    {
        $this->components[] = [
            'type' => $type,
            'parameters' => $this->formatParameters($content)
        ];
        return $this;
    }

    private function formatParameters($content)
    {
        if (is_array($content)) {
            return array_map(function($item) {
                return ['type' => 'text', 'text' => $item];
            }, $content);
        }
        return [['type' => 'text', 'text' => $content]];
    }
}
