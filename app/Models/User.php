<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'date_of_birth', 
        'gender',
        'health_conditions', 
        'lifestyle_factors'
    ];

    public function vaccinations() {
        return $this->hasMany(Vaccination::class,'user_id','id');
    }

    public function vaccinationRecords()
    {
        return $this->hasMany(VaccinationRecord::class,'user_id','id');
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getAgeAttribute()
    {
        return $this->date_of_birth->age;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
            'health_conditions' => 'array',
            'allergies' => 'array',
            'lifestyle_factors' => 'array',
            'medications' => 'array',
            'is_healthcare_worker' => 'boolean',
            'is_pregnant' => 'boolean'
        ];
    }
    protected $casts = [
        'notification_preferences' => 'array',
    ];
    public function healthConditions()
    {
        return $this->belongsToMany(HealthCondition::class, 'user_health_conditions')
            ->withPivot('diagnosis_date', 'status', 'severity', 'treating_physician', 'notes')
            ->withTimestamps();
    }

    public function vitalSigns()
    {
        return $this->hasMany(VitalSign::class);
    }
}
