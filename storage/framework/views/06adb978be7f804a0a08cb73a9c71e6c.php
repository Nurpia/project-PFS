

<?php $__env->startSection('content'); ?>
    <!-- Load Tailwind specifically for this layout as it feels more modern for billing -->
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
                <h2 class="tw-text-3xl tw-font-black tw-text-gray-900">Dashboard Kasir</h2>
                <p class="tw-text-gray-500">Monitoring transaksi dan pendapatan harian secara real-time.</p>
            </div>
            <div class="tw-flex tw-gap-4">
                <div class="tw-bg-white tw-p-4 tw-rounded-2xl tw-shadow-sm tw-border tw-border-gray-100 tw-text-right">
                    <p class="tw-text-xs tw-text-gray-400 tw-uppercase tw-font-bold tw-mb-1">Kas Masuk Hari Ini</p>
                    <p class="tw-text-2xl tw-font-black tw-text-red-600 tw-mb-0">Rp
                        <?php echo e(number_format($stats['today_revenue'], 0, ',', '.')); ?></p>
                </div>
            </div>
        </div>

        <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-3 tw-gap-6 tw-mb-10">
            <!-- Total Transactions -->
            <div class="tw-bg-white tw-p-6 tw-rounded-3xl tw-shadow-lg tw-shadow-blue-500/5 tw-border tw-border-gray-50">
                <div class="tw-bg-blue-50 tw-w-12 tw-h-12 tw-rounded-2xl tw-flex tw-items-center tw-justify-center tw-mb-4">
                    <i class="bi bi-receipt-cutoff tw-text-blue-500 tw-text-xl"></i>
                </div>
                <p class="tw-text-gray-400 tw-text-sm tw-font-bold tw-mb-1">Total Transaksi</p>
                <p class="tw-text-3xl tw-font-black tw-text-gray-800">
                    <?php echo e(number_format($stats['total_transactions'], 0, ',', '.')); ?></p>
                <div class="tw-mt-4 tw-text-xs tw-text-blue-500 tw-font-bold">Diperbarui Baru Saja</div>
            </div>

            <!-- Pending Payments -->
            <div class="tw-bg-white tw-p-6 tw-rounded-3xl tw-shadow-lg tw-shadow-yellow-500/5 tw-border tw-border-gray-50">
                <div
                    class="tw-bg-yellow-50 tw-w-12 tw-h-12 tw-rounded-2xl tw-flex tw-items-center tw-justify-center tw-mb-4">
                    <i class="bi bi-clock-history tw-text-yellow-500 tw-text-xl"></i>
                </div>
                <p class="tw-text-gray-400 tw-text-sm tw-font-bold tw-mb-1">Belum Lunas</p>
                <p class="tw-text-3xl tw-font-black tw-text-gray-800">
                    <?php echo e(number_format($stats['pending_transactions'], 0, ',', '.')); ?></p>
                <div class="tw-mt-4">
                    <a href="<?php echo e(route('transactions.index')); ?>"
                        class="tw-text-xs tw-text-yellow-600 tw-font-bold tw-hover:tw-underline">Lihat Detail Menunggu <i
                            class="bi bi-arrow-right"></i></a>
                </div>
            </div>

            <!-- Paid Payments -->
            <div class="tw-bg-white tw-p-6 tw-rounded-3xl tw-shadow-lg tw-shadow-green-500/5 tw-border tw-border-gray-50">
                <div
                    class="tw-bg-green-50 tw-w-12 tw-h-12 tw-rounded-2xl tw-flex tw-items-center tw-justify-center tw-mb-4">
                    <i class="bi bi-check2-circle tw-text-green-500 tw-text-xl"></i>
                </div>
                <p class="tw-text-gray-400 tw-text-sm tw-font-bold tw-mb-1">Transaksi Lunas</p>
                <p class="tw-text-3xl tw-font-black tw-text-gray-800">
                    <?php echo e(number_format($stats['total_transactions'] - $stats['pending_transactions'], 0, ',', '.')); ?></p>
                <div class="tw-mt-4 tw-text-xs tw-text-green-500 tw-font-bold">Aktivitas Sangat Baik</div>
            </div>
        </div>

        <div
            class="tw-bg-red-600 tw-rounded-3xl tw-p-10 tw-text-white tw-shadow-2xl tw-shadow-red-500/20 tw-relative tw-overflow-hidden">
            <div class="tw-relative tw-z-10">
                <h3 class="tw-text-2xl tw-font-black tw-mb-2">Kelola Pembayaran Pasien</h3>
                <p class="tw-opacity-80 tw-mb-8 tw-max-w-md">Data tagihan tersinkronisasi otomatis dari rekam medis dokter.
                    Pastikan pembayaran dikonfirmasi tepat waktu.</p>
                <a href="<?php echo e(route('transactions.index')); ?>"
                    class="tw-bg-white tw-text-red-600 tw-px-8 tw-py-3 tw-rounded-2xl tw-font-black tw-text-lg tw-shadow-xl tw-hover:tw-bg-gray-100 tw-transition-all tw-inline-block">
                    Buka Menu Kasir & Tagihan <i class="bi bi-arrow-right-short tw-ml-2"></i>
                </a>
            </div>
            <!-- Decorative icon in bg -->
            <i class="bi bi-cash-coin tw-absolute tw-bottom-[-20%] tw-right-[-5%] tw-text-[200px] tw-opacity-10"></i>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\rekam_medis\resources\views/dashboard/kasir.blade.php ENDPATH**/ ?>