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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('push_target')->comment('0:topic');
            $table->string('push_topic')->nullable();
            $table->string('push_title')->nullable();
            $table->string('push_content')->nullable();
            $table->timestamp('expected_delivery_date');
            $table->string('file_path')->nullable();
            $table->unsignedInteger('push_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
