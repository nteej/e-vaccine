<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Vaccine extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'description', 'recommended_age_start',
        'recommended_age_end', 'frequency', 'risk_factors',
        'contraindications',
        'priority_level'
    ];
    protected $casts = [
        'risk_factors' => 'array',
        'contraindications' => 'array',
        'recommended_age_start' => 'integer',
        'recommended_age_end' => 'integer'
    ];

    public function vaccinationRecords()
    {
        return $this->hasMany(VaccinationRecord::class);
    }
}
