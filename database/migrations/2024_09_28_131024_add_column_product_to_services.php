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
        Schema::table('services', function (Blueprint $table) {
            $table->string('price')->nullable();
            $table->string('image')->nullable()->default('asdjsajdasnjnsajn.webp');
            $table->string('id_category')->nullable()->default(2);
            $table->longText('content')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->dropColumn('image');
            $table->dropColumn('id_category');
            $table->dropColumn('content');
        });
    }
};
