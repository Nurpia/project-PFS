<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApotekController extends Controller
{
    public function index()
    {
        // Only show paid invoices that haven't handed over medicines yet
        $invoices = Invoice::with(['medicalRecord.patient', 'medicalRecord.medications'])
            ->where('status', 'paid')
            ->where('medicine_status', 'pending')
            ->latest()
            ->get();

        return view('apotek.index', compact('invoices'));
    }

    public function handOver(Invoice $invoice)
    {
        if ($invoice->status !== 'paid') {
            return back()->with('error', 'Tagihan belum dibayar.');
        }

        if ($invoice->medicine_status === 'handed_over') {
            return back()->with('error', 'Obat sudah diserahkan.');
        }

        DB::beginTransaction();
        try {
            $medicalRecord = $invoice->medicalRecord;

            foreach ($medicalRecord->medications as $medicine) {
                // Reduce stock
                $medicine->decrement('stock', $medicine->pivot->quantity);
            }

            $invoice->update(['medicine_status' => 'handed_over']);

            DB::commit();
            return back()->with('success', 'Obat berhasil diserahkan dan stok telah diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function history()
    {
        $invoices = Invoice::with(['medicalRecord.patient', 'medicalRecord.medications'])
            ->where('medicine_status', 'handed_over')
            ->latest()
            ->paginate(15);

        return view('apotek.history', compact('invoices'));
    }
}
