<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inbound_shipments', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_number')->unique();
            $table->string('supplier_name');
            $table->string('manifest_data');
            $table->string('status')->default('on_the_way');
            $table->dateTime('estimated_arrival');
            $table->string('current_position')->nullable();
            $table->string('legacy_receipt_number')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inbound_shipments');
    }
};