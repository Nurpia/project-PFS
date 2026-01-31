<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index()
    {
        $medicines = Medicine::latest()->get();
        return view('medicines.index', compact('medicines'));
    }

    public function create()
    {
        return view('medicines.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:medicines',
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0|max:999999999999999999.99',
            'unit' => 'required|string',
            'description' => 'nullable|string',
        ]);

        Medicine::create($validated);

        return redirect()->route('medicines.index')->with('success', 'Data obat berhasil ditambahkan.');
    }

    public function edit(Medicine $medicine)
    {
        return view('medicines.edit', compact('medicine'));
    }

    public function update(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'code' => 'required|unique:medicines,code,' . $medicine->id,
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0|max:999999999999999999.99',
            'unit' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $medicine->update($validated);

        return redirect()->route('medicines.index')->with('success', 'Data obat berhasil diupdate.');
    }

    public function destroy(Medicine $medicine)
    {
        $medicine->delete();
        return redirect()->route('medicines.index')->with('success', 'Data obat dihapus.');
    }
}
