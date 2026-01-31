<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'superadmin') {
            return redirect()->route('superadmin.dashboard');
        }

        if (Auth::user()->role === 'kasir') {
            return $this->kasirDashboard();
        }

        return $this->userDashboard();
    }

    public function kasirDashboard()
    {
        $stats = [
            'total_transactions' => \App\Models\Invoice::count(),
            'pending_transactions' => \App\Models\Invoice::where('status', 'unpaid')->count(),
            'today_revenue' => \App\Models\Invoice::where('status', 'paid')->whereDate('transaction_date', today())->sum('total_amount'),
        ];

        return view('dashboard.kasir', compact('stats'));
    }

    public function userDashboard()
    {
        $stats = [
            // Clinical Stats
            'total_patients' => \App\Models\Patient::count(),
            'total_doctors' => \App\Models\Doctor::count(),
            'total_medical_records' => \App\Models\MedicalRecord::count(),

            // Pharmacy Stats (Integrated for Staff)
            'total_medicines' => \App\Models\Medicine::count(),
            'pending_prescriptions' => \App\Models\Invoice::where('status', 'paid')->where('medicine_status', 'pending')->count(),
            'today_handed_over' => \App\Models\Invoice::where('medicine_status', 'handed_over')->whereDate('updated_at', today())->count(),

            // Financial Monitoring
            'total_transactions' => \App\Models\Invoice::count(),
            'today_revenue' => \App\Models\Invoice::where('status', 'paid')->whereDate('transaction_date', today())->sum('total_amount'),
        ];

        return view('dashboard.staff', compact('stats'));
    }
}
