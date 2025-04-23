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
        Schema::create('loans_and_deductions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade'); // Link to employees table
            $table->enum('type', ['loan', 'deduction']); // 'loan' or 'deduction'
            $table->decimal('amount', 10, 2); // Total amount of the loan or deduction
            $table->decimal('remaining_balance', 10, 2)->nullable(); // Remaining balance (nullable for consistent deductions)
            $table->enum('frequency', ['monthly', 'bi-weekly']); // Deduction frequency
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans_and_deductions');
    }
};
