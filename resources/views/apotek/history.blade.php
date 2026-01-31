@extends('layouts.app')

@section('content')
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            prefix: 'tw-',
            corePlugins: {
                preflight: false,
            }
        }
    </script>

    <div class="tw-container tw-mx-auto">
        <div class="tw-mb-8">
            <h2 class="tw-text-3xl tw-font-black tw-text-gray-900">Riwayat Penyerahan</h2>
            <p class="tw-text-gray-500">Daftar resep yang telah berhasil diserahkan kepada pasien.</p>
        </div>

        <div
            class="tw-bg-white tw-rounded-3xl tw-shadow-xl tw-shadow-gray-200/50 tw-border tw-border-gray-100 tw-overflow-hidden">
            <div class="tw-overflow-x-auto">
                <table class="tw-w-full tw-text-left">
                    <thead class="tw-bg-gray-50 tw-border-b tw-border-gray-100">
                        <tr>
                            <th class="tw-px-6 tw-py-4 tw-text-xs tw-font-black tw-text-gray-400 tw-uppercase">No</th>
                            <th class="tw-px-6 tw-py-4 tw-text-xs tw-font-black tw-text-gray-400 tw-uppercase">Waktu Serah
                            </th>
                            <th class="tw-px-6 tw-py-4 tw-text-xs tw-font-black tw-text-gray-400 tw-uppercase">Pasien</th>
                            <th class="tw-px-6 tw-py-4 tw-text-xs tw-font-black tw-text-gray-400 tw-uppercase">Resep</th>
                            <th class="tw-px-6 tw-py-4 tw-text-xs tw-font-black tw-text-gray-400 tw-uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="tw-divide-y tw-divide-gray-50">
                        @foreach($invoices as $index => $invoice)
                            <tr class="tw-hover:bg-gray-50/50">
                                <td class="tw-px-6 tw-py-4 tw-text-sm tw-text-gray-500">{{ $invoices->firstItem() + $index }}
                                </td>
                                <td class="tw-px-6 tw-py-4 tw-text-sm tw-text-gray-600">
                                    {{ $invoice->updated_at->translatedFormat('d M Y, H:i') }}
                                </td>
                                <td class="tw-px-6 tw-py-4">
                                    <div class="tw-font-black tw-text-gray-800">{{ $invoice->medicalRecord->patient->name }}
                                    </div>
                                    <div class="tw-text-[10px] tw-text-gray-400 tw-font-bold tw-uppercase">
                                        RM-{{ $invoice->medical_record_id }}</div>
                                </td>
                                <td class="tw-px-6 tw-py-4">
                                    <div class="tw-flex tw-flex-wrap tw-gap-1">
                                        @foreach($invoice->medicalRecord->medications as $medicine)
                                            <span
                                                class="tw-bg-blue-50 tw-text-blue-600 tw-px-2 tw-py-0.5 tw-rounded tw-text-[10px] tw-font-black">
                                                {{ $medicine->name }} ({{ $medicine->pivot->quantity }})
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="tw-px-6 tw-py-4">
                                    <span
                                        class="tw-bg-green-100 tw-text-green-600 tw-px-3 tw-py-1 tw-rounded-full tw-text-[10px] tw-font-black tw-flex tw-items-center tw-gap-1 tw-w-fit">
                                        <i class="bi bi-check-circle-fill"></i> TERKIRIM
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($invoices->hasPages())
                <div class="tw-px-6 tw-py-4 tw-bg-gray-50 tw-border-t tw-border-gray-100">
                    {{ $invoices->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
