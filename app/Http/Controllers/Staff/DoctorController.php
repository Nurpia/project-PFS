<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with('user')->latest()->get();
        return view('staff.doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('staff.doctors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialist' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'schedule' => 'nullable|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'doctor',
        ]);

        Doctor::create([
            'user_id' => $user->id,
            'name' => $validated['name'],
            'specialist' => $validated['specialist'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'schedule' => $validated['schedule'],
        ]);

        return redirect()->route('staff.doctors.index')->with('success', 'Data dokter berhasil ditambahkan.');
    }

    public function edit(Doctor $doctor)
    {
        return view('staff.doctors.edit', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialist' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string',
            'schedule' => 'nullable|string',
        ]);

        $doctor->update($validated);
        $doctor->user->update(['name' => $validated['name']]);

        return redirect()->route('staff.doctors.index')->with('success', 'Data dokter berhasil diperbarui.');
    }

    public function destroy(Doctor $doctor)
    {
        $user = $doctor->user;
        $doctor->delete();
        if ($user) {
            $user->delete();
        }

        return redirect()->route('staff.doctors.index')->with('success', 'Data dokter berhasil dihapus.');
    }
}
