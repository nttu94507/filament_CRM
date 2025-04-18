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
        Schema::create('sysusers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 顯示用名稱
            $table->string('email')->unique();
            $table->string('password');

            $table->string('role')->default('admin'); // admin / superadmin / manager 等
            $table->boolean('is_active')->default(true); // 是否啟用帳號

            $table->rememberToken(); // for "remember me"
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sysusers');
    }
};
