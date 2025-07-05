<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareTask extends Model
{
    protected $fillable = ['patient_id', 'task', 'scheduled_time', 'shift'];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}

