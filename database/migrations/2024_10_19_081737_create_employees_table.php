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
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            //            $table->string('password');
            $table->string('status')->default('active');
            $table->dateTime('start_date')->default(now());
            $table->dateTime('end_date')->nullable();
            //            $table->foreignId('department_id')->nullable()->constrained();
            //            $table->foreignId('position_id')->nullable()->constrained();
            //            $table->string('department');
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
