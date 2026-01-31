<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('transactions', 'invoices');

        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['superadmin', 'user', 'doctor', 'kasir', 'apotek'])->default('user')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['superadmin', 'user', 'doctor', 'kasir'])->default('user')->change();
        });

        Schema::rename('invoices', 'transactions');
    }
};
