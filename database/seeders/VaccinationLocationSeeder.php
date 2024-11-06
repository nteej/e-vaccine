<?php
namespace Database\Seeders;

use App\Models\VaccinationLocation;
use Illuminate\Database\Seeder;

class VaccinationLocationSeeder extends Seeder
{
    public function run()
    {
        $locations = [
            [
                'name' => 'City General Hospital Vaccination Center',
                'address' => '123 Medical Center Drive',
                'city' => 'New York',
                'state' => 'NY',
                'zip_code' => '10001',
                'phone' => '(212) 555-0123',
                'email' => 'vaccines@citygeneral.org',
                'operating_hours' => json_encode([
                    'Monday' => '8:00 AM - 6:00 PM',
                    'Tuesday' => '8:00 AM - 6:00 PM',
                    'Wednesday' => '8:00 AM - 6:00 PM',
                    'Thursday' => '8:00 AM - 6:00 PM',
                    'Friday' => '8:00 AM - 6:00 PM',
                    'Saturday' => '9:00 AM - 2:00 PM',
                    'Sunday' => 'Closed'
                ]),
                'is_active' => true,
                'location_type' => 'Hospital',
                'accepts_insurance' => true,
                'appointment_required' => true,
                'wheelchair_accessible' => true,
                'languages_spoken' => json_encode(['English', 'Spanish', 'Mandarin']),
                'additional_services' => json_encode(['Pediatric Care', 'Travel Vaccines', 'Flu Shots'])
            ],
            [
                'name' => 'Neighborhood Health Clinic',
                'address' => '456 Community Lane',
                'city' => 'Brooklyn',
                'state' => 'NY',
                'zip_code' => '11201',
                'phone' => '(718) 555-0456',
                'email' => 'info@neighborhoodhealth.org',
                'operating_hours' => json_encode([
                    'Monday' => '9:00 AM - 5:00 PM',
                    'Tuesday' => '9:00 AM - 5:00 PM',
                    'Wednesday' => '9:00 AM - 7:00 PM',
                    'Thursday' => '9:00 AM - 5:00 PM',
                    'Friday' => '9:00 AM - 5:00 PM',
                    'Saturday' => '10:00 AM - 2:00 PM',
                    'Sunday' => 'Closed'
                ]),
                'is_active' => true,
                'location_type' => 'Clinic',
                'accepts_insurance' => true,
                'appointment_required' => false,
                'wheelchair_accessible' => true,
                'languages_spoken' => json_encode(['English', 'Spanish', 'Russian']),
                'additional_services' => json_encode(['Walk-in Services', 'Flu Shots'])
            ],
            [
                'name' => 'Main Street Pharmacy',
                'address' => '789 Main Street',
                'city' => 'Queens',
                'state' => 'NY',
                'zip_code' => '11101',
                'phone' => '(718) 555-0789',
                'email' => 'vaccines@mainstreetpharmacy.com',
                'operating_hours' => json_encode([
                    'Monday' => '8:00 AM - 9:00 PM',
                    'Tuesday' => '8:00 AM - 9:00 PM',
                    'Wednesday' => '8:00 AM - 9:00 PM',
                    'Thursday' => '8:00 AM - 9:00 PM',
                    'Friday' => '8:00 AM - 9:00 PM',
                    'Saturday' => '9:00 AM - 7:00 PM',
                    'Sunday' => '10:00 AM - 6:00 PM'
                ]),
                'is_active' => true,
                'location_type' => 'Pharmacy',
                'accepts_insurance' => true,
                'appointment_required' => false,
                'wheelchair_accessible' => true,
                'languages_spoken' => json_encode(['English', 'Spanish', 'Korean']),
                'additional_services' => json_encode(['Prescription Services', 'Flu Shots', 'Health Screenings'])
            ],
            [
                'name' => 'Westside Medical Center',
                'address' => '321 Healthcare Plaza',
                'city' => 'Manhattan',
                'state' => 'NY',
                'zip_code' => '10023',
                'phone' => '(212) 555-0321',
                'email' => 'vaccines@westsidemed.com',
                'operating_hours' => json_encode([
                    'Monday' => '7:00 AM - 8:00 PM',
                    'Tuesday' => '7:00 AM - 8:00 PM',
                    'Wednesday' => '7:00 AM - 8:00 PM',
                    'Thursday' => '7:00 AM - 8:00 PM',
                    'Friday' => '7:00 AM - 8:00 PM',
                    'Saturday' => '8:00 AM - 4:00 PM',
                    'Sunday' => '9:00 AM - 2:00 PM'
                ]),
                'is_active' => true,
                'location_type' => 'Medical Center',
                'accepts_insurance' => true,
                'appointment_required' => true,
                'wheelchair_accessible' => true,
                'languages_spoken' => json_encode(['English', 'Spanish', 'French', 'Mandarin']),
                'additional_services' => json_encode(['Primary Care', 'Pediatrics', 'Travel Medicine', 'Flu Shots'])
            ],
            [
                'name' => 'Mobile Vaccination Unit',
                'address' => 'Various Locations',
                'city' => 'New York',
                'state' => 'NY',
                'zip_code' => '10001',
                'phone' => '(212) 555-9876',
                'email' => 'mobile@cityvaccines.org',
                'operating_hours' => json_encode([
                    'Monday' => '9:00 AM - 5:00 PM',
                    'Tuesday' => '9:00 AM - 5:00 PM',
                    'Wednesday' => '9:00 AM - 5:00 PM',
                    'Thursday' => '9:00 AM - 5:00 PM',
                    'Friday' => '9:00 AM - 5:00 PM',
                    'Saturday' => 'Varies',
                    'Sunday' => 'Varies'
                ]),
                'is_active' => true,
                'location_type' => 'Mobile Unit',
                'accepts_insurance' => true,
                'appointment_required' => true,
                'wheelchair_accessible' => true,
                'languages_spoken' => json_encode(['English', 'Spanish', 'Mandarin', 'Bengali']),
                'additional_services' => json_encode(['Community Outreach', 'Health Education'])
            ]
        ];

        foreach ($locations as $location) {
            VaccinationLocation::create($location);
        }
    }
}