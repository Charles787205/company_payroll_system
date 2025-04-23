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
        Schema::create('employee_deductions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade'); // Link to employees table
            $table->foreignId('loan_or_deduction_id')->constrained('loans_and_deductions')->onDelete('cascade'); // Link to loans_and_deductions table
            $table->decimal('deduction_amount', 10, 2); // Deduction amount for this record
            $table->date('date'); // Date of the deduction
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_deductions');
    }
};
