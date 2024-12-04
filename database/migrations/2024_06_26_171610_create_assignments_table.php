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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->string('no_assignment');
            $table->integer('id_customer');
            $table->integer('id_project');
            $table->integer('id_user');
            $table->text('tujuan');
            $table->time('time_start');
            $table->time('time_end');
            $table->text('note');
            $table->date('tanggal');
            $table->integer('status')->default(1);
            $table->datetime('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
