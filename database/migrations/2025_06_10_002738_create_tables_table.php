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
        Schema::create('tables', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên bàn (VD: Bàn 1, Bàn A1)
            $table->integer('capacity'); // Số chỗ ngồi
            $table->enum('status', ['available', 'occupied', 'reserved', 'maintenance'])->default('available');
            // available: Trống, occupied: Đang sử dụng, reserved: Đã đặt, maintenance: Bảo trì
            $table->string('location')->nullable(); // Vị trí (VD: Tầng 1, Khu vực ngoài trời)
            $table->text('description')->nullable(); // Mô tả thêm
            $table->boolean('is_active')->default(true); // Có hoạt động không
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
};
