<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('code_booking')->unique();
            $table->enum('status', ['pending', 'confirmated', 'canceled'])->default('pending');
            $table->string('qris')->nullable();
            $table->decimal('total', 12, 2)->default(0);
            $table->date('tgl_sewa');
            $table->date('tgl_pengembalian');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
