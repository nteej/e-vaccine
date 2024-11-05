<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Vaccination extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id', 'vaccine_id', 'date_administered',
        'next_due_date', 'notes'
    ];

    protected $casts=[
        'next_due_date' =>'datetime',
        'date_administered' => 'datetime'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function vaccine() {
        return $this->belongsTo(Vaccine::class);
    }

}
