<?php

namespace App\Http\Requests\ValidationRules;

class AdvancedHealthRules
{
    public static function getCompleteRules()
    {
        return [
            'allergies' => [
                'allergy_type' => ['required', 'in:food,medication,environmental,other'],
                'allergen' => ['required', 'string', 'max:255'],
                'reaction_severity' => ['required', 'in:mild,moderate,severe,life_threatening'],
                'diagnosis_date' => ['required', 'date', 'before_or_equal:today'],
                'symptoms' => ['required', 'array', 'min:1'],
                'symptoms.*' => ['string', 'max:255'],
                'emergency_plan' => ['required_if:reaction_severity,life_threatening', 'string'],
                'carrying_epipen' => ['required_if:reaction_severity,life_threatening', 'boolean']
            ],
            'medical_history' => [
                'surgeries' => ['nullable', 'array'],
                'surgeries.*.procedure' => ['required', 'string', 'max:255'],
                'surgeries.*.date' => ['required', 'date', 'before_or_equal:today'],
                'surgeries.*.hospital' => ['required', 'string', 'max:255'],
                'surgeries.*.surgeon' => ['required', 'string', 'max:255'],
                'surgeries.*.complications' => ['nullable', 'string'],
                
                'hospitalizations' => ['nullable', 'array'],
                'hospitalizations.*.reason' => ['required', 'string', 'max:255'],
                'hospitalizations.*.admission_date' => ['required', 'date', 'before_or_equal:today'],
                'hospitalizations.*.discharge_date' => ['required', 'date', 'after_or_equal:hospitalizations.*.admission_date'],
                'hospitalizations.*.hospital' => ['required', 'string', 'max:255'],
                
                'family_history' => ['nullable', 'array'],
                'family_history.*.condition' => ['required', 'string', 'max:255'],
                'family_history.*.relation' => ['required', 'in:parent,sibling,grandparent,child'],
                'family_history.*.age_of_onset' => ['nullable', 'integer', 'between:0,120']
            ],
            'lifestyle' => [
                'exercise_frequency' => ['nullable', 'in:never,rarely,weekly,several_times_week,daily'],
                'exercise_type' => ['required_if:exercise_frequency,weekly,several_times_week,daily', 'array'],
                'diet_restrictions' => ['nullable', 'array'],
                'smoking_status' => ['required', 'in:never,former,current'],
                'alcohol_consumption' => ['required', 'in:never,occasional,moderate,heavy'],
                'occupation_risks' => ['nullable', 'array'],
                'stress_level' => ['nullable', 'in:low,moderate,high'],
                'sleep_hours' => ['nullable', 'integer', 'between:1,24']
            ],
            'vaccination_preferences' => [
                'preferred_arm' => ['nullable', 'in:left,right'],
                'preferred_time' => ['nullable', 'date_format:H:i'],
                'preferred_days' => ['nullable', 'array'],
                'preferred_days.*' => ['in:monday,tuesday,wednesday,thursday,friday,saturday,sunday'],
                'preferred_location' => ['nullable', 'string', 'max:255'],
                'needle_phobia' => ['nullable', 'boolean'],
                'previous_reactions' => ['nullable', 'array'],
                'special_requirements' => ['nullable', 'string']
            ]
        ];
    }
}