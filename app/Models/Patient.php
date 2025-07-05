<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\VitalSign; // ✅ Import VitalSign model

class Patient extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'age', 'room_number', 'gender'];

    public function vitalSign()
{
    return $this->hasOne(\App\Models\VitalSign::class)->latestOfMany();
}

    public function careTasks()
    {
        return $this->hasMany(CareTask::class);
    }

}
