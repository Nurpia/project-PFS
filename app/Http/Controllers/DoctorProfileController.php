<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class DoctorProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $doctor = $user->doctor;

        return view('doctor.profile', compact('user', 'doctor'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $doctor = $user->doctor;

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:15'],
            'specialist' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'schedule' => ['nullable', 'string'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($doctor) {
            $doctor->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'specialist' => $request->specialist,
                'address' => $request->address,
                'schedule' => $request->schedule,
            ]);
        }

        return redirect()->route('doctor.profile.edit')->with('status', 'profile-updated');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('doctor.profile.edit')->with('status', 'password-updated');
    }
}
