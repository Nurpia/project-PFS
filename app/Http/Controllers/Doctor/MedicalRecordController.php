<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Medicine;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicalRecordController extends Controller
{
    public function index(Request $request)
    {
        $doctor = Auth::user()->doctor;
        if (!$doctor)
            return redirect()->route('doctor.dashboard')->with('error', 'Profil dokter tidak ditemukan.');

        $query = $doctor->medicalRecords()->with('patient');

        if ($request->view == 'resep') {
            $query->whereNotNull('prescription');
        }

        $medicalRecords = $query->latest()->paginate(10);

        return view('doctor.rekam_medis.index', compact('medicalRecords', 'doctor'));
    }

    public function create()
    {
        $doctor = Auth::user()->doctor;
        $patients = Patient::orderBy('name')->get();
        $medicines = Medicine::orderBy('name')->get();

        return view('doctor.rekam_medis.create', compact('patients', 'medicines', 'doctor'));
    }

    public function store(Request $request)
    {
        $doctor = Auth::user()->doctor;

        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'complaint' => 'required|string',
            'diagnosis' => 'required|string',
            'action' => 'nullable|string',
            'prescription' => 'nullable|string',
            'visit_date' => 'required|date',
            'medicines' => 'nullable|array',
            'medicines.*.id' => 'required|exists:medicines,id',
            'medicines.*.quantity' => 'required|integer|min:1',
        ]);

        $record = MedicalRecord::create([
            'patient_id' => $validated['patient_id'],
            'doctor_id' => $doctor->id,
            'complaint' => $validated['complaint'],
            'diagnosis' => $validated['diagnosis'],
            'action' => $validated['action'],
            'prescription' => $validated['prescription'],
            'visit_date' => $validated['visit_date'],
        ]);

        $medicinesTotal = 0;
        if (!empty($validated['medicines'])) {
            foreach ($validated['medicines'] as $item) {
                $medicine = Medicine::find($item['id']);
                $record->medications()->attach($item['id'], [
                    'quantity' => $item['quantity'],
                    'price_per_unit' => $medicine->price
                ]);
                $medicinesTotal += ($medicine->price * $item['quantity']);
            }
        }

        return redirect()->route('doctor.rekam_medis.index')->with('success', 'Rekam medis berhasil disimpan.');
    }

    public function show(MedicalRecord $rekam_medi)
    {
        $doctor = Auth::user()->doctor;
        if ($rekam_medi->doctor_id !== $doctor->id)
            abort(403);

        $rekam_medi->load(['patient', 'medications']);
        return view('doctor.rekam_medis.show', compact('rekam_medi', 'doctor'));
    }

    public function edit(MedicalRecord $rekam_medi)
    {
        $doctor = Auth::user()->doctor;
        if ($rekam_medi->doctor_id !== $doctor->id)
            abort(403);

        $patients = Patient::orderBy('name')->get();
        $medicines = Medicine::orderBy('name')->get();
        $rekam_medi->load('medications');

        return view('doctor.rekam_medis.edit', compact('rekam_medi', 'patients', 'medicines', 'doctor'));
    }

    public function update(Request $request, MedicalRecord $rekam_medi)
    {
        $doctor = Auth::user()->doctor;
        if ($rekam_medi->doctor_id !== $doctor->id)
            abort(403);

        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'complaint' => 'required|string',
            'diagnosis' => 'required|string',
            'action' => 'nullable|string',
            'prescription' => 'nullable|string',
            'visit_date' => 'required|date',
            'medicines' => 'nullable|array',
            'medicines.*.id' => 'required|exists:medicines,id',
            'medicines.*.quantity' => 'required|integer|min:1',
        ]);

        $rekam_medi->update([
            'patient_id' => $validated['patient_id'],
            'complaint' => $validated['complaint'],
            'diagnosis' => $validated['diagnosis'],
            'action' => $validated['action'],
            'prescription' => $validated['prescription'],
            'visit_date' => $validated['visit_date'],
        ]);

        $rekam_medi->medications()->detach();
        $medicinesTotal = 0;
        if (!empty($validated['medicines'])) {
            foreach ($validated['medicines'] as $item) {
                $medicine = Medicine::find($item['id']);
                $rekam_medi->medications()->attach($item['id'], [
                    'quantity' => $item['quantity'],
                    'price_per_unit' => $medicine->price
                ]);
                $medicinesTotal += ($medicine->price * $item['quantity']);
            }
        }

        return redirect()->route('doctor.rekam_medis.index')->with('success', 'Rekam medis berhasil diperbarui.');
    }

    public function destroy(MedicalRecord $rekam_medi)
    {
        $doctor = Auth::user()->doctor;
        if ($rekam_medi->doctor_id !== $doctor->id)
            abort(403);

        $rekam_medi->delete();
        return redirect()->route('doctor.rekam_medis.index')->with('success', 'Rekam medis berhasil dihapus.');
    }
}
