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
        Schema::table('loans_and_deductions', function (Blueprint $table) {
            // Add a 'name' column
            $table->string('name')->after('employee_id')->nullable();

            // Make 'remaining_balance' nullable
            $table->decimal('remaining_balance', 10, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans_and_deductions', function (Blueprint $table) {
            // Drop the 'name' column
            $table->dropColumn('name');

            // Revert 'remaining_balance' to not nullable
            $table->decimal('remaining_balance', 10, 2)->nullable(false)->change();
        });
    }
};
