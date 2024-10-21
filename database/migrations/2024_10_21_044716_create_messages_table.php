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
            $table->unsignedInteger('pushTarget');
            $table->unsignedInteger('pushType');
            $table->string('pushTopic')->nullable();
            $table->string('pushTitle')->nullable();
            $table->string('pushContent')->nullable();
            $table->datetime('expected_delivery_date')->nullable();
            $table->longText('conditions_json')->nullable();
            $table->string('conditionOperator')->nullable();
            $table->unsignedInteger('pushStatusForAndroid');
            $table->unsignedInteger('pushStatusForIOS');
            $table->string('pushStatusMemoForAndroid')->nullable();
            $table->string('pushStatusMemoForIOS')->nullable();
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
