<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

// class VitalSign extends Model
// {
//     public function patient()
// {
//     return $this->belongsTo(Patient::class);
// }

// }

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VitalSign extends Model
{
    protected $fillable = [
        'patient_id',
        'pulse_rate',
        'temperature',
        'blood_pressure',
        'respiratory_rate',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}

