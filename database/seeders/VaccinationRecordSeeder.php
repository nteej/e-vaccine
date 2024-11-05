<?php

namespace Database\Seeders;

use App\Models\VaccinationRecord;
use Illuminate\Database\Seeder;

class VaccinationRecordSeeder extends Seeder
{
    public function run()
    {
        $vaccinationRecords = [
            // 1. Healthcare Worker (Sarah Johnson) - ID: 1
            [
                'user_id' => 1,
                'vaccine_id' => 1, // Flu
                'administration_date' => '2023-09-15',
                'lot_number' => 'FL2023001',
                'administered_by' => 'Employee Health Services',
                'location' => 'General Hospital',
                'notes' => 'Annual healthcare worker flu shot'
            ],
            [
                'user_id' => 1,
                'vaccine_id' => 2, // Tdap
                'administration_date' => '2023-05-20',
                'lot_number' => 'TD2023045',
                'administered_by' => 'Employee Health Services',
                'location' => 'General Hospital',
                'notes' => 'Required healthcare worker booster'
            ],
            [
                'user_id' => 1,
                'vaccine_id' => 10, // COVID-19
                'administration_date' => '2023-10-01',
                'lot_number' => 'CV2023789',
                'administered_by' => 'Employee Health Services',
                'location' => 'General Hospital',
                'notes' => 'Annual COVID booster'
            ],

            // 2. Senior Citizen (Robert Smith) - ID: 2
            [
                'user_id' => 2,
                'vaccine_id' => 1, // Flu
                'administration_date' => '2023-10-01',
                'lot_number' => 'FL2023HD1',
                'administered_by' => 'Community Pharmacy',
                'location' => 'Walgreens',
                'notes' => 'High-dose senior flu vaccine'
            ],
            [
                'user_id' => 2,
                'vaccine_id' => 5, // Zoster
                'administration_date' => '2023-06-15',
                'lot_number' => 'ZOS202315',
                'administered_by' => 'Primary Care Office',
                'location' => 'Senior Care Clinic',
                'notes' => 'First dose of two-dose series'
            ],
            [
                'user_id' => 2,
                'vaccine_id' => 6, // Pneumococcal
                'administration_date' => '2023-07-01',
                'lot_number' => 'PCV202356',
                'administered_by' => 'Primary Care Office',
                'location' => 'Senior Care Clinic',
                'notes' => 'Age-appropriate pneumococcal vaccine'
            ],

            // 3. Pregnant Woman (Emily Davis) - ID: 3
            [
                'user_id' => 3,
                'vaccine_id' => 1, // Flu
                'administration_date' => '2023-10-15',
                'lot_number' => 'FL2023P12',
                'administered_by' => 'OB/GYN Office',
                'location' => 'Women\'s Health Center',
                'notes' => 'Pregnancy-safe flu vaccine'
            ],
            [
                'user_id' => 3,
                'vaccine_id' => 2, // Tdap
                'administration_date' => '2024-02-15',
                'lot_number' => 'TD2024P45',
                'administered_by' => 'OB/GYN Office',
                'location' => 'Women\'s Health Center',
                'notes' => 'Pregnancy-recommended Tdap'
            ],

            // 4. College Student (Michael Chen) - ID: 4
            [
                'user_id' => 4,
                'vaccine_id' => 3, // MMR
                'administration_date' => '2023-08-20',
                'lot_number' => 'MMR202389',
                'administered_by' => 'Student Health Services',
                'location' => 'University Health Center',
                'notes' => 'Required for university enrollment'
            ],
            [
                'user_id' => 4,
                'vaccine_id' => 9, // Meningococcal
                'administration_date' => '2023-08-20',
                'lot_number' => 'MEN202367',
                'administered_by' => 'Student Health Services',
                'location' => 'University Health Center',
                'notes' => 'Required for dormitory residence'
            ],

            // 5. Immunocompromised Traveler (Amanda Thompson) - ID: 5
            [
                'user_id' => 5,
                'vaccine_id' => 1, // Flu
                'administration_date' => '2023-09-01',
                'lot_number' => 'FL2023IC5',
                'administered_by' => 'Travel Clinic',
                'location' => 'International Health Center',
                'notes' => 'Modified for immunocompromised status'
            ],
            [
                'user_id' => 5,
                'vaccine_id' => 7, // Hepatitis A
                'administration_date' => '2023-06-15',
                'lot_number' => 'HEPA202334',
                'administered_by' => 'Travel Clinic',
                'location' => 'International Health Center',
                'notes' => 'Pre-travel series - dose 1'
            ],
            [
                'user_id' => 5,
                'vaccine_id' => 8, // Hepatitis B
                'administration_date' => '2023-06-15',
                'lot_number' => 'HEPB202345',
                'administered_by' => 'Travel Clinic',
                'location' => 'International Health Center',
                'notes' => 'Pre-travel series - dose 1'
            ],

            // 6. Elderly Cancer Survivor (George Wilson) - ID: 6
            [
                'user_id' => 6,
                'vaccine_id' => 1, // Flu
                'administration_date' => '2023-09-25',
                'lot_number' => 'FL2023HD8',
                'administered_by' => 'Oncology Clinic',
                'location' => 'Cancer Center',
                'notes' => 'Post-cancer treatment flu shot'
            ],
            [
                'user_id' => 6,
                'vaccine_id' => 6, // Pneumococcal
                'administration_date' => '2023-10-10',
                'lot_number' => 'PCV202378',
                'administered_by' => 'Oncology Clinic',
                'location' => 'Cancer Center',
                'notes' => 'Post-cancer pneumococcal vaccination'
            ],

            // 7. Young Adult with Chronic Conditions (Jessica Martinez) - ID: 7
            [
                'user_id' => 7,
                'vaccine_id' => 1, // Flu
                'administration_date' => '2023-09-30',
                'lot_number' => 'FL2023CC4',
                'administered_by' => 'Endocrinology Clinic',
                'location' => 'Diabetes Center',
                'notes' => 'Annual flu shot for diabetes patient'
            ],
            [
                'user_id' => 7,
                'vaccine_id' => 6, // Pneumococcal
                'administration_date' => '2023-08-15',
                'lot_number' => 'PCV202390',
                'administered_by' => 'Primary Care Office',
                'location' => 'Modern Health Center',
                'notes' => 'Recommended for diabetes'
            ],

            // 8. Multiple Organ Transplant (Marcus Rodriguez) - ID: 8
            [
                'user_id' => 8,
                'vaccine_id' => 1, // Flu
                'administration_date' => '2024-01-15',
                'lot_number' => 'FL2024TR1',
                'administered_by' => 'Transplant Clinic',
                'location' => 'University Hospital',
                'notes' => 'Modified protocol for transplant patient'
            ],
            [
                'user_id' => 8,
                'vaccine_id' => 6, // Pneumococcal
                'administration_date' => '2023-12-01',
                'lot_number' => 'PCV2023TR5',
                'administered_by' => 'Transplant Clinic',
                'location' => 'University Hospital',
                'notes' => 'Post-transplant protocol vaccination'
            ],

            // 9. Psychiatric Patient (Sophia Patel) - ID: 9
            [
                'user_id' => 9,
                'vaccine_id' => 1, // Flu
                'administration_date' => '2023-10-15',
                'lot_number' => 'FL2023MH2',
                'administered_by' => 'Mental Health Clinic',
                'location' => 'Integrated Health Center',
                'notes' => 'Administered with anxiety protocol'
            ],
            [
                'user_id' => 9,
                'vaccine_id' => 2, // Tdap
                'administration_date' => '2023-11-01',
                'lot_number' => 'TD2023MH5',
                'administered_by' => 'Mental Health Clinic',
                'location' => 'Integrated Health Center',
                'notes' => 'Administered with support staff'
            ],

            // 10. Severe Allergy Patient (Benjamin Novak) - ID: 10
            [
                'user_id' => 10,
                'vaccine_id' => 1, // Flu
                'administration_date' => '2023-10-01',
                'lot_number' => 'FL2023AL1',
                'administered_by' => 'Allergy Clinic',
                'location' => 'Immune System Center',
                'notes' => 'Administered under observation, pre-treated'
            ],
            [
                'user_id' => 10,
                'vaccine_id' => 6, // Pneumococcal
                'administration_date' => '2023-09-15',
                'lot_number' => 'PCV2023AL3',
                'administered_by' => 'Allergy Clinic',
                'location' => 'Immune System Center',
                'notes' => 'Split dose protocol for allergy patient'
            ]
        ];

        foreach ($vaccinationRecords as $record) {
            VaccinationRecord::create($record);
        }
    }
}

