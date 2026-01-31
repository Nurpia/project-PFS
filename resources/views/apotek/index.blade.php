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
        <div class="tw-flex tw-justify-between tw-items-center tw-mb-8">
            <div>
                <h2 class="tw-text-3xl tw-font-black tw-text-gray-900">Antrean Apotek</h2>
                <p class="tw-text-gray-500">Daftar obat yang siap diserahkan kepada pasien setelah pelunasan.</p>
            </div>
            <div
                class="tw-bg-green-600 tw-px-6 tw-py-3 tw-rounded-2xl tw-text-white tw-shadow-lg tw-flex tw-items-center tw-gap-3">
                <i class="bi bi-capsule-pill tw-text-2xl"></i>
                <div class="tw-leading-none">
                    <p class="tw-text-xs tw-font-bold tw-uppercase tw-opacity-80 tw-mb-1">Pesanan Siap</p>
                    <p class="tw-text-xl tw-font-black tw-mb-0">{{ $invoices->count() }} Pasien</p>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="tw-bg-green-50 tw-border-l-4 tw-border-green-500 tw-p-4 tw-mb-6 tw-rounded-r-xl tw-shadow-sm">
                <p class="tw-text-sm tw-text-green-700 tw-font-medium tw-mb-0">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="tw-bg-red-50 tw-border-l-4 tw-border-red-500 tw-p-4 tw-mb-6 tw-rounded-r-xl tw-shadow-sm">
                <p class="tw-text-sm tw-text-red-700 tw-font-medium tw-mb-0">{{ session('error') }}</p>
            </div>
        @endif

        <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 lg:tw-grid-cols-3 tw-gap-6">
            @forelse($invoices as $invoice)
                <div
                    class="tw-bg-white tw-rounded-3xl tw-shadow-xl tw-shadow-gray-200/50 tw-border tw-border-gray-100 tw-overflow-hidden tw-flex tw-flex-col">
                    <div class="tw-bg-gray-50 tw-px-6 tw-py-4 tw-flex tw-justify-between tw-items-center">
                        <span
                            class="tw-text-xs tw-font-black tw-text-gray-400 tw-uppercase">#RM-{{ $invoice->medical_record_id }}</span>
                        <span
                            class="tw-bg-green-100 tw-text-green-600 tw-px-3 tw-py-1 tw-rounded-full tw-text-[10px] tw-font-black">LUNAS</span>
                    </div>

                    <div class="tw-p-6 tw-flex-grow">
                        <h4 class="tw-text-xl tw-font-black tw-text-gray-800 tw-mb-1">
                            {{ $invoice->medicalRecord->patient->name }}</h4>
                        <p class="tw-text-xs tw-text-gray-400 tw-mb-4">Dr. {{ $invoice->medicalRecord->doctor->name }}</p>

                        <div class="tw-space-y-3">
                            <h6 class="tw-text-[10px] tw-font-black tw-text-gray-400 tw-uppercase tw-tracking-widest">Resep
                                Obat:</h6>
                            <ul class="tw-list-none tw-p-0 tw-m-0 tw-space-y-2">
                                @foreach($invoice->medicalRecord->medications as $medicine)
                                    <li class="tw-flex tw-justify-between tw-items-center tw-text-sm">
                                        <span class="tw-text-gray-600 tw-font-medium">{{ $medicine->name }}</span>
                                        <span
                                            class="tw-bg-gray-100 tw-text-gray-500 tw-px-2 tw-py-0.5 tw-rounded tw-font-bold tw-text-xs">x{{ $medicine->pivot->quantity }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="tw-p-6 tw-pt-0">
                        <form action="{{ route('apotek.hand-over', $invoice->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="tw-w-full tw-bg-blue-600 tw-hover:tw-bg-blue-700 tw-text-white tw-py-3 tw-rounded-2xl tw-font-black tw-transition-all tw-flex tw-items-center tw-justify-center tw-gap-2 shadow-lg shadow-blue-500/30"
                                onclick="return confirm('Konfirmasi penyerahan obat dan pengurangan stok?')">
                                <i class="bi bi-box-arrow-right"></i> Serahkan Obat
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div
                    class="tw-col-span-full tw-bg-white tw-rounded-3xl tw-p-20 tw-text-center tw-border-2 tw-border-dashed tw-border-gray-100">
                    <div
                        class="tw-bg-gray-50 tw-w-20 tw-h-20 tw-rounded-full tw-flex tw-items-center tw-justify-center tw-mx-auto tw-mb-4">
                        <i class="bi bi-inbox tw-text-4xl tw-text-gray-300"></i>
                    </div>
                    <h3 class="tw-text-xl tw-font-black tw-text-gray-400">Belum ada pesanan obat</h3>
                    <p class="tw-text-gray-400 tw-text-sm">Pesanan akan muncul di sini setelah pasien melunasi tagihan di kasir.
                    </p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
