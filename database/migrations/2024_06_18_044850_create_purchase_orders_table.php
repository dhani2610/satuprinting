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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('created_by');
            $table->integer('customer_id');
            $table->date('date');
            $table->integer('id_quo')->nullable();
            $table->string('no_po');
            $table->string('lampiran');
            $table->string('file_po');
            $table->text('catatan');
            $table->string('total');
            $table->string('ppn');
            $table->string('total_ppn');
            $table->string('grand_total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
