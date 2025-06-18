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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('table_id')->constrained()->onDelete('cascade');
        
            // Giá trị tiền tệ (đơn vị: đồng, không phải đồng.lẻ)
            $table->integer('subtotal')->default(0);
            $table->integer('discount_amount')->default(0);
             $table->decimal('discount_percent', 5, 2)->default(0);
             $table->integer('tax_amount')->default(0);
            $table->integer('total_amount')->default(0);
            $table->integer('cash_received')->nullable();
            $table->integer('change_amount')->nullable();
        
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
            $table->enum('payment_status', ['unpaid', 'paid', 'partial'])->default('unpaid');
            $table->text('notes')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
