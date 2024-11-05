<?php

namespace Database\Seeders;

use App\Models\Vaccination;
use App\Models\User;
use App\Models\Vaccine;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class VaccinationSeeder extends Seeder
{
    public function run()
    {
        // Get all users and vaccines
        $users = User::all();
        $vaccines = Vaccine::all();

        $vaccinations = [
            // Healthcare Worker (Sarah Johnson) - ID: 1
            [
                'user_id' => 1,
                'vaccine_id' => 1, // Flu
                'date_administered' => '2023-09-15',
                'next_due_date' => '2024-09-15',
                'notes' => 'Annual healthcare worker flu shot administered'
            ],
            [
                'user_id' => 1,
                'vaccine_id' => 2, // Tdap
                'date_administered' => '2023-05-20',
                'next_due_date' => '2033-05-20',
                'notes' => 'Healthcare worker required vaccination'
            ],
            [
                'user_id' => 1,
                'vaccine_id' => 10, // COVID-19
                'date_administered' => '2023-10-01',
                'next_due_date' => '2024-10-01',
                'notes' => 'Annual COVID booster'
            ],

            // Senior Citizen (Robert Smith) - ID: 2
            [
                'user_id' => 2,
                'vaccine_id' => 1, // Flu
                'date_administered' => '2023-10-01',
                'next_due_date' => '2024-10-01',
                'notes' => 'High-dose senior flu vaccine administered'
            ],
            [
                'user_id' => 2,
                'vaccine_id' => 5, // Zoster
                'date_administered' => '2023-06-15',
                'next_due_date' => '2023-09-15',
                'notes' => 'First dose of Shingrix series'
            ],
            [
                'user_id' => 2,
                'vaccine_id' => 6, // Pneumococcal
                'date_administered' => '2023-07-01',
                'next_due_date' => null,
                'notes' => 'PPSV23 administered'
            ],

            // Pregnant Woman (Emily Davis) - ID: 3
            [
                'user_id' => 3,
                'vaccine_id' => 1, // Flu
                'date_administered' => '2023-10-15',
                'next_due_date' => '2024-10-15',
                'notes' => 'Pregnancy-safe flu vaccine administered'
            ],
            [
                'user_id' => 3,
                'vaccine_id' => 2, // Tdap
                'date_administered' => '2024-02-15',
                'next_due_date' => '2034-02-15',
                'notes' => 'Administered during pregnancy week 28'
            ],

            // College Student (Michael Chen) - ID: 4
            [
                'user_id' => 4,
                'vaccine_id' => 3, // MMR
                'date_administered' => '2023-08-20',
                'next_due_date' => null,
                'notes' => 'Required for university enrollment'
            ],
            [
                'user_id' => 4,
                'vaccine_id' => 9, // Meningococcal
                'date_administered' => '2023-08-20',
                'next_due_date' => '2028-08-20',
                'notes' => 'Required for dormitory residence'
            ],

            // Immunocompromised Patient (Amanda Thompson) - ID: 5
            [
                'user_id' => 5,
                'vaccine_id' => 1, // Flu
                'date_administered' => '2023-09-01',
                'next_due_date' => '2024-09-01',
                'notes' => 'Modified protocol for immunocompromised patient'
            ],
            [
                'user_id' => 5,
                'vaccine_id' => 6, // Pneumococcal
                'date_administered' => '2023-06-15',
                'next_due_date' => '2028-06-15',
                'notes' => 'High-risk patient vaccination'
            ],

            // Cancer Patient (George Wilson) - ID: 6
            [
                'user_id' => 6,
                'vaccine_id' => 1, // Flu
                'date_administered' => '2023-09-25',
                'next_due_date' => '2024-09-25',
                'notes' => 'Post-cancer treatment vaccination'
            ],
            [
                'user_id' => 6,
                'vaccine_id' => 5, // Zoster
                'date_administered' => '2023-10-10',
                'next_due_date' => '2024-01-10',
                'notes' => 'First dose post-cancer treatment'
            ],

            // Diabetic Patient (Jessica Martinez) - ID: 7
            [
                'user_id' => 7,
                'vaccine_id' => 1, // Flu
                'date_administered' => '2023-09-30',
                'next_due_date' => '2024-09-30',
                'notes' => 'High-risk diabetic patient'
            ],
            [
                'user_id' => 7,
                'vaccine_id' => 6, // Pneumococcal
                'date_administered' => '2023-08-15',
                'next_due_date' => '2028-08-15',
                'notes' => 'Recommended for diabetes management'
            ],

            // Transplant Patient (Marcus Rodriguez) - ID: 8
            [
                'user_id' => 8,
                'vaccine_id' => 1, // Flu
                'date_administered' => '2024-01-15',
                'next_due_date' => '2025-01-15',
                'notes' => 'Post-transplant protocol followed'
            ],
            [
                'user_id' => 8,
                'vaccine_id' => 6, // Pneumococcal
                'date_administered' => '2023-12-01',
                'next_due_date' => '2028-12-01',
                'notes' => 'Immunocompromised schedule'
            ],

            // Mental Health Patient (Sophia Patel) - ID: 9
            [
                'user_id' => 9,
                'vaccine_id' => 1, // Flu
                'date_administered' => '2023-10-15',
                'next_due_date' => '2024-10-15',
                'notes' => 'Administered with anxiety protocol'
            ],
            [
                'user_id' => 9,
                'vaccine_id' => 2, // Tdap
                'date_administered' => '2023-11-01',
                'next_due_date' => '2033-11-01',
                'notes' => 'Routine booster'
            ],

            // Allergy Patient (Benjamin Novak) - ID: 10
            [
                'user_id' => 10,
                'vaccine_id' => 1, // Flu
                'date_administered' => '2023-10-01',
                'next_due_date' => '2024-10-01',
                'notes' => 'Administered under observation with pre-treatment'
            ],
            [
                'user_id' => 10,
                'vaccine_id' => 6, // Pneumococcal
                'date_administered' => '2023-09-15',
                'next_due_date' => '2028-09-15',
                'notes' => 'Split dose protocol for allergy patient'
            ]
        ];

        // Create the vaccination records
        foreach ($vaccinations as $vaccination) {
            Vaccination::create($vaccination);
        }
    }
}