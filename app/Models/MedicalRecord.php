<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'complaint',
        'diagnosis',
        'action',
        'prescription',
        'visit_date'
    ];

    protected $casts = [
        'visit_date' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function medications()
    {
        return $this->belongsToMany(Medicine::class, 'medical_record_medicine')
            ->withPivot('quantity', 'price_per_unit')
            ->withTimestamps();
    }
}
