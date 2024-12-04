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
        Schema::table('admins', function (Blueprint $table) {
            $table->integer('marketing_ho')->nullable();
            $table->integer('marketing_branch')->nullable();
            $table->integer('marketing_pic_branch')->nullable();
            $table->integer('marketing_perwakilan')->nullable();
            $table->integer('marketer')->nullable();
            $table->string('pin_marketing')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('marketing_ho');
            $table->dropColumn('marketing_branch');
            $table->dropColumn('marketing_pic_branch');
            $table->dropColumn('marketing_perwakilan');
            $table->dropColumn('marketer');
            $table->dropColumn('pin_marketing');
        });
    }
};
