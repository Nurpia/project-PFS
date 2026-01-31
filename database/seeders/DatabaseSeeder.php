<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Superadmin
        User::create([
            'name' => 'Super Administrator',
            'email' => 'superadmin@app.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
        ]);

        // User (Staff/Admin RS)
        User::create([
            'name' => 'Staff Admin',
            'email' => 'staff@app.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Dokter
        $dokterUser = User::create([
            'name' => 'Dr. Bambang Kusuma',
            'email' => 'dokter@app.com',
            'password' => Hash::make('password'),
            'role' => 'doctor',
        ]);

        $dokterProfile = \App\Models\Doctor::create([
            'user_id' => $dokterUser->id,
            'name' => 'Dr. Bambang Kusuma',
            'specialist' => 'Spesialis Penyakit Dalam',
            'phone' => '081234567890',
            'no_str' => 'STR-123456',
            'address' => 'Jl. Kesehatan No. 123'
        ]);

        // Sample Patient
        $patient = \App\Models\Patient::create([
            'name' => 'Budi Santoso',
            'nik' => '1234567890123456',
            'gender' => 'L',
            'dob' => '1990-01-01',
            'address' => 'Jl. Contoh No. 1'
        ]);

        // Sample Medical Record for this doctor
        \App\Models\MedicalRecord::create([
            'patient_id' => $patient->id,
            'doctor_id' => $dokterProfile->id,
            'complaint' => 'Demam dan pusing',
            'diagnosis' => 'Influenza',
            'action' => 'Pemberian obat jalan',
            'visit_date' => now()
        ]);
    }
}
