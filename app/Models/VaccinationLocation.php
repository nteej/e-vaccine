<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VaccinationLocation extends Model
{
    protected $fillable = [
        'name',
        'address',
        'city',
        'state',
        'zip_code',
        'phone',
        'email',
        'operating_hours',
        'is_active',
        'location_type',
        'accepts_insurance',
        'appointment_required',
        'wheelchair_accessible',
        'languages_spoken',
        'additional_services'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'operating_hours' => 'array',
        'languages_spoken' => 'array',
        'additional_services' => 'array',
        'accepts_insurance' => 'boolean',
        'appointment_required' => 'boolean',
        'wheelchair_accessible' => 'boolean'
    ];
}
