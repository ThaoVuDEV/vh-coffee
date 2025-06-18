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
        Schema::create('ingredient_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ingredient_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['import', 'export', 'adjustment']); 
            $table->integer('quantity');
            $table->integer('unit_price')->nullable();
            $table->integer('total_amount')->nullable();
            $table->text('note')->nullable();
            $table->string('reference_number')->nullable(); 
            $table->timestamp('transaction_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredient_transactions');
    }
};
