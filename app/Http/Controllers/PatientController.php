<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::latest()->get();
        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|unique:patients|max:16',
            'name' => 'required',
            'address' => 'required',
            'phone' => 'nullable',
            'dob' => 'required|date',
            'gender' => 'required|in:L,P',
        ]);

        Patient::create($validated);

        return redirect()->route('patients.index')->with('success', 'Patient added successfully.');
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'nik' => 'required|max:16|unique:patients,nik,' . $patient->id,
            'name' => 'required',
            'address' => 'required',
            'phone' => 'nullable',
            'dob' => 'required|date',
            'gender' => 'required|in:L,P',
        ]);

        $patient->update($validated);

        return redirect()->route('patients.index')->with('success', 'Patient updated successfully.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully.');
    }
}
