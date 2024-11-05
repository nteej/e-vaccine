<?php

namespace App\Console\Commands;

use App\Models\Vaccination;
use App\Models\User;
use App\Notifications\VaccinationDueNotification;
use App\Notifications\VaccinationOverdueNotification;
use App\Notifications\VaccinationUrgentNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UpdateVaccinationStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vaccinations:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update vaccination statuses and send notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->updateVaccinationStatuses();
        $this->info('Vaccination statuses have been updated.');
    }

    private function updateVaccinationStatuses()
    {
        $today = Carbon::now()->startOfDay();
        
        // Get all active vaccinations
        $vaccinations = Vaccination::with(['user', 'vaccine'])->whereNotNull('next_due_date')->get();
        
        foreach ($vaccinations as $vaccination) {
            $dueDate = Carbon::parse($vaccination->next_due_date);
            $daysDifference = $today->diffInDays($dueDate, false);
            $status = $this->calculateStatus($daysDifference, $vaccination);
            
            // Update status
            $vaccination->update([
                'status' => $status['status'],
                'urgency_level' => $status['urgency'],
                'is_overdue' => $status['is_overdue'],
                'days_overdue' => $status['days_overdue'],
                'last_status_update' => now(),
            ]);

            // Send notifications if needed
            $this->handleNotifications($vaccination, $status);
        }
    }

    private function calculateStatus($daysDifference, $vaccination)
    {
        // Default values
        $status = 'upcoming';
        $urgency = 'low';
        $isOverdue = false;
        $daysOverdue = 0;

        // Get risk level from vaccine and user conditions
        $riskLevel = $this->calculateRiskLevel($vaccination);

        // Calculate status based on days difference and risk level
        if ($daysDifference < 0) {
            $isOverdue = true;
            $daysOverdue = abs($daysDifference);

            // Adjust urgency based on days overdue and risk level
            if ($daysOverdue > 90) {
                $status = 'critically_overdue';
                $urgency = 'critical';
            } elseif ($daysOverdue > 30) {
                $status = 'severely_overdue';
                $urgency = 'high';
            } else {
                $status = 'overdue';
                $urgency = 'medium';
            }

            // Increase urgency for high-risk patients
            if ($riskLevel === 'high' && $urgency !== 'critical') {
                $urgency = $this->escalateUrgency($urgency);
            }
        } else {
            // Upcoming vaccination status
            if ($daysDifference <= 7) {
                $status = 'due_soon';
                $urgency = $riskLevel === 'high' ? 'medium' : 'low';
            } elseif ($daysDifference <= 30) {
                $status = 'upcoming';
                $urgency = 'low';
            } else {
                $status = 'scheduled';
                $urgency = 'none';
            }
        }

        return [
            'status' => $status,
            'urgency' => $urgency,
            'is_overdue' => $isOverdue,
            'days_overdue' => $daysOverdue
        ];
    }

    private function calculateRiskLevel($vaccination)
    {
        $user = $vaccination->user;
        $vaccine = $vaccination->vaccine;
        $riskLevel = 'low';

        // Check user health conditions
        $healthConditions = json_decode($user->health_conditions, true) ?? [];
        $highRiskConditions = [
            'immunocompromised',
            'diabetes',
            'heart_disease',
            'cancer',
            'transplant_recipient',
            'chronic_respiratory_disease'
        ];

        if (array_intersect($healthConditions, $highRiskConditions)) {
            $riskLevel = 'high';
        }

        // Check vaccine priority
        if ($vaccine->priority_level === 'high') {
            $riskLevel = 'high';
        }

        // Check age factor
        if ($user->age >= 65) {
            $riskLevel = 'high';
        }

        return $riskLevel;
    }

    private function escalateUrgency($currentUrgency)
    {
        $urgencyLevels = ['low', 'medium', 'high', 'critical'];
        $currentIndex = array_search($currentUrgency, $urgencyLevels);
        return $urgencyLevels[min($currentIndex + 1, count($urgencyLevels) - 1)];
    }

    private function handleNotifications($vaccination, $status)
    {
        $user = $vaccination->user;

        // Determine which notifications to send based on status and urgency
        switch ($status['status']) {
            case 'due_soon':
                $user->notify(new VaccinationDueNotification($vaccination));
                break;

            case 'overdue':
                $user->notify(new VaccinationOverdueNotification($vaccination));
                break;

            case 'severely_overdue':
            case 'critically_overdue':
                $user->notify(new VaccinationUrgentNotification($vaccination));
                // Also notify healthcare provider for critical cases
                $this->notifyHealthcareProvider($vaccination);
                break;
        }
    }

    private function notifyHealthcareProvider($vaccination)
    {
        // Implementation for healthcare provider notification
    }
}
