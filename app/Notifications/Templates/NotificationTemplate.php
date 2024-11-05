<?php

namespace App\Notifications\Templates;

class NotificationTemplate
{
    public static function getTemplate($type, $data, $channel = 'email')
    {
        $templates = [
            'appointment_reminder' => [
                'email' => [
                    'subject' => 'Upcoming Vaccination Appointment',
                    'greeting' => 'Hello {name},',
                    'content' => [
                        'This is a reminder for your upcoming vaccination appointment:',
                        'Date: {appointment_date}',
                        'Time: {appointment_time}',
                        'Location: {clinic_name}',
                        'Vaccine: {vaccine_name}',
                        'Special Instructions: {instructions}'
                    ],
                    'action' => ['Manage Appointment', '/appointments/{appointment_id}']
                ],
                'whatsapp' => [
                    'template' => 'appointment_reminder',
                    'components' => [
                        'header' => 'Vaccination Appointment Reminder',
                        'body' => [
                            'Appointment Details:',
                            '📅 Date: {appointment_date}',
                            '⏰ Time: {appointment_time}',
                            '📍 Location: {clinic_name}',
                            '💉 Vaccine: {vaccine_name}'
                        ],
                        'footer' => 'Reply YES to confirm or NO to reschedule'
                    ]
                ]
            ],
            'vaccination_series' => [
                'email' => [
                    'subject' => 'Vaccination Series Update',
                    'greeting' => 'Hi {name},',
                    'content' => [
                        'Your vaccination series status:',
                        'Vaccine: {vaccine_name}',
                        'Doses Completed: {completed_doses}/{total_doses}',
                        'Next Dose Due: {next_due_date}',
                        'Completion Status: {completion_percentage}%'
                    ],
                    'action' => ['View Series Progress', '/vaccinations/series/{series_id}']
                ],
                'whatsapp' => [
                    'template' => 'vaccination_series',
                    'components' => [
                        'header' => 'Vaccination Series Update',
                        'body' => [
                            '💉 Series Progress Update',
                            'Vaccine: {vaccine_name}',
                            'Progress: {completed_doses}/{total_doses} doses',
                            'Next Due: {next_due_date}'
                        ]
                    ]
                ]
            ],
            'health_assessment' => [
                'email' => [
                    'subject' => 'Health Assessment Required',
                    'greeting' => 'Dear {name},',
                    'content' => [
                        'A health assessment is required before your next vaccination.',
                        'Reason: {reason}',
                        'Required by: {due_date}',
                        'Assessment type: {assessment_type}'
                    ],
                    'action' => ['Complete Assessment', '/health/assessment/{assessment_id}']
                ],
                'whatsapp' => [
                    'template' => 'health_assessment',
                    'components' => [
                        'header' => 'Health Assessment Required',
                        'body' => [
                            '🏥 Health Assessment Notice',
                            'Type: {assessment_type}',
                            'Due By: {due_date}',
                            'Click link to complete: {assessment_link}'
                        ]
                    ]
                ]
            ]
        ];

        return $templates[$type][$channel] ?? null;
    }
    
    public static function getEmailTemplate($type, $data)
    {
        $templates = [
            'vaccination_due' => [
                'subject' => 'Vaccination Due: {vaccine_name}',
                'greeting' => 'Hello {name},',
                'content' => [
                    'Your {vaccine_name} vaccination is due on {due_date}.',
                    'Please schedule your appointment as soon as possible.',
                    'Your health and safety are our top priority.'
                ],
                'action' => [
                    'text' => 'Schedule Now',
                    'url' => '/vaccinations/schedule/{vaccine_id}'
                ]
            ],
            'health_alert' => [
                'subject' => 'Important Health Alert',
                'greeting' => 'Dear {name},',
                'content' => [
                    'This is an important health alert regarding your {condition}.',
                    '{message}',
                    'Please review this information carefully.'
                ],
                'action' => [
                    'text' => 'View Details',
                    'url' => '/health/alerts/{alert_id}'
                ]
            ],
            'profile_security' => [
                'subject' => 'Security Alert: Profile Changes',
                'greeting' => 'Hi {name},',
                'content' => [
                    'There have been changes made to your profile:',
                    '{changes}',
                    'If you did not make these changes, please contact support immediately.'
                ],
                'action' => [
                    'text' => 'Review Changes',
                    'url' => '/profile/security'
                ]
            ]
        ];

        return self::parseTemplate($templates[$type], $data);
    }

    private static function parseTemplate($template, $data)
    {
        foreach ($data as $key => $value) {
            $template = str_replace('{' . $key . '}', $value, $template);
        }
        return $template;
    }
}