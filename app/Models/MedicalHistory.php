<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class MedicalHistory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'condition',
        'diagnosis_date',
        'status',
        'treating_physician',
        'notes'
    ];

    protected $casts = [
        'diagnosis_date' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
