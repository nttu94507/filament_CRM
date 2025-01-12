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
            $table->tinyInteger('action_type')->default('1')->comment('1:出貨 2:換貨 3:借測 4:内借 5:故障退回');
            $table->foreignId('customer_id')->nullable()->comment('收件者');
            $table->foreignId('user_id')->comment('建立者');
            $table->string('case_id')->comment('案件編號');
            $table->unsignedInteger('total')->nullable()->comment('總金額');
            $table->string('note')->nullable()->comment('備註');
            $table->timestamps();
        });

        Schema::create('shipment_items', function (Blueprint $table) {
            $table->id();
            $table->string('shipment_id')->comment('案件編號');
            $table->foreignId('probe_id');
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
