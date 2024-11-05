<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class HealthCondition extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'category',
        'description',
        'risk_level',
        'vaccination_implications',
        'monitoring_frequency',
        'requires_specialist',
        'contraindicated_vaccines',
        'recommended_vaccines',
        'special_instructions',
        'icd_10_code'
    ];

    protected $casts = [
        'vaccination_implications' => 'array',
        'contraindicated_vaccines' => 'array',
        'recommended_vaccines' => 'array',
        'special_instructions' => 'array',
        'requires_specialist' => 'boolean'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_health_conditions')
            ->withPivot('diagnosis_date', 'status', 'severity', 'treating_physician', 'notes')
            ->withTimestamps();
    }

    public function recommendedVaccines()
    {
        return $this->belongsToMany(Vaccine::class, 'vaccine_recommendations')
            ->withPivot('priority_level', 'notes', 'special_instructions')
            ->withTimestamps();
    }

    public function contraindicatedVaccines()
    {
        return $this->belongsToMany(Vaccine::class, 'vaccine_contraindications')
            ->withPivot('reason', 'severity', 'alternatives')
            ->withTimestamps();
    }

    // Scopes for filtering conditions
    public function scopeHighRisk($query)
    {
        return $query->where('risk_level', 'high');
    }

    public function scopeRequiringSpecialist($query)
    {
        return $query->where('requires_specialist', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
