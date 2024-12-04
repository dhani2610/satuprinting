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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('no_inv');
            $table->integer('id_po');
            $table->integer('id_project');
            $table->date('created_date');
            $table->date('deadline');
            $table->integer('category');
            $table->text('description')->nullable();
            $table->string('bill')->nullable();
            $table->string('ppn');
            $table->string('total_ppn');
            $table->string('grand_total');
            $table->integer('created_by');
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
