<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bachelor_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('programme_id')->constrained('programmes')->onDelete('cascade');
            $table->foreignId('application_level_id')->constrained('application_levels')->onDelete('cascade');
            $table->foreignId('education_level_id')->constrained('education_levels')->onDelete('cascade');
            $table->text('subject_course')->nullable();
            $table->integer('min_olevel_pass')->nullable();
            $table->string('min_olevel_average')->nullable();
            $table->integer('min_foundation_gpa')->nullable();
            $table->integer('min_advance_principle_pass')->nullable();
            $table->integer('min_advance_aggregate_points')->nullable();
            $table->boolean('math')->default(0); // Default value set to 0
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bachelor_requirements');
    }
};
