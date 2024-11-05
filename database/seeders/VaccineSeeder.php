<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Vaccine;
class VaccineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vaccines = [
            [
                'name' => 'Influenza (Flu)',
                'description' => 'Annual flu vaccination recommended for all adults',
                'recommended_age_start' => 18,
                'recommended_age_end' => null,
                'frequency' => 'yearly',
                'risk_factors' => json_encode([
                    'diabetes',
                    'heart_disease',
                    'asthma',
                    'immunocompromised',
                    'healthcare_worker',
                    'pregnant'
                ]),
                'contraindications' => json_encode([
                    'severe_allergic_reaction',
                    'guillain_barre_syndrome'
                ]),
                'priority_level' => 'high'
            ],
            [
                'name' => 'Td/Tdap (Tetanus, Diphtheria, Pertussis)',
                'description' => 'One dose of Tdap, then Td or Tdap booster every 10 years',
                'recommended_age_start' => 18,
                'recommended_age_end' => null,
                'frequency' => 'every_10_years',
                'risk_factors' => null, // Everyone needs this
                'contraindications' => json_encode([
                    'severe_allergic_reaction',
                    'encephalopathy'
                ]),
                'priority_level' => 'medium'
            ],
            [
                'name' => 'MMR (Measles, Mumps, Rubella)',
                'description' => '1-2 doses if born after 1957',
                'recommended_age_start' => 18,
                'recommended_age_end' => 60,
                'frequency' => 'once',
                'risk_factors' => json_encode([
                    'college_student',
                    'healthcare_worker',
                    'international_traveler'
                ]),
                'contraindications' => json_encode([
                    'pregnant',
                    'immunocompromised'
                ]),
                'priority_level' => 'medium'
            ],
            [
                'name' => 'Varicella (Chickenpox)',
                'description' => '2 doses if no history of chickenpox',
                'recommended_age_start' => 18,
                'recommended_age_end' => 40,
                'frequency' => 'twice',
                'risk_factors' => json_encode([
                    'healthcare_worker',
                    'teacher',
                    'childcare_worker'
                ]),
                'contraindications' => json_encode([
                    'pregnant',
                    'immunocompromised'
                ]),
                'priority_level' => 'medium'
            ],
            [
                'name' => 'Zoster (Shingles)',
                'description' => 'Two doses of RZV for adults 50 years and older',
                'recommended_age_start' => 50,
                'recommended_age_end' => null,
                'frequency' => 'twice_once',
                'risk_factors' => null,
                'contraindications' => json_encode([
                    'severe_allergic_reaction',
                    'current_shingles_outbreak'
                ]),
                'priority_level' => 'medium'
            ],
            [
                'name' => 'Pneumococcal (PPSV23/PCV13)',
                'description' => 'One or more doses based on risk factors and age',
                'recommended_age_start' => 65,
                'recommended_age_end' => null,
                'frequency' => 'varies',
                'risk_factors' => json_encode([
                    'diabetes',
                    'heart_disease',
                    'lung_disease',
                    'immunocompromised',
                    'smoker'
                ]),
                'contraindications' => json_encode([
                    'severe_allergic_reaction'
                ]),
                'priority_level' => 'high'
            ],
            [
                'name' => 'Hepatitis A',
                'description' => 'Two doses for specific risk factors',
                'recommended_age_start' => 18,
                'recommended_age_end' => null,
                'frequency' => 'twice_once',
                'risk_factors' => json_encode([
                    'chronic_liver_disease',
                    'international_traveler',
                    'men_who_have_sex_with_men',
                    'drug_use'
                ]),
                'contraindications' => json_encode([
                    'severe_allergic_reaction'
                ]),
                'priority_level' => 'medium'
            ],
            [
                'name' => 'Hepatitis B',
                'description' => 'Three doses for specific risk factors',
                'recommended_age_start' => 18,
                'recommended_age_end' => null,
                'frequency' => 'three_times_once',
                'risk_factors' => json_encode([
                    'healthcare_worker',
                    'diabetes',
                    'chronic_liver_disease',
                    'hiv_positive',
                    'multiple_sexual_partners'
                ]),
                'contraindications' => json_encode([
                    'severe_allergic_reaction'
                ]),
                'priority_level' => 'medium'
            ],
            [
                'name' => 'Meningococcal ACWY',
                'description' => 'One or more doses for specific risk factors',
                'recommended_age_start' => 18,
                'recommended_age_end' => 21,
                'frequency' => 'varies',
                'risk_factors' => json_encode([
                    'college_student',
                    'military_recruit',
                    'asplenia',
                    'complement_deficiency'
                ]),
                'contraindications' => json_encode([
                    'severe_allergic_reaction'
                ]),
                'priority_level' => 'medium'
            ],
            [
                'name' => 'COVID-19',
                'description' => 'Primary series plus recommended boosters',
                'recommended_age_start' => 18,
                'recommended_age_end' => null,
                'frequency' => 'yearly',
                'risk_factors' => null, // Everyone needs this
                'contraindications' => json_encode([
                    'severe_allergic_reaction',
                    'myocarditis_history'
                ]),
                'priority_level' => 'high'
            ],
            [
                'name' => 'HPV (Human Papillomavirus)',
                'description' => 'Three doses for adults through age 26',
                'recommended_age_start' => 18,
                'recommended_age_end' => 26,
                'frequency' => 'three_times_once',
                'risk_factors' => null,
                'contraindications' => json_encode([
                    'pregnant',
                    'severe_allergic_reaction'
                ]),
                'priority_level' => 'medium'
            ]
        ];

        foreach ($vaccines as $vaccine) {
            Vaccine::create($vaccine);
        }
    }
}
