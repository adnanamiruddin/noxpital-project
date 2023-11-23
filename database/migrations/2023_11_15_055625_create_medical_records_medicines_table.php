<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('medical_records_medicines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_medical_record')->constrained('medical_records');
            $table->foreignId('id_medicine')->constrained('medicines');
            $table->integer('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records_medicines');
    }
};
