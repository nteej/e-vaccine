<?php
namespace App\Http\Requests\ValidationRules;

class HealthDataRules
{
    public static function getMedicalDataRules()
    {
        return [
            'medical_conditions' => [
                'chronic_conditions' => ['nullable', 'array'],
                'chronic_conditions.*' => ['exists:health_conditions,id'],
                'condition_onset_dates' => ['required_with:chronic_conditions', 'array'],
                'condition_onset_dates.*' => ['date', 'before_or_equal:today'],
                'condition_severity' => ['required_with:chronic_conditions', 'array'],
                'condition_severity.*' => ['in:mild,moderate,severe'],
            ],
            'vital_signs' => [
                'blood_pressure_systolic' => ['nullable', 'integer', 'between:60,250'],
                'blood_pressure_diastolic' => ['nullable', 'integer', 'between:40,150'],
                'heart_rate' => ['nullable', 'integer', 'between:40,200'],
                'temperature' => ['nullable', 'numeric', 'between:35,42'],
                'respiratory_rate' => ['nullable', 'integer', 'between:8,40'],
                'oxygen_saturation' => ['nullable', 'integer', 'between:70,100'],
            ],
            'laboratory_results' => [
                'test_date' => ['nullable', 'date', 'before_or_equal:today'],
                'test_type' => ['required_with:test_date', 'string'],
                'test_result' => ['required_with:test_date', 'string'],
                'reference_range' => ['nullable', 'string'],
            ],
            'medications' => [
                'name' => ['required', 'string', 'max:255'],
                'dosage' => ['required', 'string', 'max:50'],
                'frequency' => ['required', 'in:daily,twice_daily,three_times_daily,weekly,as_needed'],
                'start_date' => ['required', 'date'],
                'end_date' => ['nullable', 'date', 'after:start_date'],
                'prescribing_doctor' => ['required', 'string', 'max:255'],
                'pharmacy' => ['nullable', 'string', 'max:255'],
                'side_effects' => ['nullable', 'array'],
                'side_effects.*' => ['string', 'max:255'],
            ]
        ];
    }
}
