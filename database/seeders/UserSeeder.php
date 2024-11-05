<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\MedicalHistory;
use App\Models\VaccinationRecord;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
class UserSeeder extends Seeder
{
    private function createMedicalHistory($userId, $history)
    {
        foreach ($history as $record) {
            MedicalHistory::create([
                "user_id" => $userId,
                "condition" => $record["condition"],
                "diagnosis_date" => $record["diagnosis_date"],
                "status" => $record["status"],
                "treating_physician" => $record["physician"],
                "notes" => $record["notes"],
            ]);
        }
    }

    private function createVaccinationHistory($userId, $vaccinations)
    {
        foreach ($vaccinations as $vaccination) {
            VaccinationRecord::create([
                "user_id" => $userId,
                "vaccine_id" => $vaccination["vaccine_id"],
                "administration_date" => $vaccination["date"],
                "lot_number" => $vaccination["lot"],
                "administered_by" => $vaccination["provider"],
                "location" => $vaccination["location"],
                "notes" => $vaccination["notes"],
            ]);
        }
    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            // 1. Healthcare Worker with Asthma
            [
                "personal" => [
                    "first_name" => "Sarah",
                    "last_name" => "Johnson",
                    "email" => "sarah.johnson@email.com",
                    "password" => Hash::make("password123"),
                    "date_of_birth" => "1995-03-15",
                    "gender" => "female",
                    "phone_number" => "555-0101",
                    "address" =>
                        "123 Hospital Street, Medical District, NY 10001",
                    "emergency_contact_name" => "John Johnson",
                    "emergency_contact_phone" => "555-0102",
                    "health_conditions" => json_encode(["asthma"]),
                    "allergies" => json_encode(["penicillin"]),
                    "lifestyle_factors" => json_encode([
                        "healthcare_worker",
                        "frequent_traveler",
                        "night_shift_worker",
                        "exposure_to_patients",
                    ]),
                    "primary_physician" => "Dr. Michael Brown",
                    "blood_type" => "O+",
                    "medications" => json_encode([
                        "albuterol inhaler",
                        "fluticasone inhaler",
                    ]),
                    "is_healthcare_worker" => true,
                    "is_pregnant" => false,
                    "email_verified_at" => now(),
                ],
                "medical_history" => [
                    [
                        "condition" => "Asthma",
                        "diagnosis_date" => "2005-06-15",
                        "status" => "controlled",
                        "physician" => "Dr. Michael Brown",
                        "notes" =>
                            "Mild persistent asthma, well controlled with inhalers",
                    ],
                ],
                "vaccination_history" => [
                    [
                        "vaccine_id" => 1,
                        "date" => "2023-09-15",
                        "lot" => "FL2023001",
                        "provider" => "Employee Health Services",
                        "location" => "General Hospital",
                        "notes" => "Annual flu shot",
                    ],
                ],
            ],

            // 2. Senior with Multiple Conditions
            [
                "personal" => [
                    "first_name" => "Robert",
                    "last_name" => "Smith",
                    "email" => "robert.smith@email.com",
                    "password" => Hash::make("password123"),
                    "date_of_birth" => "1950-08-22",
                    "gender" => "male",
                    "phone_number" => "555-0103",
                    "address" =>
                        "456 Elder Avenue, Retirement Valley, FL 33101",
                    "emergency_contact_name" => "Mary Smith",
                    "emergency_contact_phone" => "555-0104",
                    "health_conditions" => json_encode([
                        "diabetes",
                        "heart_disease",
                        "hypertension",
                        "high_cholesterol",
                    ]),
                    "allergies" => json_encode(["sulfa", "contrast_dye"]),
                    "lifestyle_factors" => json_encode([
                        "retired",
                        "limited_mobility",
                        "senior_community_resident",
                        "regular_medical_appointments",
                    ]),
                    "primary_physician" => "Dr. Sarah Wilson",
                    "blood_type" => "A+",
                    "medications" => json_encode([
                        "metformin",
                        "lisinopril",
                        "aspirin",
                        "atorvastatin",
                        "glipizide",
                    ]),
                    "is_healthcare_worker" => false,
                    "is_pregnant" => false,
                    "email_verified_at" => now(),
                ],
                "medical_history" => [
                    [
                        "condition" => "Type 2 Diabetes",
                        "diagnosis_date" => "2000-03-10",
                        "status" => "managed",
                        "physician" => "Dr. Sarah Wilson",
                        "notes" => "HbA1c maintained around 7.0",
                    ],
                    [
                        "condition" => "Coronary Artery Disease",
                        "diagnosis_date" => "2010-11-15",
                        "status" => "stable",
                        "physician" => "Dr. Cardiology Specialist",
                        "notes" => "History of stent placement",
                    ],
                ],
                "vaccination_history" => [
                    [
                        "vaccine_id" => 1,
                        "date" => "2023-10-01",
                        "lot" => "FL2023002",
                        "provider" => "Community Pharmacy",
                        "location" => "Walgreens",
                        "notes" => "High-dose senior flu vaccine",
                    ],
                ],
            ],

            // 3. Pregnant Woman
            [
                "personal" => [
                    "first_name" => "Emily",
                    "last_name" => "Davis",
                    "email" => "emily.davis@email.com",
                    "password" => Hash::make("password123"),
                    "date_of_birth" => "1992-11-30",
                    "gender" => "female",
                    "phone_number" => "555-0105",
                    "address" => "789 Family Road, Suburbia, CA 90210",
                    "emergency_contact_name" => "James Davis",
                    "emergency_contact_phone" => "555-0106",
                    "health_conditions" => json_encode([
                        "gestational_diabetes",
                    ]),
                    "allergies" => json_encode(["latex"]),
                    "lifestyle_factors" => json_encode([
                        "pregnant",
                        "prenatal_yoga",
                        "first_pregnancy",
                        "works_with_children",
                    ]),
                    "primary_physician" => "Dr. Lisa Anderson",
                    "blood_type" => "B+",
                    "medications" => json_encode([
                        "prenatal_vitamins",
                        "folic_acid",
                        "iron_supplements",
                    ]),
                    "is_healthcare_worker" => false,
                    "is_pregnant" => true,
                    "email_verified_at" => now(),
                ],
                "medical_history" => [
                    [
                        "condition" => "Pregnancy",
                        "diagnosis_date" => "2024-02-15",
                        "status" => "active",
                        "physician" => "Dr. Lisa Anderson",
                        "notes" => "24 weeks pregnant, due date August 2024",
                    ],
                    [
                        "condition" => "Gestational Diabetes",
                        "diagnosis_date" => "2024-04-01",
                        "status" => "monitored",
                        "physician" => "Dr. Lisa Anderson",
                        "notes" =>
                            "Diet controlled, regular glucose monitoring",
                    ],
                ],
                "vaccination_history" => [
                    [
                        "vaccine_id" => 2,
                        "date" => "2024-03-15",
                        "lot" => "TD2024001",
                        "provider" => "OB/GYN Clinic",
                        "location" => 'Women\'s Health Center',
                        "notes" => "Tdap during pregnancy",
                    ],
                ],
            ],
            // 4. College Student
            [
                "personal" => [
                    "first_name" => "Michael",
                    "last_name" => "Chen",
                    "email" => "michael.chen@email.com",
                    "password" => Hash::make("password123"),
                    "date_of_birth" => "2003-05-17",
                    "gender" => "male",
                    "phone_number" => "555-0107",
                    "address" => "101 Campus Drive, University Town, MA 02138",
                    "emergency_contact_name" => "Wei Chen",
                    "emergency_contact_phone" => "555-0108",
                    "health_conditions" => json_encode([
                        "seasonal_allergies",
                        "mild_anxiety",
                    ]),
                    "allergies" => json_encode(["pollen", "ragweed"]),
                    "lifestyle_factors" => json_encode([
                        "college_student",
                        "dorm_resident",
                        "varsity_athlete",
                        "communal_living",
                        "frequent_gym_user",
                        "campus_dining",
                    ]),
                    "primary_physician" => "Dr. Campus Health",
                    "blood_type" => "AB+",
                    "medications" => json_encode([
                        "cetirizine",
                        "nasal_steroid_spray",
                    ]),
                    "is_healthcare_worker" => false,
                    "is_pregnant" => false,
                    "email_verified_at" => now(),
                ],
                "medical_history" => [
                    [
                        "condition" => "Seasonal Allergies",
                        "diagnosis_date" => "2015-03-20",
                        "status" => "seasonal",
                        "physician" => "Dr. Primary Care",
                        "notes" =>
                            "Spring and fall allergies, managed with antihistamines",
                    ],
                    [
                        "condition" => "Anxiety",
                        "diagnosis_date" => "2022-09-01",
                        "status" => "mild",
                        "physician" => "Campus Health Services",
                        "notes" => "Stress-related anxiety during exam periods",
                    ],
                ],
                "vaccination_history" => [
                    [
                        "vaccine_id" => 1,
                        "date" => "2023-09-15",
                        "lot" => "FL2023301",
                        "provider" => "Campus Health Services",
                        "location" => "University Health Center",
                        "notes" => "Required for university enrollment",
                    ],
                    [
                        "vaccine_id" => 3,
                        "date" => "2023-08-20",
                        "lot" => "MEN2023105",
                        "provider" => "Campus Health Services",
                        "location" => "University Health Center",
                        "notes" =>
                            "Meningitis vaccine required for dorm residence",
                    ],
                ],
            ],

            // 5. International Traveler with Immunocompromised Condition
            [
                "personal" => [
                    "first_name" => "Amanda",
                    "last_name" => "Thompson",
                    "email" => "amanda.thompson@email.com",
                    "password" => Hash::make("password123"),
                    "date_of_birth" => "1988-12-03",
                    "gender" => "female",
                    "phone_number" => "555-0109",
                    "address" => "202 Global Lane, World City, TX 75001",
                    "emergency_contact_name" => "Peter Thompson",
                    "emergency_contact_phone" => "555-0110",
                    "health_conditions" => json_encode([
                        "immunocompromised",
                        "rheumatoid_arthritis",
                        "recurring_bronchitis",
                        "chronic_fatigue",
                    ]),
                    "allergies" => json_encode([
                        "shellfish",
                        "penicillin",
                        "sulfa_drugs",
                    ]),
                    "lifestyle_factors" => json_encode([
                        "frequent_traveler",
                        "international_business",
                        "multiple_time_zones",
                        "variable_climate_exposure",
                        "high_stress_occupation",
                        "irregular_sleep_schedule",
                    ]),
                    "primary_physician" => "Dr. Global Health",
                    "blood_type" => "O-",
                    "medications" => json_encode([
                        "adalimumab",
                        "methotrexate",
                        "folic_acid",
                        "vitamin_D",
                        "prophylactic_antibiotics",
                    ]),
                    "is_healthcare_worker" => false,
                    "is_pregnant" => false,
                    "email_verified_at" => now(),
                ],
                "medical_history" => [
                    [
                        "condition" => "Rheumatoid Arthritis",
                        "diagnosis_date" => "2015-06-15",
                        "status" => "managed with biologics",
                        "physician" => "Dr. Rheumatology Specialist",
                        "notes" =>
                            "Moderate disease activity, controlled with biologics",
                    ],
                    [
                        "condition" => "Immunodeficiency",
                        "diagnosis_date" => "2016-03-20",
                        "status" => "ongoing",
                        "physician" => "Dr. Immunology Specialist",
                        "notes" =>
                            "Secondary to RA treatment, requires careful vaccination planning",
                    ],
                    [
                        "condition" => "Recurring Bronchitis",
                        "diagnosis_date" => "2018-11-30",
                        "status" => "intermittent",
                        "physician" => "Dr. Pulmonologist",
                        "notes" =>
                            "Requires prophylactic antibiotics during travel",
                    ],
                ],
                "vaccination_history" => [
                    [
                        "vaccine_id" => 1,
                        "date" => "2023-10-01",
                        "lot" => "FL2023405",
                        "provider" => "Travel Clinic",
                        "location" => "International Health Center",
                        "notes" => "Pre-travel vaccination series",
                    ],
                    [
                        "vaccine_id" => 7,
                        "date" => "2023-06-15",
                        "lot" => "HEP2023202",
                        "provider" => "Travel Clinic",
                        "location" => "International Health Center",
                        "notes" =>
                            "Hepatitis A series for international travel",
                    ],
                ],
            ],

            // 6. Elderly with Recent Cancer History
            [
                "personal" => [
                    "first_name" => "George",
                    "last_name" => "Wilson",
                    "email" => "george.wilson@email.com",
                    "password" => Hash::make("password123"),
                    "date_of_birth" => "1945-02-28",
                    "gender" => "male",
                    "phone_number" => "555-0111",
                    "address" => "303 Senior Court, Elder Springs, AZ 85001",
                    "emergency_contact_name" => "Susan Wilson",
                    "emergency_contact_phone" => "555-0112",
                    "health_conditions" => json_encode([
                        "cancer_survivor",
                        "osteoporosis",
                        "hypothyroidism",
                        "hearing_loss",
                        "cataracts",
                    ]),
                    "allergies" => json_encode(["iodine", "codeine"]),
                    "lifestyle_factors" => json_encode([
                        "limited_mobility",
                        "assisted_living_resident",
                        "regular_physical_therapy",
                        "social_senior_groups",
                        "dietary_restrictions",
                    ]),
                    "primary_physician" => "Dr. Elder Care",
                    "blood_type" => "A-",
                    "medications" => json_encode([
                        "levothyroxine",
                        "alendronate",
                        "calcium_supplements",
                        "vitamin_D",
                        "multivitamin_senior",
                    ]),
                    "is_healthcare_worker" => false,
                    "is_pregnant" => false,
                    "email_verified_at" => now(),
                ],
                "medical_history" => [
                    [
                        "condition" => "Colon Cancer",
                        "diagnosis_date" => "2022-05-15",
                        "status" => "remission",
                        "physician" => "Dr. Oncology Specialist",
                        "notes" =>
                            "Complete remission after surgery and chemotherapy",
                    ],
                    [
                        "condition" => "Osteoporosis",
                        "diagnosis_date" => "2019-03-10",
                        "status" => "managed",
                        "physician" => "Dr. Endocrinologist",
                        "notes" =>
                            "Regular DEXA scans, maintained on bisphosphonates",
                    ],
                    [
                        "condition" => "Hypothyroidism",
                        "diagnosis_date" => "2015-11-20",
                        "status" => "controlled",
                        "physician" => "Dr. Endocrinologist",
                        "notes" => "Stable on current levothyroxine dose",
                    ],
                ],
                "vaccination_history" => [
                    [
                        "vaccine_id" => 1,
                        "date" => "2023-09-25",
                        "lot" => "FL2023506",
                        "provider" => "Senior Care Clinic",
                        "location" => "Elder Springs Medical Center",
                        "notes" => "High-dose senior flu vaccine",
                    ],
                    [
                        "vaccine_id" => 5,
                        "date" => "2023-07-10",
                        "lot" => "ZOS2023103",
                        "provider" => "Senior Care Clinic",
                        "location" => "Elder Springs Medical Center",
                        "notes" => "Shingles vaccine post-cancer treatment",
                    ],
                ],
            ],

            // 7. Young Adult with Chronic Conditions
            [
                "personal" => [
                    "first_name" => "Jessica",
                    "last_name" => "Martinez",
                    "email" => "jessica.martinez@email.com",
                    "password" => Hash::make("password123"),
                    "date_of_birth" => "1997-09-14",
                    "gender" => "female",
                    "phone_number" => "555-0113",
                    "address" => "404 Young Street, Modern City, IL 60601",
                    "emergency_contact_name" => "Carlos Martinez",
                    "emergency_contact_phone" => "555-0114",
                    "health_conditions" => json_encode([
                        "type_1_diabetes",
                        "celiac_disease",
                        "hashimotos_thyroiditis",
                        "mild_depression",
                    ]),
                    "allergies" => json_encode(["gluten", "dairy", "latex"]),
                    "lifestyle_factors" => json_encode([
                        "active_lifestyle",
                        "gym_member",
                        "competitive_runner",
                        "health_blogger",
                        "support_group_leader",
                        "remote_worker",
                    ]),
                    "primary_physician" => "Dr. Young Adult Med",
                    "blood_type" => "B-",
                    "medications" => json_encode([
                        "insulin_pump",
                        "levothyroxine",
                        "vitamin_B12",
                        "vitamin_D",
                        "iron_supplements",
                        "ssri_antidepressant",
                    ]),
                    "is_healthcare_worker" => false,
                    "is_pregnant" => false,
                    "email_verified_at" => now(),
                ],
                "medical_history" => [
                    [
                        "condition" => "Type 1 Diabetes",
                        "diagnosis_date" => "2005-03-15",
                        "status" => "managed with insulin pump",
                        "physician" => "Dr. Endocrinologist",
                        "notes" => "Good control with carb counting and CGM",
                    ],
                    [
                        "condition" => "Celiac Disease",
                        "diagnosis_date" => "2015-08-20",
                        "status" => "controlled with diet",
                        "physician" => "Dr. Gastroenterologist",
                        "notes" =>
                            "Strict gluten-free diet, regular antibody monitoring",
                    ],
                    [
                        "condition" => "Hashimotos Thyroiditis",
                        "diagnosis_date" => "2018-11-30",
                        "status" => "stable",
                        "physician" => "Dr. Endocrinologist",
                        "notes" => "Annual thyroid function monitoring",
                    ],
                ],
                "vaccination_history" => [
                    [
                        "vaccine_id" => 1,
                        "date" => "2023-09-30",
                        "lot" => "FL2023607",
                        "provider" => "Primary Care Clinic",
                        "location" => "Modern Health Center",
                        "notes" => "Annual flu shot for high-risk patient",
                    ],
                    [
                        "vaccine_id" => 6,
                        "date" => "2023-08-15",
                        "lot" => "PNE2023104",
                        "provider" => "Primary Care Clinic",
                        "location" => "Modern Health Center",
                        "notes" =>
                            "Pneumococcal vaccine due to chronic conditions",
                    ],
                ],
            ],

            // Complex Autoimmune Case
            [
                "personal" => [
                    "first_name" => "Diana",
                    "last_name" => "Romano",
                    "email" => "diana.romano@email.com",
                    "password" => Hash::make("password123"),
                    "date_of_birth" => "1985-04-12",
                    "gender" => "female",
                    "phone_number" => "555-0115",
                    "address" => "505 Immune Street, Medical City, CA 94301",
                    "emergency_contact_name" => "Marco Romano",
                    "emergency_contact_phone" => "555-0116",
                    "health_conditions" => json_encode([
                        "lupus",
                        "rheumatoid_arthritis",
                        "fibromyalgia",
                        "celiac_disease",
                    ]),
                    "allergies" => json_encode([
                        "latex",
                        "penicillin",
                        "sulfa_drugs",
                        "contrast_dye",
                    ]),
                    "lifestyle_factors" => json_encode([
                        "remote_worker",
                        "limited_mobility",
                        "support_group_member",
                        "special_diet",
                    ]),
                    "primary_physician" => "Dr. Rheumatology Specialist",
                    "blood_type" => "A+",
                    "medications" => json_encode([
                        "hydroxychloroquine",
                        "methotrexate",
                        "prednisone",
                        "vitamin D supplements",
                        "calcium supplements",
                        "folic acid",
                    ]),
                    "is_healthcare_worker" => false,
                    "is_pregnant" => false,
                    "email_verified_at" => now(),
                ],
                "medical_history" => [
                    [
                        "condition" => "Lupus",
                        "diagnosis_date" => "2010-03-15",
                        "status" => "active",
                        "physician" => "Dr. Autoimmune Specialist",
                        "notes" => "Moderate disease activity, regular flares",
                    ],
                    [
                        "condition" => "Rheumatoid Arthritis",
                        "diagnosis_date" => "2012-06-20",
                        "status" => "active",
                        "physician" => "Dr. Joint Specialist",
                        "notes" =>
                            "Affecting multiple joints, managed with DMARDs",
                    ],
                ],
                "vaccination_history" => [
                    [
                        "vaccine_id" => 1,
                        "date" => "2023-10-15",
                        "lot" => "FL2023456",
                        "provider" => "Dr. Vaccine Clinic",
                        "location" => "Community Hospital",
                        "notes" => "No adverse reactions",
                    ],
                ],
            ],

            // Organ Transplant Recipient
            [
                "personal" => [
                    "first_name" => "James",
                    "last_name" => "Crawford",
                    "email" => "james.crawford@email.com",
                    "password" => Hash::make("password123"),
                    "date_of_birth" => "1978-08-23",
                    "gender" => "male",
                    "phone_number" => "555-0117",
                    "address" => "606 Transplant Ave, Medical Center, TX 77030",
                    "emergency_contact_name" => "Linda Crawford",
                    "emergency_contact_phone" => "555-0118",
                    "health_conditions" => json_encode([
                        "kidney_transplant",
                        "hypertension",
                        "post_transplant_diabetes",
                        "osteoporosis",
                    ]),
                    "allergies" => json_encode(["aspirin", "iodine_contrast"]),
                    "lifestyle_factors" => json_encode([
                        "immunosuppressed",
                        "frequent_medical_visits",
                        "dietary_restrictions",
                        "support_group_coordinator",
                    ]),
                    "primary_physician" => "Dr. Transplant Specialist",
                    "blood_type" => "O+",
                    "medications" => json_encode([
                        "tacrolimus",
                        "mycophenolate",
                        "prednisone",
                        "valganciclovir",
                        "lisinopril",
                        "insulin",
                    ]),
                    "is_healthcare_worker" => false,
                    "is_pregnant" => false,
                    "email_verified_at" => now(),
                ],
                "medical_history" => [
                    [
                        "condition" => "Kidney Transplant",
                        "diagnosis_date" => "2020-11-30",
                        "status" => "stable",
                        "physician" => "Dr. Transplant Surgeon",
                        "notes" => "Living donor transplant, stable function",
                    ],
                ],
                "vaccination_history" => [
                    [
                        "vaccine_id" => 1,
                        "date" => "2023-09-20",
                        "lot" => "FL2023789",
                        "provider" => "Transplant Clinic",
                        "location" => "Medical Center",
                        "notes" => "Post-transplant protocol",
                    ],
                ],
            ],

            // Complex Respiratory Case with COVID History
            [
                "personal" => [
                    "first_name" => "Maria",
                    "last_name" => "Gonzalez",
                    "email" => "maria.gonzalez@email.com",
                    "password" => Hash::make("password123"),
                    "date_of_birth" => "1990-03-15",
                    "gender" => "female",
                    "phone_number" => "555-0119",
                    "address" =>
                        "707 Respiratory Lane, Pulmonary Hills, CO 80206",
                    "emergency_contact_name" => "Carlos Gonzalez",
                    "emergency_contact_phone" => "555-0120",
                    "health_conditions" => json_encode([
                        "severe_asthma",
                        "long_covid",
                        "bronchiectasis",
                        "vocal_cord_dysfunction",
                    ]),
                    "allergies" => json_encode([
                        "dust_mites",
                        "pollen",
                        "mold",
                        "certain_medications",
                    ]),
                    "lifestyle_factors" => json_encode([
                        "altitude_resident",
                        "respiratory_therapist",
                        "home_air_purification",
                        "pulmonary_rehabilitation",
                    ]),
                    "primary_physician" => "Dr. Pulmonary Specialist",
                    "blood_type" => "B+",
                    "medications" => json_encode([
                        "inhaled_corticosteroids",
                        "long_acting_beta_agonist",
                        "montelukast",
                        "antihistamines",
                    ]),
                    "is_healthcare_worker" => true,
                    "is_pregnant" => false,
                    "email_verified_at" => now(),
                ],
                "medical_history" => [
                    [
                        "condition" => "COVID-19",
                        "diagnosis_date" => "2022-01-15",
                        "status" => "recovered with complications",
                        "physician" => "Dr. COVID Clinic",
                        "notes" => "Developed long COVID symptoms",
                    ],
                    [
                        "condition" => "Severe Asthma",
                        "diagnosis_date" => "2000-06-20",
                        "status" => "active",
                        "physician" => "Dr. Asthma Specialist",
                        "notes" => "Multiple exacerbations yearly",
                    ],
                ],
                "vaccination_history" => [
                    [
                        "vaccine_id" => 1,
                        "date" => "2023-10-01",
                        "lot" => "FL2023101",
                        "provider" => "Respiratory Clinic",
                        "location" => "Pulmonary Center",
                        "notes" => "Annual flu shot",
                    ],
                ],
            ],

            // Complex Pediatric Transition Case
            [
                "personal" => [
                    "first_name" => "Alex",
                    "last_name" => "Morgan",
                    "email" => "alex.morgan@email.com",
                    "password" => Hash::make("password123"),
                    "date_of_birth" => "2006-11-30",
                    "gender" => "other",
                    "phone_number" => "555-0121",
                    "address" => "808 Transition Rd, Youth City, WA 98101",
                    "emergency_contact_name" => "Sarah Morgan",
                    "emergency_contact_phone" => "555-0122",
                    "health_conditions" => json_encode([
                        "congenital_heart_defect",
                        "adhd",
                        "anxiety",
                        "scoliosis",
                    ]),
                    "allergies" => json_encode([
                        "peanuts",
                        "tree_nuts",
                        "environmental_allergies",
                    ]),
                    "lifestyle_factors" => json_encode([
                        "college_bound",
                        "competitive_swimmer",
                        "transitioning_to_adult_care",
                        "peer_support_leader",
                    ]),
                    "primary_physician" => "Dr. Transition Specialist",
                    "blood_type" => "AB+",
                    "medications" => json_encode([
                        "methylphenidate",
                        "ssri_antidepressant",
                        "antihistamines",
                    ]),
                    "is_healthcare_worker" => false,
                    "is_pregnant" => false,
                    "email_verified_at" => now(),
                ],
                "medical_history" => [
                    [
                        "condition" => "Congenital Heart Defect",
                        "diagnosis_date" => "2006-12-01",
                        "status" => "stable post-surgery",
                        "physician" => "Dr. Pediatric Cardiology",
                        "notes" => "Regular monitoring required",
                    ],
                ],
                "vaccination_history" => [
                    [
                        "vaccine_id" => 1,
                        "date" => "2023-09-15",
                        "lot" => "FL2023102",
                        "provider" => "Transition Clinic",
                        "location" => "Youth Medical Center",
                        "notes" => "Starting adult vaccination schedule",
                    ],
                ],
            ],
            // 8. Multiple Organ Transplant Recipient with Complications
            [
                "personal" => [
                    "first_name" => "Marcus",
                    "last_name" => "Rodriguez",
                    "email" => "marcus.rodriguez@email.com",
                    "password" => Hash::make("password123"),
                    "date_of_birth" => "1982-07-19",
                    "gender" => "male",
                    "phone_number" => "555-0115",
                    "address" =>
                        "505 Transplant Circle, Medical Valley, OH 43201",
                    "emergency_contact_name" => "Elena Rodriguez",
                    "emergency_contact_phone" => "555-0116",
                    "health_conditions" => json_encode([
                        "liver_transplant_recipient",
                        "kidney_transplant_recipient",
                        "chronic_rejection",
                        "recurrent_cmv_infection",
                        "post_transplant_diabetes",
                        "chronic_kidney_disease",
                        "osteoporosis",
                    ]),
                    "allergies" => json_encode([
                        "tacrolimus",
                        "penicillin",
                        "contrast_dye",
                        "shellfish",
                    ]),
                    "lifestyle_factors" => json_encode([
                        "transplant_support_group_leader",
                        "medical_research_participant",
                        "restricted_diet",
                        "frequent_medical_monitoring",
                        "work_from_home",
                        "limited_sun_exposure",
                        "strict_infection_precautions",
                    ]),
                    "primary_physician" => "Dr. Transplant Coordinator",
                    "blood_type" => "B+",
                    "medications" => json_encode([
                        "cyclosporine",
                        "mycophenolate",
                        "prednisone",
                        "valganciclovir",
                        "insulin",
                        "calcium_supplements",
                        "vitamin_d",
                        "prophylactic_antibiotics",
                    ]),
                    "is_healthcare_worker" => false,
                    "is_pregnant" => false,
                    "email_verified_at" => now(),
                ],
                "medical_history" => [
                    [
                        "condition" => "Liver Transplant",
                        "diagnosis_date" => "2018-03-15",
                        "status" => "chronic rejection",
                        "physician" => "Dr. Transplant Surgery",
                        "notes" =>
                            "Second transplant after primary failure, monitoring rejection",
                    ],
                    [
                        "condition" => "Kidney Transplant",
                        "diagnosis_date" => "2020-11-30",
                        "status" => "stable with complications",
                        "physician" => "Dr. Transplant Surgery",
                        "notes" =>
                            "Living donor transplant, managing chronic rejection",
                    ],
                    [
                        "condition" => "CMV Infection",
                        "diagnosis_date" => "2021-06-20",
                        "status" => "recurring",
                        "physician" => "Dr. Infectious Disease",
                        "notes" => "Requires ongoing antiviral prophylaxis",
                    ],
                    [
                        "condition" => "Post-Transplant Diabetes",
                        "diagnosis_date" => "2019-01-15",
                        "status" => "managed",
                        "physician" => "Dr. Endocrinologist",
                        "notes" =>
                            "Insulin dependent, complicated by immunosuppression",
                    ],
                ],
                "vaccination_history" => [
                    [
                        "vaccine_id" => 1,
                        "date" => "2024-01-15",
                        "lot" => "FL2024001",
                        "provider" => "Transplant Clinic",
                        "location" => "University Hospital",
                        "notes" =>
                            "Modified flu vaccine for immunocompromised patient",
                    ],
                    [
                        "vaccine_id" => 6,
                        "date" => "2023-12-01",
                        "lot" => "PN2023501",
                        "provider" => "Transplant Clinic",
                        "location" => "University Hospital",
                        "notes" =>
                            "Pneumococcal vaccine post-transplant protocol",
                    ],
                ],
            ],

            // 9. Complex Psychiatric Patient with Multiple Physical Conditions
            [
                "personal" => [
                    "first_name" => "Sophia",
                    "last_name" => "Patel",
                    "email" => "sophia.patel@email.com",
                    "password" => Hash::make("password123"),
                    "date_of_birth" => "1991-04-23",
                    "gender" => "female",
                    "phone_number" => "555-0117",
                    "address" => "606 Wellness Way, Mind Valley, CA 94301",
                    "emergency_contact_name" => "Raj Patel",
                    "emergency_contact_phone" => "555-0118",
                    "health_conditions" => json_encode([
                        "bipolar_disorder_type_1",
                        "ptsd",
                        "eating_disorder",
                        "fibromyalgia",
                        "migraine_with_aura",
                        "ibs",
                        "chronic_insomnia",
                    ]),
                    "allergies" => json_encode([
                        "ssri_medications",
                        "nsaids",
                        "latex",
                        "environmental_allergies",
                    ]),
                    "lifestyle_factors" => json_encode([
                        "disability_support",
                        "therapy_twice_weekly",
                        "service_dog_handler",
                        "part_time_artist",
                        "support_group_facilitator",
                        "meditation_practitioner",
                        "structured_routine_dependent",
                    ]),
                    "primary_physician" => "Dr. Integrated Health",
                    "blood_type" => "A+",
                    "medications" => json_encode([
                        "lithium",
                        "lamotrigine",
                        "prazosin",
                        "sumatriptan",
                        "quetiapine",
                        "gabapentin",
                        "melatonin",
                    ]),
                    "is_healthcare_worker" => false,
                    "is_pregnant" => false,
                    "email_verified_at" => now(),
                ],
                "medical_history" => [
                    [
                        "condition" => "Bipolar Disorder Type 1",
                        "diagnosis_date" => "2009-08-15",
                        "status" => "managed with medication",
                        "physician" => "Dr. Psychiatrist",
                        "notes" =>
                            "Stable on current regimen, regular monitoring",
                    ],
                    [
                        "condition" => "PTSD",
                        "diagnosis_date" => "2012-03-20",
                        "status" => "ongoing treatment",
                        "physician" => "Dr. Trauma Specialist",
                        "notes" => "Regular therapy and medication management",
                    ],
                    [
                        "condition" => "Fibromyalgia",
                        "diagnosis_date" => "2015-11-30",
                        "status" => "chronic management",
                        "physician" => "Dr. Pain Specialist",
                        "notes" => "Multimodal pain management approach",
                    ],
                    [
                        "condition" => "Eating Disorder",
                        "diagnosis_date" => "2010-06-15",
                        "status" => "in recovery",
                        "physician" => "Dr. Eating Disorder Specialist",
                        "notes" => "Regular monitoring of weight and nutrition",
                    ],
                ],
                "vaccination_history" => [
                    [
                        "vaccine_id" => 1,
                        "date" => "2023-10-15",
                        "lot" => "FL2023801",
                        "provider" => "Integrated Health Clinic",
                        "location" => "Wellness Center",
                        "notes" =>
                            "Anxiety management protocol used during administration",
                    ],
                ],
            ],

            // 10. Severe Allergy and Immune System Patient
            [
                "personal" => [
                    "first_name" => "Benjamin",
                    "last_name" => "Novak",
                    "email" => "benjamin.novak@email.com",
                    "password" => Hash::make("password123"),
                    "date_of_birth" => "1995-12-08",
                    "gender" => "male",
                    "phone_number" => "555-0119",
                    "address" => "707 Allergy Avenue, Immune City, MN 55401",
                    "emergency_contact_name" => "Sarah Novak",
                    "emergency_contact_phone" => "555-0120",
                    "health_conditions" => json_encode([
                        "hereditary_angioedema",
                        "mastocytosis",
                        "common_variable_immunodeficiency",
                        "eosinophilic_esophagitis",
                        "chronic_urticaria",
                        "asthma",
                        "multiple_chemical_sensitivity",
                    ]),
                    "allergies" => json_encode([
                        "multiple_food_allergies",
                        "drug_allergies",
                        "environmental_allergies",
                        "chemical_sensitivities",
                        "metal_allergies",
                        "vaccine_components",
                    ]),
                    "lifestyle_factors" => json_encode([
                        "works_remotely",
                        "hepa_filtered_home",
                        "special_dietary_requirements",
                        "medical_alert_bracelet_wearer",
                        "regular_allergy_shots",
                        "environmental_controls",
                        "restricted_travel",
                    ]),
                    "primary_physician" => "Dr. Allergy Immunologist",
                    "blood_type" => "O+",
                    "medications" => json_encode([
                        "c1_esterase_inhibitor",
                        "omalizumab",
                        "montelukast",
                        "antihistamines",
                        "epinephrine_autoinjectors",
                        "cromolyn_sodium",
                        "immunoglobulin_replacement",
                    ]),
                    "is_healthcare_worker" => false,
                    "is_pregnant" => false,
                    "email_verified_at" => now(),
                ],
                "medical_history" => [
                    [
                        "condition" => "Hereditary Angioedema",
                        "diagnosis_date" => "2005-03-15",
                        "status" => "managed with medication",
                        "physician" => "Dr. HAE Specialist",
                        "notes" =>
                            "Regular C1 inhibitor replacement, breakthrough attacks",
                    ],
                    [
                        "condition" => "Mastocytosis",
                        "diagnosis_date" => "2010-08-20",
                        "status" => "ongoing management",
                        "physician" => "Dr. Mast Cell Specialist",
                        "notes" => "Systemic involvement, regular monitoring",
                    ],
                    [
                        "condition" => "CVID",
                        "diagnosis_date" => "2012-11-30",
                        "status" => "managed with IVIG",
                        "physician" => "Dr. Immunologist",
                        "notes" => "Monthly immunoglobulin replacement therapy",
                    ],
                    [
                        "condition" => "Eosinophilic Esophagitis",
                        "diagnosis_date" => "2015-06-15",
                        "status" => "diet controlled",
                        "physician" => "Dr. Gastroenterologist",
                        "notes" =>
                            "Maintenance therapy with dietary restrictions",
                    ],
                ],
                "vaccination_history" => [
                    [
                        "vaccine_id" => 1,
                        "date" => "2023-10-01",
                        "lot" => "FL2023901",
                        "provider" => "Allergy Clinic",
                        "location" => "Immune System Center",
                        "notes" =>
                            "Administered under medical supervision with pre-treatment",
                    ],
                    [
                        "vaccine_id" => 6,
                        "date" => "2023-09-15",
                        "lot" => "PN2023601",
                        "provider" => "Immunology Clinic",
                        "location" => "Immune System Center",
                        "notes" => "Split dose administration due to allergies",
                    ],
                ],
            ],
        ];

        foreach ($users as $userData) {
            // Create user
            $user = User::create($userData["personal"]);

            // Create medical history
            $this->createMedicalHistory(
                $user->id,
                $userData["medical_history"]
            );

            // Create vaccination history
            $this->createVaccinationHistory(
                $user->id,
                $userData["vaccination_history"]
            );
        }
    }
}
