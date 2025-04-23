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
        Schema::table('payrolls', function (Blueprint $table) {
            // Add the status column as ENUM with values 'pending', 'declined', and 'approved'
            $table->enum('status', ['pending', 'declined', 'approved', 'paid'])->default('pending')->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payrolls', function (Blueprint $table) {
            // Drop the status column
            $table->dropColumn('status');
        });
    }
};
