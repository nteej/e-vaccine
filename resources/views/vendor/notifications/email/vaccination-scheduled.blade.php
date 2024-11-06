@component('mail::message')
# Vaccination Appointment Scheduled

Dear {{ $notifiable->first_name }},

Your vaccination appointment has been scheduled successfully.

**Appointment Details:**
- Vaccine: {{ $vaccination->vaccine->name }}
- Date: {{ $vaccination->appointment_date->format('l, F j, Y') }}
- Time: {{ $vaccination->appointment_date->format('g:i A') }}
- Location: {{ $vaccination->location->name }}
- Address: {{ $vaccination->location->address }}

**Important Instructions:**
- Please arrive 10 minutes before your appointment
- Bring a valid ID and insurance card (if applicable)
- Wear a mask and maintain social distancing

@component('mail::button', ['url' => url('/vaccinations')])
View Appointment Details
@endcomponent

Need to reschedule? Please contact us at least 24 hours before your appointment.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
