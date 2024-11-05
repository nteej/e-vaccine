<?php

namespace App\Services;

class NotificationTemplateService
{
    public function getTemplate($type, $data)
    {
        $template = NotificationTemplate::getEmailTemplate($type, $data);
        
        return $this->customizeTemplate($template, $data);
    }

    protected function customizeTemplate($template, $data)
    {
        // Add user preferences, language, etc.
        if (isset($data['locale'])) {
            // Translate template
        }

        if (isset($data['format'])) {
            // Format template (HTML/plain text)
        }

        return $template;
    }
}