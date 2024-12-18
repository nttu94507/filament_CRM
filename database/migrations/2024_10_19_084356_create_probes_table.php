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
        Schema::create('probes', function (Blueprint $table) {
            $table->id();
            $table->date('date_of_shipment')->nullable()->comment('進貨日');
            $table->date('date_of_manufacturing')->nullable()->comment('製造日');
            $table->string('probe_id')->unique()->comment('probe ID');
            $table->foreignId('customer_id')->nullable()->constrained('customers');
            $table->foreignId('employee_id')->nullable()->constrained('employees');
            $table->string('type')->comment('Probe 型號');
            $table->tinyInteger('status')->default(0)->comment('0-在庫, 1-出貨, 2-借出, 3-故障 , 4-待修');
            $table->integer('cost')->nullable()->comment('成本');
            $table->foreignId('manufacturer_id')->nullable()->constrained('manufacturers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('probes');
    }
};
