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
        Schema::table('activities', function (Blueprint $table) {
            $table->integer('id_project')->nullable(true)->change();
            $table->integer('id_customer')->nullable(true)->change();
            $table->string('category')->nullable(true);
            $table->string('activity_category')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->integer('id_project')->nullable(false)->change();
            $table->integer('id_customer')->nullable(false)->change();
            $table->dropColumn('category');
            $table->dropColumn('activity_category');
        });
    }
};
