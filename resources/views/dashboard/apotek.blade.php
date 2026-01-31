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
                <h2 class="tw-text-3xl tw-font-black tw-text-gray-900">Dashboard Apotek</h2>
                <p class="tw-text-gray-500">Monitoring stok obat dan status penyerahan resep.</p>
            </div>
        </div>

        <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-3 tw-gap-6 tw-mb-10">
            <!-- Pending Prescriptions -->
            <div class="tw-bg-white tw-p-6 tw-rounded-3xl tw-shadow-lg tw-shadow-blue-500/5 tw-border tw-border-gray-50">
                <div class="tw-bg-blue-50 tw-w-12 tw-h-12 tw-rounded-2xl tw-flex tw-items-center tw-justify-center tw-mb-4">
                    <i class="bi bi-hourglass-split tw-text-blue-500 tw-text-xl"></i>
                </div>
                <p class="tw-text-gray-400 tw-text-sm tw-font-bold tw-mb-1">Resep Menunggu</p>
                <p class="tw-text-3xl tw-font-black tw-text-gray-800">{{ $stats['pending_prescriptions'] }}</p>
                <div class="tw-mt-4">
                    <a href="{{ route('apotek.index') }}"
                        class="tw-text-xs tw-text-blue-500 tw-font-bold tw-hover:tw-underline">Buka Antrean <i
                            class="bi bi-arrow-right"></i></a>
                </div>
            </div>

            <!-- Handed Over Today -->
            <div class="tw-bg-white tw-p-6 tw-rounded-3xl tw-shadow-lg tw-shadow-green-500/5 tw-border tw-border-gray-50">
                <div
                    class="tw-bg-green-50 tw-w-12 tw-h-12 tw-rounded-2xl tw-flex tw-items-center tw-justify-center tw-mb-4">
                    <i class="bi bi-check-all tw-text-green-500 tw-text-xl"></i>
                </div>
                <p class="tw-text-gray-400 tw-text-sm tw-font-bold tw-mb-1">Diserahkan Hari Ini</p>
                <p class="tw-text-3xl tw-font-black tw-text-gray-800">{{ $stats['today_handed_over'] }}</p>
                <div class="tw-mt-4">
                    <a href="{{ route('apotek.history') }}"
                        class="tw-text-xs tw-text-green-500 tw-font-bold tw-hover:tw-underline">Lihat Riwayat <i
                            class="bi bi-arrow-right"></i></a>
                </div>
            </div>

            <!-- Total Medicines -->
            <div class="tw-bg-white tw-p-6 tw-rounded-3xl tw-shadow-lg tw-shadow-purple-500/5 tw-border tw-border-gray-50">
                <div
                    class="tw-bg-purple-50 tw-w-12 tw-h-12 tw-rounded-2xl tw-flex tw-items-center tw-justify-center tw-mb-4">
                    <i class="bi bi-box-seam tw-text-purple-500 tw-text-xl"></i>
                </div>
                <p class="tw-text-gray-400 tw-text-sm tw-font-bold tw-mb-1">Total Jenis Obat</p>
                <p class="tw-text-3xl tw-font-black tw-text-gray-800">{{ $stats['total_medicines'] }}</p>
                <div class="tw-mt-4">
                    <a href="{{ route('medicines.index') }}"
                        class="tw-text-xs tw-text-purple-500 tw-font-bold tw-hover:tw-underline">Kelola Stok <i
                            class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>

        <div
            class="tw-bg-blue-600 tw-rounded-3xl tw-p-10 tw-text-white tw-shadow-2xl tw-shadow-blue-500/20 tw-relative tw-overflow-hidden">
            <div class="tw-relative tw-z-10">
                <h3 class="tw-text-2xl tw-font-black tw-mb-2">Penyerahan Obat & Stok</h3>
                <p class="tw-opacity-80 tw-mb-8 tw-max-w-md">Pastikan resep diperiksa dengan teliti sebelum diserahkan. Stok
                    akan berkurang otomatis saat konfirmasi penyerahan.</p>
                <a href="{{ route('apotek.index') }}"
                    class="tw-bg-white tw-text-blue-600 tw-px-8 tw-py-3 tw-rounded-2xl tw-font-black tw-text-lg tw-shadow-xl tw-hover:tw-bg-gray-100 tw-transition-all tw-inline-block">
                    Lihat Antrean Resep <i class="bi bi-arrow-right-short tw-ml-2"></i>
                </a>
            </div>
            <i class="bi bi-capsule-pill tw-absolute tw-bottom-[-20%] tw-right-[-5%] tw-text-[200px] tw-opacity-10"></i>
        </div>
    </div>
@endsection
