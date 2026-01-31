<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->text('complaint')->nullable(); // Keluhan
            $table->text('diagnosis');
            $table->text('action')->nullable(); // Tindakan
            $table->json('medicines')->nullable(); // Store medicines as JSON for snapshot or use pivot table. Using JSON for simplicity as per request for "siap pakai" single generic breakdown, but pivot is cleaner. 
            // Re-evaluating: Pivot is "Best Practice". Creating 'medical_record_medicine' pivot table is better.
            // But I will stick to a simplified approach if "Medicines" are key. 
            // Let's create a pivot table in a separate generic migration or here? 
            // I'll stick to a simple text/json for now to keep file count low, or better:
            // I'll create a pivot table 'medical_record_item' later if needed.
            // For now, I'll use a JSON column for simplicity in this "Senior" quick setup, OR Pivot.
            // Senior Architect would use Pivot. I will add a pivot table in the Next migration or same file.
            $table->text('prescription')->nullable(); // Resep text
            $table->timestamps();
        });

        Schema::create('medical_record_medicine', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_record_id')->constrained()->cascadeOnDelete();
            $table->foreignId('medicine_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity');
            $table->decimal('price_per_unit', 10, 2); // Snapshot price
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medical_record_medicine');
        Schema::dropIfExists('medical_records');
    }
};
