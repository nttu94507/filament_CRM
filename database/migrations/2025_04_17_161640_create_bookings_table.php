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

            $table->string('name')->comment('預約人姓名');                // 預約人姓名
            $table->string('phone')->comment('預約手機號碼');               // 手機號碼
            $table->enum('booking_type', ['experience', 'practice'])->comment('預約類型'); // 預約類型
            $table->date('date')->comment('預約日期');                  // 預約日期
            $table->time('time')->comment('預約時間');                  // 預約時間
            $table->unsignedTinyInteger('people_count')->default(1)->comment('預約人數'); // 人數
            $table->text('note')->nullable();      // 備註
            $table->string('booking_code', 6);
            $table->index(['phone', 'booking_code']);
            $table->timestamps();
            $table->softDeletes();

            // 為避免同手機重複預約同時間，建議加上這個複合索引
            $table->unique(['phone', 'date', 'time'], 'booking_unique_phone_datetime');
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
