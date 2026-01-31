<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $records = MedicalRecord::with(['patient', 'doctor'])->latest('visit_date')->get();
        return view('medical_records.index', compact('records'));
    }

    public function show(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load(['patient', 'doctor', 'invoice', 'medications']);
        return view('medical_records.show', compact('medicalRecord'));
    }
}
