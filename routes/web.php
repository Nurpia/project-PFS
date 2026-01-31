<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ApotekController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\Staff\DoctorController as StaffDoctorController;
use App\Http\Controllers\Doctor\DashboardController as DoctorDashboardController;
use App\Http\Controllers\Doctor\MedicalRecordController as DoctorMedicalRecordController;
use App\Http\Controllers\DoctorProfileController;

Route::get('/', function () {
    return view('landing');
});

// Authentication
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'index'])->name('login');
    Route::post('login', [AuthController::class, 'login']);

    // Forgot Password (Placeholder)
    Route::get('forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');
});

Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Shared Routes (Accessible by Staff, Kasir, and Apotek)
Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Staff/User Only Routes (Petugas Medis & Apotek)
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::resource('patients', PatientController::class);
    Route::resource('medicines', MedicineController::class);
    Route::get('/medical_records', [MedicalRecordController::class, 'index'])->name('medical_records.index');
    Route::get('/medical_records/{medical_record}', [MedicalRecordController::class, 'show'])->name('medical_records.show');

    // Apotek Features inside Staff Role
    Route::prefix('apotek')->name('apotek.')->group(function () {
        Route::get('/', [ApotekController::class, 'index'])->name('index');
        Route::post('/hand-over/{invoice}', [ApotekController::class, 'handOver'])->name('hand-over');
        Route::get('/history', [ApotekController::class, 'history'])->name('history');
    });

    // Staff Doctor Management
    Route::prefix('staff')->name('staff.')->group(function () {
        Route::resource('doctors', StaffDoctorController::class);
    });
});

// Billing Routes (Kasir Only)
Route::middleware(['auth', 'role:kasir'])->group(function () {
    Route::resource('transactions', InvoiceController::class)->names('transactions');
});

// Doctor Routes (Clinical Only)
Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', [DoctorDashboardController::class, 'index'])->name('dashboard');
    Route::resource('rekam-medis', DoctorMedicalRecordController::class)->names('rekam_medis');

    // Profile Settings
    Route::get('/profile', [DoctorProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [DoctorProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [DoctorProfileController::class, 'updatePassword'])->name('password.update');
});

// Global Profile (Accessible by all roles)
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Superadmin Routes
Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', UserManagementController::class);
});
