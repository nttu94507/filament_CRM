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
            $table->tinyInteger('push_target')->comment('0:topic 1:specific 2:CSV list Upload 3:CSV single Upload');
            $table->string('push_topic')->nullable()->comment('Topic訊息');
            $table->string('push_title')->nullable()->comment('訊息標題');
            $table->string('push_content')->nullable()->comment('訊息內容');
            $table->timestamp('expected_delivery_date')->comment('發送時間');
            $table->string('file_path')->nullable()->comment('CSV檔案位置');
            $table->unsignedInteger('push_status')->comment('發送狀態');
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
