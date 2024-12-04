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
        Schema::create('survey_projects', function (Blueprint $table) {
            $table->id();
            $table->integer('id_team');
            $table->integer('id_project');
            $table->string('no_survey');
            $table->text('note');
            $table->text('photo');
            $table->integer('created_by');
            $table->datetime('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_projects');
    }
};
