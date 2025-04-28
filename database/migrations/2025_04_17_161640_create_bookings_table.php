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

                $table->string('name')->comment('預約人姓名');
                $table->enum('booking_type', ['experience', 'practice'])->comment('預約類型');
                $table->time('time')->comment('預約時間');
                $table->integer('people_count')->default(1)->comment('預約人數');
                $table->text('note')->comment('備註');
                $table->string('phone')->nullable()->comment('預約電話');
                $table->integer('verify_code')->comment('預約碼');
                $table->softDeletes();

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
