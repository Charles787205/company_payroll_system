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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Foreign key to users table
            $table->foreignId('position_id')->constrained('positions')->onDelete('cascade'); // Foreign key to positions table
            $table->decimal('salary', 10, 2);
            $table->date('hire_date');
            $table->date('birthdate'); // Add Birthdate
            $table->integer('age')->nullable(); // Add Age
            $table->string('address', 255)->nullable(); // Add Address
            $table->string('sss_number', 15)->nullable(); // Add SSS Number
            $table->string('pagibig_number', 15)->nullable(); // Add Pag-IBIG Number
            $table->string('philhealth_number', 20)->nullable(); // Add PhilHealth Number
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};