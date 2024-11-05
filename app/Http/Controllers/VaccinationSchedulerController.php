<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Vaccine;
use App\Models\Vaccination;
use App\Models\VaccinationRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VaccinationSchedulerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard(Request $request)
    {
        $user = auth()->user();
        $today = Carbon::now();
        $age = Carbon::parse($user->date_of_birth)->age;
        
        // Get user's health conditions and lifestyle factors
        $healthConditions = json_decode($user->health_conditions, true) ?? [];
        $lifestyleFactors = json_decode($user->lifestyle_factors, true) ?? [];
        
        // Get vaccination history
        $vaccinationHistory = VaccinationRecord::with('vaccine')
            ->where('user_id', $user->id)
            ->orderBy('administration_date', 'desc')
            ->get();

        // Get all available vaccines
        $allVaccines = Vaccine::all();

        // Calculate due and recommended vaccinations
        $dueVaccinations = [];
        $recommendedVaccinations = [];
        $completedVaccinations = [];

        foreach ($allVaccines as $vaccine) {
            $lastVaccination = $vaccinationHistory
                ->where('vaccine_id', $vaccine->id)
                ->first();

            $isRecommended = $this->isVaccineRecommended(
                $vaccine,
                $age,
                $healthConditions,
                $lifestyleFactors,
                $user->is_pregnant,
                $user->is_healthcare_worker
            );

            if ($isRecommended) {
                $nextDueDate = $this->calculateNextDueDate(
                    $lastVaccination,
                    $vaccine->frequency,
                    $today
                );

                $vaccinationStatus = [
                    'vaccine' => $vaccine,
                    'last_vaccination' => $lastVaccination,
                    'next_due_date' => $nextDueDate,
                    'priority' => $this->calculatePriority($vaccine, $nextDueDate, $healthConditions),
                    'notes' => $this->generateVaccineNotes($vaccine, $user),
                    'is_overdue' => 0,
                    'due_date'=>''
                ];

                if ($lastVaccination && !$nextDueDate) {
                    $completedVaccinations[] = $vaccinationStatus;
                } elseif ($nextDueDate && $nextDueDate->isPast()) {
                    $dueVaccinations[] = $vaccinationStatus;
                } elseif ($nextDueDate) {
                    $recommendedVaccinations[] = $vaccinationStatus;
                }
            }
        }

        // Sort vaccinations by priority
        $sortByPriority = function ($a, $b) {
            return $b['priority'] <=> $a['priority'];
        };

        usort($dueVaccinations, $sortByPriority);
        usort($recommendedVaccinations, $sortByPriority);

        // Get upcoming appointments
        $upcomingAppointments = VaccinationRecord::where('user_id', $user->id)
            ->where('administration_date', '>', $today)
            ->orderBy('administration_date')
            ->get();

        // Calculate completion statistics
        $completionStats = $this->calculateCompletionStats(
            $dueVaccinations,
            $recommendedVaccinations,
            $completedVaccinations
        );

        // Generate health alerts
        $healthAlerts = $this->generateHealthAlerts(
            $user,
            $dueVaccinations,
            $healthConditions
        );

        return view('dashboard', compact(
            'user',
            'dueVaccinations',
            'recommendedVaccinations',
            'completedVaccinations',
            'vaccinationHistory',
            'upcomingAppointments',
            'completionStats',
            'healthAlerts'
        ));
    }

    private function isVaccineRecommended($vaccine, $age, $healthConditions, $lifestyleFactors, $isPregnant, $isHealthcareWorker)
    {
        // Check age requirements
        if ($age < $vaccine->recommended_age_start || 
            ($vaccine->recommended_age_end && $age > $vaccine->recommended_age_end)) {
            return false;
        }

        // Get risk factors for the vaccine
        $vaccineRiskFactors = json_decode($vaccine->risk_factors, true) ?? [];

        // Always recommend if vaccine is for everyone (no specific risk factors)
        if (empty($vaccineRiskFactors)) {
            return true;
        }

        // Check health conditions and lifestyle factors
        $userFactors = array_merge($healthConditions, $lifestyleFactors);
        
        // Add special status factors
        if ($isPregnant) {
            $userFactors[] = 'pregnant';
        }
        if ($isHealthcareWorker) {
            $userFactors[] = 'healthcare_worker';
        }

        // Check if any user factors match vaccine risk factors
        return !empty(array_intersect($userFactors, $vaccineRiskFactors));
    }

    private function calculateNextDueDate($lastVaccination, $frequency, $today)
    {
        if (!$lastVaccination) {
            return $today;
        }

        $lastDate = Carbon::parse($lastVaccination->administration_date);

        return match($frequency) {
            'yearly' => $lastDate->addYear(),
            'every_10_years' => $lastDate->addYears(10),
            'twice_once' => $lastDate->addMonths(6),
            'three_times_once' => $lastDate->addMonths(2),
            'varies' => $this->calculateVariableDate($lastVaccination),
            'once' => null,
            default => null
        };
    }

    private function calculatePriority($vaccine, $dueDate, $healthConditions)
    {
        $priority = 0;

        // Base priority on vaccine's priority level
        $priority += match($vaccine->priority_level) {
            'high' => 30,
            'medium' => 20,
            'low' => 10,
            default => 0
        };

        // Increase priority if overdue
        if ($dueDate && $dueDate->isPast()) {
            $priority += 20;
            
            // Additional priority for each month overdue
            $monthsOverdue = $dueDate->diffInMonths(Carbon::now());
            $priority += min($monthsOverdue * 5, 30);
        }

        // Increase priority for high-risk conditions
        $highRiskConditions = [
            'immunocompromised',
            'diabetes',
            'heart_disease',
            'lung_disease',
            'cancer',
            'transplant_recipient'
        ];

        foreach ($highRiskConditions as $condition) {
            if (in_array($condition, $healthConditions)) {
                $priority += 15;
                break;
            }
        }

        return $priority;
    }

    private function generateVaccineNotes($vaccine, $user)
    {
        $notes = [];

        // Add vaccine-specific notes
        if ($vaccine->name === 'Influenza' && $user->age >= 65) {
            $notes[] = 'High-dose or adjuvanted flu vaccine recommended for age 65+';
        }

        // Add health condition specific notes
        $healthConditions = json_decode($user->health_conditions, true) ?? [];
        if (in_array('immunocompromised', $healthConditions)) {
            $notes[] = 'Requires modified vaccination protocol due to immune status';
        }

        // Add pregnancy notes
        if ($user->is_pregnant) {
            $notes[] = 'Ensure vaccine is safe for pregnancy';
        }

        // Add allergy notes
        $allergies = json_decode($user->allergies, true) ?? [];
        if (!empty($allergies)) {
            $notes[] = 'Review allergies before administration';
        }

        return $notes;
    }

    private function calculateCompletionStats($due, $recommended, $completed)
    {
        $total = count($due) + count($recommended) + count($completed);
        
        return [
            'total_vaccines' => $total,
            'completed_count' => count($completed),
            'due_count' => count($due),
            'recommended_count' => count($recommended),
            'completion_percentage' => $total > 0 
                ? round((count($completed) / $total) * 100) 
                : 0
        ];
    }

    private function generateHealthAlerts($user, $dueVaccinations, $healthConditions)
    {
        $alerts = [];

        // Check for overdue high-priority vaccinations
        foreach ($dueVaccinations as $vaccination) {
            if ($vaccination['priority'] >= 40) {
                $alerts[] = [
                    'type' => 'danger',
                    'message' => "Overdue for {$vaccination['vaccine']->name} vaccination"
                ];
            }
        }

        // Check for special health conditions
        if (in_array('immunocompromised', $healthConditions)) {
            $alerts[] = [
                'type' => 'warning',
                'message' => 'Special vaccination protocols required due to immune status'
            ];
        }

        // Add seasonal alerts
        $month = Carbon::now()->month;
        if (in_array($month, [9, 10, 11])) {
            $alerts[] = [
                'type' => 'info',
                'message' => 'Flu season approaching - schedule your annual flu shot'
            ];
        }

        return $alerts;
    }

    private function calculateVariableDate($lastVaccination)
    {
        // Handle vaccines with variable schedules based on specific conditions
        // This would need to be customized based on specific vaccine requirements
        return Carbon::parse($lastVaccination->administration_date)->addMonths(6);
    }

    public function getDueVaccinations(User $user) {
        $age = Carbon::parse($user->date_of_birth)->age;
        $healthConditions = json_decode($user->health_conditions);
        $lifestyleFactors = json_decode($user->lifestyle_factors);

        // Get all relevant vaccines based on age
        $dueVaccines = Vaccine::where(function($query) use ($age) {
            $query->where('recommended_age_start', '<=', $age)
                  ->where(function($q) use ($age) {
                      $q->where('recommended_age_end', '>=', $age)
                        ->orWhereNull('recommended_age_end');
                  });
        })->get();

        $recommendations = [];
        foreach ($dueVaccines as $vaccine) {
            // Check if user matches risk factors
            $riskFactors = json_decode($vaccine->risk_factors, true) ?? [];
            $isAtRisk = false;

            if (empty($riskFactors)) {
                $isAtRisk = true; // Vaccine for everyone
            } else {
                foreach ($riskFactors as $factor) {
                    if (in_array($factor, $healthConditions) || 
                        in_array($factor, $lifestyleFactors)) {
                        $isAtRisk = true;
                        break;
                    }
                }
            }

            if ($isAtRisk) {
                // Get last vaccination
                $lastVaccination = $user->vaccinations()
                    ->where('vaccine_id', $vaccine->id)
                    ->latest('date_administered')
                    ->first();

                if (!$lastVaccination || Carbon::parse($lastVaccination->next_due_date)->isPast()) {
                    $recommendations[] = [
                        'vaccine' => $vaccine,
                        'last_date' => $lastVaccination ? $lastVaccination->date_administered : null,
                        'due_date' => $lastVaccination ? $lastVaccination->next_due_date : 'As soon as possible'
                    ];
                }
            }
        }

        return response()->json($recommendations);
    }

    public function scheduleVaccination(Request $request, Vaccine $vaccine) {
        $validatedData = $request->validate([
            'scheduled_date' => 'required|date|after:today',
            'location' => 'required|string',
            'notes' => 'nullable|string'
        ]);
    
        $user = auth()->user();
        
        // Calculate next due date based on vaccine frequency
        $nextDueDate = $this->calculateNextDueDate(
            $validatedData['scheduled_date'], 
            $vaccine->frequency
        );
    
        $vaccination = new Vaccination([
            'vaccine_id' => $vaccine->id,
            'date_administered' => $validatedData['scheduled_date'],
            'next_due_date' => $nextDueDate,
            'notes' => $validatedData['notes']
        ]);
    
        $user->vaccinations()->save($vaccination);
    
        return redirect()->route('dashboard')
            ->with('success', 'Vaccination scheduled successfully');
    }


    public function updateProfile(){

    }

}
