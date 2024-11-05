<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Exception;
use Log;

class NotificationPreferenceService
{
    protected $availableChannels = [
        'email',
        'sms',
        'whatsapp',
        'telegram',
        'push',
        'in_app'
    ];

    protected $notificationTypes = [
        'vaccination_reminders',
        'appointment_updates',
        'health_alerts',
        'system_updates',
        'security_alerts'
    ];

    /**
     * Update user's notification preferences
     */
    public function updatePreferences(User $user, array $preferences)
    {
        try {
            $validatedPreferences = $this->validatePreferences($preferences);
            
            foreach ($validatedPreferences as $channel => $settings) {
                if ($settings['enabled']) {
                    $this->verifyChannel($user, $channel);
                }
            }

            $user->update([
                'notification_preferences' => $validatedPreferences
            ]);

            return true;
        } catch (Exception $e) {
            Log::error('Failed to update notification preferences: ' . $e->getMessage());
            throw new Exception('Failed to update notification preferences');
        }
    }

    /**
     * Validate notification preferences
     */
    protected function validatePreferences(array $preferences): array
    {
        $validated = [];

        foreach ($this->availableChannels as $channel) {
            if (isset($preferences[$channel])) {
                $validated[$channel] = [
                    'enabled' => (bool) ($preferences[$channel]['enabled'] ?? false),
                    'types' => $this->validateNotificationTypes(
                        $preferences[$channel]['types'] ?? []
                    ),
                    'quiet_hours' => $this->validateQuietHours(
                        $preferences[$channel]['quiet_hours'] ?? null
                    )
                ];

                // Channel specific settings
                if ($channel === 'email') {
                    $validated[$channel]['frequency'] = $this->validateFrequency(
                        $preferences[$channel]['frequency'] ?? 'immediate'
                    );
                }

                if (in_array($channel, ['sms', 'whatsapp'])) {
                    $validated[$channel]['emergency_only'] = 
                        (bool) ($preferences[$channel]['emergency_only'] ?? false);
                }
            } else {
                $validated[$channel] = [
                    'enabled' => false,
                    'types' => [],
                    'quiet_hours' => null
                ];
            }
        }

        return $validated;
    }

    /**
     * Validate notification types
     */
    protected function validateNotificationTypes(array $types): array
    {
        return array_intersect($types, $this->notificationTypes);
    }

    /**
     * Validate quiet hours
     */
    protected function validateQuietHours(?array $quietHours): ?array
    {
        if (!$quietHours) {
            return null;
        }

        return [
            'enabled' => (bool) ($quietHours['enabled'] ?? false),
            'start' => $this->validateTime($quietHours['start'] ?? '22:00'),
            'end' => $this->validateTime($quietHours['end'] ?? '07:00'),
            'timezone' => $quietHours['timezone'] ?? 'UTC'
        ];
    }

    /**
     * Validate time format
     */
    protected function validateTime(string $time): string
    {
        return date('H:i', strtotime($time)) ?: '00:00';
    }

    /**
     * Validate notification frequency
     */
    protected function validateFrequency(string $frequency): string
    {
        $validFrequencies = ['immediate', 'hourly', 'daily', 'weekly'];
        return in_array($frequency, $validFrequencies) ? $frequency : 'immediate';
    }

    /**
     * Verify notification channel
     */
    public function verifyChannel(User $user, string $channel)
    {
        switch ($channel) {
            case 'email':
                return $this->verifyEmailChannel($user);
            case 'sms':
                return $this->verifySmsChannel($user);
            case 'whatsapp':
                return $this->verifyWhatsAppChannel($user);
            case 'telegram':
                return $this->verifyTelegramChannel($user);
            case 'push':
                return $this->verifyPushChannel($user);
        }
    }

    /**
     * Verify SMS channel
     */
    protected function verifySmsChannel(User $user): bool
    {
        if (!$user->phone_number) {
            throw new Exception('Phone number is required for SMS notifications');
        }

        try {
            // Verify phone number format and carrier
            $response = Http::get("https://phonevalidation.api/verify", [
                'phone' => $user->phone_number
            ]);

            return $response->successful() && $response->json('valid');
        } catch (Exception $e) {
            Log::error('SMS verification failed: ' . $e->getMessage());
            return false;
        }
    }


    /**
     * Check if notification should be sent
     */
    public function shouldSendNotification(User $user, string $channel, string $type, string $priority = 'normal'): bool
    {
        $preferences = $user->notification_preferences[$channel] ?? null;

        if (!$preferences || !$preferences['enabled']) {
            return false;
        }

        // Always send emergency notifications
        if ($priority === 'emergency') {
            return true;
        }

        // Check if notification type is enabled
        if (!in_array($type, $preferences['types'])) {
            return false;
        }

        // Check quiet hours
        if ($preferences['quiet_hours']['enabled'] ?? false) {
            if ($this->isInQuietHours($preferences['quiet_hours'])) {
                return false;
            }
        }

        // Channel specific checks
        if ($channel === 'sms' || $channel === 'whatsapp') {
            if ($preferences['emergency_only'] && $priority !== 'high') {
                return false;
            }
        }

        return true;
    }

    /**
     * Check if current time is within quiet hours
     */
    protected function isInQuietHours(array $quietHours): bool
    {
        $timezone = new \DateTimeZone($quietHours['timezone']);
        $now = new \DateTime('now', $timezone);
        $start = \DateTime::createFromFormat('H:i', $quietHours['start'], $timezone);
        $end = \DateTime::createFromFormat('H:i', $quietHours['end'], $timezone);

        if ($end < $start) {
            // Quiet hours span midnight
            return $now >= $start || $now < $end;
        }

        return $now >= $start && $now < $end;
    }

    /**
     * Get user's notification statistics
     */
    public function getNotificationStats(User $user): array
    {
        $now = now();
        $thirtyDaysAgo = $now->copy()->subDays(30);

        return [
            'total_sent' => $user->notifications()
                ->whereBetween('created_at', [$thirtyDaysAgo, $now])
                ->count(),
            'by_channel' => $user->notifications()
                ->whereBetween('created_at', [$thirtyDaysAgo, $now])
                ->get()
                ->groupBy('channel')
                ->map(fn($notifications) => $notifications->count())
                ->toArray(),
            'by_type' => $user->notifications()
                ->whereBetween('created_at', [$thirtyDaysAgo, $now])
                ->get()
                ->groupBy('type')
                ->map(fn($notifications) => $notifications->count())
                ->toArray(),
            'last_sent' => $user->notifications()
                ->latest()
                ->first()?->created_at,
            'unread_count' => $user->unreadNotifications()->count()
        ];
    }
    /**
     * Advanced Notification Statistics
     */
    public function getDetailedStats(User $user, ?Carbon $startDate = null, ?Carbon $endDate = null): array
    {
        $startDate = $startDate ?? now()->subDays(30);
        $endDate = $endDate ?? now();

        $notifications = $user->notifications()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        return [
            'summary' => $this->getSummaryStats($notifications),
            'delivery' => $this->getDeliveryStats($notifications),
            'engagement' => $this->getEngagementStats($user, $notifications),
            'trends' => $this->getTrendAnalysis($notifications),
            'channel_performance' => $this->getChannelPerformance($notifications),
            'peak_hours' => $this->getPeakHours($notifications)
        ];
    }

    protected function getSummaryStats($notifications): array
    {
        return [
            'total_sent' => $notifications->count(),
            'successful_delivery' => $notifications->where('delivered', true)->count(),
            'failed_delivery' => $notifications->where('delivered', false)->count(),
            'read_rate' => $this->calculatePercentage(
                $notifications->where('read', true)->count(),
                $notifications->count()
            ),
            'interaction_rate' => $this->calculatePercentage(
                $notifications->where('interacted', true)->count(),
                $notifications->count()
            )
        ];
    }

    protected function getDeliveryStats($notifications): array
    {
        return [
            'average_delivery_time' => $notifications
                ->whereNotNull('delivered_at')
                ->average(function ($notification) {
                    return Carbon::parse($notification->delivered_at)
                        ->diffInSeconds($notification->created_at);
                }),
            'delivery_success_rate' => [
                'email' => $this->getChannelDeliveryRate($notifications, 'email'),
                'sms' => $this->getChannelDeliveryRate($notifications, 'sms'),
                'whatsapp' => $this->getChannelDeliveryRate($notifications, 'whatsapp'),
                'push' => $this->getChannelDeliveryRate($notifications, 'push')
            ],
            'failure_reasons' => $notifications
                ->where('delivered', false)
                ->groupBy('failure_reason')
                ->map->count()
        ];
    }

    protected function getEngagementStats(User $user, $notifications): array
    {
        return [
            'read_time_distribution' => [
                'immediate' => $this->getReadTimeCount($notifications, 0, 300),
                'within_hour' => $this->getReadTimeCount($notifications, 301, 3600),
                'within_day' => $this->getReadTimeCount($notifications, 3601, 86400),
                'later' => $this->getReadTimeCount($notifications, 86401, null)
            ],
            'action_types' => $notifications
                ->whereNotNull('action_taken')
                ->groupBy('action_taken')
                ->map->count(),
            'preferred_channels' => $this->calculateChannelPreferences($user, $notifications),
            'optimal_send_times' => $this->calculateOptimalSendTimes($notifications)
        ];
    }

    protected function getTrendAnalysis($notifications): array
    {
        return [
            'daily_volumes' => $this->getDailyVolumes($notifications),
            'weekly_patterns' => $this->getWeeklyPatterns($notifications),
            'type_distribution' => $this->getTypeDistribution($notifications),
            'response_trends' => $this->getResponseTrends($notifications)
        ];
    }

    /**
     * Batch Notification Handling
     */
    public function sendBatchNotifications(array $users, string $notificationType, array $data, array $options = []): void
    {
        $batchSize = $options['batch_size'] ?? 1000;
        $priority = $options['priority'] ?? 'normal';
        $delay = $options['delay'] ?? 0;

        collect($users)
            ->chunk($batchSize)
            ->each(function ($userChunk) use ($notificationType, $data, $priority, $delay) {
                ProcessBatchNotifications::dispatch($userChunk, $notificationType, $data, $priority)
                    ->delay($delay)
                    ->onQueue('notifications');
            });
    }

    public function processBatch($users, $notificationType, $data, $priority): void
    {
        foreach ($users as $user) {
            if ($this->shouldSendNotification($user, $notificationType, $priority)) {
                $this->sendOptimizedNotification($user, $notificationType, $data);
            }
        }
    }

    protected function sendOptimizedNotification($user, $notificationType, $data): void
    {
        $channels = $this->determineOptimalChannels($user, $notificationType);
        
        foreach ($channels as $channel) {
            try {
                $this->sendToChannel($user, $channel, $notificationType, $data);
            } catch (\Exception $e) {
                $this->handleFailedNotification($user, $channel, $e);
            }
        }
    }

    /**
     * Enhanced Channel Verifications
     */
    protected function verifyEmailChannel(User $user): bool
    {
        try {
            // Email format validation
            if (!filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
                throw new \Exception('Invalid email format');
            }

            // Domain validation
            $domain = substr(strrchr($user->email, "@"), 1);
            if (!checkdnsrr($domain, 'MX')) {
                throw new \Exception('Invalid email domain');
            }

            // Disposable email check
            if ($this->isDisposableEmail($domain)) {
                throw new \Exception('Disposable email not allowed');
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Email verification failed: ' . $e->getMessage());
            return false;
        }
    }

    protected function verifyWhatsAppChannel(User $user): bool
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.whatsapp.token')
            ])->post('https://graph.facebook.com/v12.0/' . config('services.whatsapp.phone_number_id') . '/messages', [
                'messaging_product' => 'whatsapp',
                'to' => $user->whatsapp_number,
                'type' => 'template',
                'template' => [
                    'name' => 'verification',
                    'language' => [
                        'code' => 'en'
                    ]
                ]
            ]);

            if ($response->successful()) {
                Cache::put(
                    "whatsapp_verification_{$user->id}",
                    $response->json('messages')[0]['id'],
                    now()->addMinutes(15)
                );
                return true;
            }

            return false;
        } catch (\Exception $e) {
            Log::error('WhatsApp verification failed: ' . $e->getMessage());
            return false;
        }
    }

    protected function verifyPushChannel(User $user): bool
    {
        try {
            if (!$user->push_subscription) {
                throw new \Exception('No push subscription found');
            }

            $subscription = json_decode($user->push_subscription, true);

            // Test push notification
            $webPush = new WebPush([
                'VAPID' => [
                    'subject' => config('app.url'),
                    'publicKey' => config('services.webpush.public_key'),
                    'privateKey' => config('services.webpush.private_key')
                ]
            ]);

            $report = $webPush->sendOneNotification(
                Subscription::create($subscription),
                json_encode(['type' => 'verification'])
            );

            return $report->isSuccess();
        } catch (\Exception $e) {
            Log::error('Push notification verification failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Helper Methods
     */
    protected function calculatePercentage($value, $total): float
    {
        return $total > 0 ? round(($value / $total) * 100, 2) : 0;
    }

    protected function getChannelDeliveryRate($notifications, $channel): float
    {
        $channelNotifications = $notifications->where('channel', $channel);
        return $this->calculatePercentage(
            $channelNotifications->where('delivered', true)->count(),
            $channelNotifications->count()
        );
    }

    protected function getReadTimeCount($notifications, $minSeconds, $maxSeconds = null): int
    {
        return $notifications
            ->filter(function ($notification) use ($minSeconds, $maxSeconds) {
                if (!$notification->read_at) return false;
                $seconds = Carbon::parse($notification->read_at)
                    ->diffInSeconds($notification->delivered_at);
                return $maxSeconds 
                    ? $seconds >= $minSeconds && $seconds <= $maxSeconds
                    : $seconds >= $minSeconds;
            })
            ->count();
    }

    protected function isDisposableEmail($domain): bool
    {
        $disposableDomains = Cache::remember('disposable_email_domains', 86400, function () {
            return Http::get('https://disposable-email-domains.api/list')->json();
        });

        return in_array($domain, $disposableDomains);
    }

    protected function determineOptimalChannels(User $user, string $notificationType): array
    {
        $preferences = $user->notification_preferences;
        $channels = [];

        foreach ($this->availableChannels as $channel) {
            if ($this->isChannelOptimal($user, $channel, $notificationType)) {
                $channels[] = $channel;
            }
        }

        return $channels;
    }

    protected function isChannelOptimal(User $user, string $channel, string $notificationType): bool
    {
        $stats = Cache::remember(
            "channel_stats_{$user->id}_{$channel}",
            3600,
            fn() => $this->getChannelStats($user, $channel)
        );

        return $stats['success_rate'] > 80 && $stats['engagement_rate'] > 20;
    }
}