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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['experience', 'practice']);
            $table->string('location');
            $table->date('date');
            $table->string('time'); // 例：09:00、13:00
            $table->integer('duration'); // 單位：分鐘（ex: 90、180）

            $table->enum('status', ['booked', 'cancelled', 'attended'])->default('booked');

            $table->foreignId('coach_id')->nullable()->constrained('coaches')->nullOnDelete();

            $table->text('notes')->nullable();
            $table->boolean('used_ticket')->default(false); // 自行練習才會用到

            $table->boolean('is_manual')->default(false);   // 是否為後台建立
            $table->string('source')->default('user');      // user / admin / import

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
