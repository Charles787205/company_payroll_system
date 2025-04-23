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
        Schema::table('employee_deductions', function (Blueprint $table) {
            // Rename the column 'loan_and_deduction' to 'loans_and_deductions'
            $table->renameColumn('loan_or_deduction_id', 'loans_and_deductions_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_deductions', function (Blueprint $table) {
            // Revert the column name back to 'loan_and_deduction_id'
            $table->renameColumn('loans_or_deductions_id', 'loan_and_deduction_id');
        });
    }
};
