<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class VaccinationRecord extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'vaccine_id',
        'administration_date',
        'lot_number',
        'administered_by',
        'location',
        'notes'
    ];

    protected $casts = [
        'administration_date' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vaccine()
    {
        return $this->belongsTo(Vaccine::class);
    }
}
