<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\HealthCondition;
class HealthConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $conditions = [
            [
                'name' => 'Type 1 Diabetes',
                'code' => 'T1D',
                'category' => 'Endocrine',
                'description' => 'Autoimmune condition affecting insulin production',
                'risk_level' => 'high',
                'vaccination_implications' => json_encode([
                    'increased_infection_risk',
                    'slower_healing',
                    'requires_annual_flu_vaccine',
                    'pneumococcal_vaccine_recommended'
                ]),
                'monitoring_frequency' => 'monthly',
                'requires_specialist' => true,
                'contraindicated_vaccines' => json_encode([]),
                'recommended_vaccines' => json_encode([
                    'influenza',
                    'pneumococcal',
                    'hepatitis_b'
                ]),
                'special_instructions' => json_encode([
                    'monitor_blood_sugar_before_vaccination',
                    'schedule_morning_appointments',
                    'bring_glucose_monitoring_equipment'
                ]),
                'icd_10_code' => 'E10'
            ],
            [
                'name' => 'Rheumatoid Arthritis',
                'code' => 'RA',
                'category' => 'Autoimmune',
                'description' => 'Chronic inflammatory disorder affecting joints',
                'risk_level' => 'high',
                'vaccination_implications' => json_encode([
                    'immunosuppressed_due_to_treatment',
                    'live_vaccines_contraindicated',
                    'increased_infection_risk'
                ]),
                'monitoring_frequency' => 'quarterly',
                'requires_specialist' => true,
                'contraindicated_vaccines' => json_encode([
                    'live_attenuated_vaccines',
                    'mmr',
                    'varicella'
                ]),
                'recommended_vaccines' => json_encode([
                    'influenza',
                    'pneumococcal',
                    'hepatitis_b'
                ]),
                'special_instructions' => json_encode([
                    'coordinate_with_rheumatologist',
                    'timing_around_immunosuppressive_medications',
                    'monitor_disease_activity'
                ]),
                'icd_10_code' => 'M05'
            ],
            

            // New conditions...
            [
                'name' => 'Multiple Sclerosis',
                'code' => 'MS',
                'category' => 'Neurological',
                'description' => 'Chronic autoimmune disease affecting the central nervous system',
                'risk_level' => 'high',
                'vaccination_implications' => json_encode([
                    'disease_modifying_therapy_considerations',
                    'timing_critical_with_medications',
                    'increased_infection_risk',
                    'fever_may_worsen_symptoms'
                ]),
                'monitoring_frequency' => 'quarterly',
                'requires_specialist' => true,
                'contraindicated_vaccines' => json_encode([
                    'live_vaccines_during_immunosuppression',
                    'yellow_fever'
                ]),
                'recommended_vaccines' => json_encode([
                    'influenza',
                    'pneumococcal',
                    'hepatitis_b',
                    'shingles_if_age_appropriate'
                ]),
                'special_instructions' => json_encode([
                    'coordinate_timing_with_MS_medications',
                    'monitor_for_disease_exacerbation',
                    'consider_pre_medication_for_fever_prevention'
                ]),
                'icd_10_code' => 'G35'
            ],
            [
                'name' => 'Chronic Kidney Disease',
                'code' => 'CKD',
                'category' => 'Renal',
                'description' => 'Progressive loss of kidney function',
                'risk_level' => 'high',
                'vaccination_implications' => json_encode([
                    'reduced_vaccine_response',
                    'higher_doses_may_be_needed',
                    'dialysis_schedule_coordination'
                ]),
                'monitoring_frequency' => 'monthly',
                'requires_specialist' => true,
                'contraindicated_vaccines' => json_encode([]),
                'recommended_vaccines' => json_encode([
                    'influenza',
                    'pneumococcal',
                    'hepatitis_b',
                    'tdap'
                ]),
                'special_instructions' => json_encode([
                    'schedule_around_dialysis',
                    'monitor_kidney_function',
                    'check_hepatitis_b_antibody_levels'
                ]),
                'icd_10_code' => 'N18'
            ],
            [
                'name' => 'Asthma',
                'code' => 'ASTH',
                'category' => 'Respiratory',
                'description' => 'Chronic inflammatory disease of the airways',
                'risk_level' => 'medium',
                'vaccination_implications' => json_encode([
                    'increased_risk_of_respiratory_infections',
                    'may_need_pre_treatment_with_bronchodilator',
                    'annual_flu_shot_essential'
                ]),
                'monitoring_frequency' => 'quarterly',
                'requires_specialist' => false,
                'contraindicated_vaccines' => json_encode([]),
                'recommended_vaccines' => json_encode([
                    'influenza',
                    'pneumococcal',
                    'covid19'
                ]),
                'special_instructions' => json_encode([
                    'ensure_asthma_well_controlled',
                    'bring_rescue_inhaler',
                    'monitor_peak_flow_before_vaccination'
                ]),
                'icd_10_code' => 'J45'
            ],
            [
                'name' => 'Systemic Lupus Erythematosus',
                'code' => 'SLE',
                'category' => 'Autoimmune',
                'description' => 'Systemic autoimmune disease affecting multiple organs',
                'risk_level' => 'high',
                'vaccination_implications' => json_encode([
                    'avoid_live_vaccines_during_immunosuppression',
                    'increased_infection_risk',
                    'may_trigger_disease_flares'
                ]),
                'monitoring_frequency' => 'monthly',
                'requires_specialist' => true,
                'contraindicated_vaccines' => json_encode([
                    'live_vaccines_during_active_disease',
                    'yellow_fever'
                ]),
                'recommended_vaccines' => json_encode([
                    'influenza',
                    'pneumococcal',
                    'hepatitis_b',
                    'hpv'
                ]),
                'special_instructions' => json_encode([
                    'monitor_disease_activity',
                    'coordinate_with_rheumatologist',
                    'avoid_during_flares'
                ]),
                'icd_10_code' => 'M32'
            ],
            [
                'name' => 'Inflammatory Bowel Disease',
                'code' => 'IBD',
                'category' => 'Gastrointestinal',
                'description' => 'Chronic inflammation of the digestive tract',
                'risk_level' => 'high',
                'vaccination_implications' => json_encode([
                    'immunosuppression_considerations',
                    'timing_with_biologics',
                    'increased_infection_risk'
                ]),
                'monitoring_frequency' => 'quarterly',
                'requires_specialist' => true,
                'contraindicated_vaccines' => json_encode([
                    'live_vaccines_during_immunosuppression'
                ]),
                'recommended_vaccines' => json_encode([
                    'influenza',
                    'pneumococcal',
                    'hepatitis_b',
                    'tdap',
                    'hpv'
                ]),
                'special_instructions' => json_encode([
                    'coordinate_with_biologics_schedule',
                    'assess_disease_activity',
                    'monitor_for_flares'
                ]),
                'icd_10_code' => 'K50'
            ],
            [
                'name' => 'Solid Organ Transplant',
                'code' => 'SOT',
                'category' => 'Transplant',
                'description' => 'Post-organ transplant immunosuppression',
                'risk_level' => 'critical',
                'vaccination_implications' => json_encode([
                    'strict_live_vaccine_contraindications',
                    'reduced_vaccine_response',
                    'timing_with_immunosuppression_critical'
                ]),
                'monitoring_frequency' => 'weekly',
                'requires_specialist' => true,
                'contraindicated_vaccines' => json_encode([
                    'all_live_vaccines',
                    'mmr',
                    'varicella',
                    'yellow_fever'
                ]),
                'recommended_vaccines' => json_encode([
                    'influenza',
                    'pneumococcal',
                    'hepatitis_b',
                    'tdap'
                ]),
                'special_instructions' => json_encode([
                    'complete_vaccines_before_transplant_if_possible',
                    'monitor_immunosuppression_levels',
                    'coordinate_with_transplant_team'
                ]),
                'icd_10_code' => 'Z94'
            ],
            [
                'name' => 'Cancer on Active Treatment',
                'code' => 'CAT',
                'category' => 'Oncology',
                'description' => 'Malignancy requiring chemotherapy or immunotherapy',
                'risk_level' => 'critical',
                'vaccination_implications' => json_encode([
                    'severely_immunocompromised',
                    'timing_around_chemotherapy_cycles',
                    'reduced_vaccine_efficacy'
                ]),
                'monitoring_frequency' => 'weekly',
                'requires_specialist' => true,
                'contraindicated_vaccines' => json_encode([
                    'all_live_vaccines',
                    'specific_timing_restrictions'
                ]),
                'recommended_vaccines' => json_encode([
                    'influenza',
                    'pneumococcal',
                    'hepatitis_b'
                ]),
                'special_instructions' => json_encode([
                    'coordinate_with_chemotherapy_schedule',
                    'monitor_blood_counts',
                    'assess_immune_status',
                    'family_member_vaccination_important'
                ]),
                'icd_10_code' => 'Z51.11'
            ],
            [
                'name' => 'Advanced Heart Failure',
                'code' => 'AHF',
                'category' => 'Cardiovascular',
                'description' => 'Severe cardiac dysfunction requiring specialized care',
                'risk_level' => 'high',
                'vaccination_implications' => json_encode([
                    'increased_risk_of_complications',
                    'fluid_status_monitoring',
                    'cardiovascular_stability_important'
                ]),
                'monitoring_frequency' => 'monthly',
                'requires_specialist' => true,
                'contraindicated_vaccines' => json_encode([]),
                'recommended_vaccines' => json_encode([
                    'influenza',
                    'pneumococcal',
                    'covid19'
                ]),
                'special_instructions' => json_encode([
                    'monitor_vital_signs',
                    'assess_fluid_status',
                    'consider_scheduling_early_in_day',
                    'have_emergency_protocols_ready'
                ]),
                'icd_10_code' => 'I50'
            ]
            
        ];

        foreach ($conditions as $condition) {
            HealthCondition::create($condition);
        }
    }
}
