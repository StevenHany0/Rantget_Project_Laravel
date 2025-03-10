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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contract_id')->constrained('contracts')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', ['Visa'])->default('Visa');
            $table->string('card_number', 255)->nullable();
            $table->date('payment_date');
            $table->enum('status', ['Completed', 'Cancelled', 'Failed', 'Pending', 'Late'])->default('Pending');
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
