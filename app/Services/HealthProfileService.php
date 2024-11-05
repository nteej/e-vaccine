<?php

namespace App\Services;

use App\Models\User;
use App\Models\HealthCondition;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HealthProfileService
{
   public function getUserHealthProfile(User $user)
   {
       return [
           'last_physical_date' => $user->last_physical_date,
           'blood_pressure' => $this->getLatestVitalSign($user, 'blood_pressure'),
           'weight' => $this->getLatestVitalSign($user, 'weight'),
           'height' => $this->getLatestVitalSign($user, 'height'),
           'bmi' => $this->calculateBMI($user),
           'vaccination_status' => $this->getVaccinationStatus($user),
           'active_conditions' => $this->getActiveConditions($user),
           'allergies' => $user->allergies ?? [],
           'medications' => $user->medications ?? []
       ];
   }

   public function calculateRiskAssessment(User $user)
   {
       $riskFactors = [];
       $riskLevel = 'low';
       $summary = 'Your health risk assessment shows a low risk profile.';

       // Age-based risks
       if ($user->age > 65) {
           $riskFactors[] = 'Age over 65';
           $riskLevel = 'medium';
       }

       // Health condition risks
       $conditions = $user->healthConditions;
       $highRiskConditions = $conditions->where('risk_level', 'high')->count();
       $mediumRiskConditions = $conditions->where('risk_level', 'medium')->count();

       if ($highRiskConditions > 0) {
           $riskLevel = 'high';
           $riskFactors[] = 'High-risk health conditions present';
       } elseif ($mediumRiskConditions > 0) {
           $riskLevel = 'medium';
           $riskFactors[] = 'Moderate-risk health conditions present';
       }

       // Vaccination status risks
       $vaccinationStatus = $this->getVaccinationStatus($user);
       if ($vaccinationStatus['overdue_count'] > 0) {
           $riskFactors[] = 'Overdue vaccinations';
           $riskLevel = max($riskLevel, 'medium');
       }

       // Update summary based on risk level
       if ($riskLevel === 'high') {
           $summary = 'Your health risk assessment indicates several significant risk factors that require attention.';
       } elseif ($riskLevel === 'medium') {
           $summary = 'Your health risk assessment shows moderate risk factors that should be monitored.';
       }

       return [
           'risk_level' => $riskLevel,
           'risk_factors' => $riskFactors,
           'summary' => $summary
       ];
   }

   public function getRecommendedActions(User $user)
   {
       $actions = [];
       $riskAssessment = $this->calculateRiskAssessment($user);

       // Vaccination recommendations
       $vaccinationStatus = $this->getVaccinationStatus($user);
       if ($vaccinationStatus['overdue_count'] > 0) {
           $actions[] = 'Schedule overdue vaccinations';
       }

       // Physical exam recommendations
       if (!$user->last_physical_date || 
           Carbon::parse($user->last_physical_date)->diffInMonths(now()) > 12) {
           $actions[] = 'Schedule annual physical examination';
       }

       // Condition-specific recommendations
       foreach ($user->healthConditions as $condition) {
           if ($condition->monitoring_frequency === 'monthly' && 
               (!$condition->pivot->last_checkup || 
               Carbon::parse($condition->pivot->last_checkup)->diffInMonths(now()) > 1)) {
               $actions[] = "Schedule checkup for {$condition->name}";
           }
       }

       // Risk-based recommendations
       if ($riskAssessment['risk_level'] === 'high') {
           $actions[] = 'Consult with primary care physician about risk factors';
       }

       return $actions;
   }

   public function updateHealthProfile(User $user, array $data)
   {
       DB::transaction(function () use ($user, $data) {
           // Update health conditions
           if (isset($data['health_conditions'])) {
               $user->healthConditions()->sync($data['health_conditions']);
           }

           // Update allergies and medications
           $user->update([
               'allergies' => $data['allergies'] ?? $user->allergies,
               'medications' => $data['medications'] ?? $user->medications,
               'blood_type' => $data['blood_type'] ?? $user->blood_type,
               'primary_physician' => $data['primary_physician'] ?? $user->primary_physician
           ]);

           // Update vital signs
           if (isset($data['vital_signs'])) {
               $this->updateVitalSigns($user, $data['vital_signs']);
           }
       });
   }

   protected function getLatestVitalSign(User $user, string $type)
   {
       return $user->vitalSigns()
           ->where('type', $type)
           ->latest()
           ->first()
           ?->value;
   }

   protected function calculateBMI(User $user)
   {
       $weight = $this->getLatestVitalSign($user, 'weight');
       $height = $this->getLatestVitalSign($user, 'height');

       if (!$weight || !$height) {
           return null;
       }

       return round($weight / (($height / 100) ** 2), 1);
   }

   protected function getVaccinationStatus(User $user)
   {
       $vaccinations = $user->vaccinations()->with('vaccine')->get();
       
       return [
           'up_to_date' => $vaccinations->where('next_due_date', '>', now())->count(),
           'overdue_count' => $vaccinations->where('next_due_date', '<', now())->count(),
           'completed_count' => $vaccinations->whereNull('next_due_date')->count()
       ];
   }

   protected function getActiveConditions(User $user)
   {
       return $user->healthConditions()
           ->wherePivot('status', 'active')
           ->get();
   }

   protected function updateVitalSigns(User $user, array $vitalSigns)
   {
       foreach ($vitalSigns as $type => $value) {
           $user->vitalSigns()->create([
               'type' => $type,
               'value' => $value,
               'recorded_at' => now()
           ]);
       }
   }
}