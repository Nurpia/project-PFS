<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        // Show all invoices
        $invoices = Invoice::with(['medicalRecord.patient', 'medicalRecord.doctor'])
            ->latest('transaction_date')
            ->get();

        // Also get medical records that DON'T have an invoice yet (for creation)
        $pendingRecords = \App\Models\MedicalRecord::doesntHave('invoice')
            ->with(['patient', 'doctor'])
            ->latest()
            ->get();

        return view('transactions.index', compact('invoices', 'pendingRecords'));
    }

    public function create(Request $request)
    {
        $record = \App\Models\MedicalRecord::with(['patient', 'doctor', 'medications'])
            ->findOrFail($request->medical_record_id);

        if ($record->invoice) {
            return redirect()->route('transactions.index')->with('error', 'Tagihan untuk rekam medis ini sudah ada.');
        }

        return view('transactions.create', compact('record'));
    }

    public function store(Request $request)
    {
        $record = \App\Models\MedicalRecord::with(['doctor', 'medications'])->findOrFail($request->medical_record_id);

        if ($record->invoice) {
            return redirect()->route('transactions.index')->with('error', 'Tagihan sudah dibuat sebelumnya.');
        }

        $medicinesTotal = $record->medications->sum(function ($medicine) {
            return $medicine->pivot->price_per_unit * $medicine->pivot->quantity;
        });

        // Treatment fee is now system-defined, not input by Doctor
        // For example: fixed Rp 50.000 if there's a diagnosis or action
        $systemTreatmentFee = $record->action ? 50000 : 0;

        $totalAmount = ($record->doctor->service_fee ?? 0) + $systemTreatmentFee + $medicinesTotal;

        Invoice::create([
            'medical_record_id' => $record->id,
            'total_amount' => $totalAmount,
            'status' => 'unpaid',
            'transaction_date' => now(),
        ]);

        return redirect()->route('transactions.index')->with('success', 'Tagihan berhasil dibuat.');
    }

    public function show(Invoice $transaction) // Route model binding uses 'transaction' because of resource name
    {
        $invoice = $transaction;
        $invoice->load([
            'medicalRecord.patient',
            'medicalRecord.doctor',
            'medicalRecord.medications'
        ]);

        return view('transactions.show', compact('invoice'));
    }

    public function update(Request $request, Invoice $transaction)
    {
        $invoice = $transaction;
        $invoice->update([
            'status' => 'paid',
            'transaction_date' => now(),
        ]);

        return redirect()->route('transactions.index')->with('success', 'Pembayaran berhasil dikonfirmasi. Status: LUNAS.');
    }
}
