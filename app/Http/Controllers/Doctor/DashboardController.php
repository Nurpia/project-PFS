<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $doctor = Auth::user()->doctor;

        if (!$doctor) {
            return view('doctor.dashboard', [
                'doctor' => null,
                'status_error' => 'Profil dokter Anda belum lengkap silakan hubungi Staff Administrasi.',
                'stats' => [
                    'total_treatments' => 0,
                    'patients_this_month' => 0,
                    'today_records_count' => 0,
                ],
                'recentRecords' => collect(),
            ]);
        }

        $stats = [
            'total_treatments' => $doctor->medicalRecords()->count(),
            'patients_this_month' => $doctor->medicalRecords()
                ->whereMonth('visit_date', now()->month)
                ->whereYear('visit_date', now()->year)
                ->distinct('patient_id')
                ->count('patient_id'),
            'today_records_count' => $doctor->medicalRecords()
                ->whereDate('visit_date', today())
                ->count(),
        ];

        $recentRecords = $doctor->medicalRecords()->with('patient')
            ->latest()
            ->take(5)
            ->get();

        return view('doctor.dashboard', compact('stats', 'recentRecords', 'doctor'));
    }
}
