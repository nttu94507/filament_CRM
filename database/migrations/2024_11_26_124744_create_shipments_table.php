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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('action_type')->comment('0:出貨 1:換貨 2:借測 3:内借 4:故障退回');
            $table->foreignId('receiver_id')->comment('收件者');
            $table->foreignId('user_id')->comment('建立者');
            $table->string('case_id')->comment('案件編號');
            $table->unsignedInteger('total')->comment('總金額');
            $table->string('note')->comment('備註')->nullable();
            $table->timestamps();
        });

        Schema::create('shipment_items', function (Blueprint $table) {
            $table->id();
//            $table->tinyInteger('case_id')->comment('0:出貨 1:換貨 2:借測 3:内借 4:故障退回');
//            $table->foreignId('receiver_id')->comment('收件者');
//            $table->foreignId('user_id')->comment('建立者');
            $table->string('case_id')->comment('案件編號');
            $table->foreignId('probe_id');
//            $table->unsignedInteger('total');
//            $table->string('note')->comment('備註')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
        Schema::dropIfExists('shipment_items');
    }
};
