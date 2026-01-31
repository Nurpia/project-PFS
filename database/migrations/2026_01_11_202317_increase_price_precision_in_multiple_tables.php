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
        Schema::table('medicines', function (Blueprint $table) {
            $table->decimal('price', 20, 2)->change();
        });

        Schema::table('medical_record_medicine', function (Blueprint $table) {
            $table->decimal('price_per_unit', 20, 2)->change();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->decimal('total_amount', 20, 2)->change();
        });
    }

    public function down(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->change();
        });

        Schema::table('medical_record_medicine', function (Blueprint $table) {
            $table->decimal('price_per_unit', 10, 2)->change();
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->decimal('total_amount', 12, 2)->change();
        });
    }
};
