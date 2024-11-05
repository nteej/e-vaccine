<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email_notifications' => ['boolean'],
            'notify_due_vaccinations' => ['boolean'],
            'notify_health_reminders' => ['boolean'],
            'notify_appointments' => ['boolean'],
            'notify_updates' => ['boolean'],
            'notify_emergencies' => ['boolean'],
            'sms_notifications' => ['boolean'],
            'sms_urgent' => ['boolean'],
            'sms_appointments' => ['boolean'],
            'push_notifications' => ['boolean'],
            'push_due_today' => ['boolean'],
            'push_upcoming' => ['boolean'],
            'reminder_days' => ['required', 'integer', 'in:3,5,7,14,30'],
            'quiet_hours_enabled' => ['boolean'],
            'quiet_hours_start' => ['required_if:quiet_hours_enabled,true', 'date_format:H:i'],
            'quiet_hours_end' => ['required_if:quiet_hours_enabled,true', 'date_format:H:i'],
            'frequency' => ['required', 'string', 'in:immediately,daily,weekly']
        ];
    }
}
