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
        Schema::create('verify_qualifications', function (Blueprint $table) {
            $table->id();
            $table->string('regno')->nullable();
            $table->string('index_no')->nullable();
            $table->boolean('blended')->nullable();
            $table->boolean('studymode')->nullable();
            $table->boolean('nhif')->nullable();
            $table->boolean('necta_iv')->nullable();
            $table->boolean('necta_vi')->nullable();
            $table->boolean('diploma')->nullable();
            $table->boolean('medical_form')->nullable();
            $table->boolean('birth_certificate')->nullable();
            $table->boolean('bachelor_certificate')->nullable();
            $table->boolean('bachelor_transcript')->nullable();
            $table->date('date_registered')->nullable();
            $table->integer('programme_id')->nullable();
            $table->integer('intake_id')->nullable();
            $table->integer('campus_id')->nullable();
            $table->integer('academic_year_id')->nullable();
            $table->boolean('isms')->nullable();
            $table->boolean('nacte_status')->default(false);
            $table->boolean('tcu_status')->default(false);
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
        Schema::dropIfExists('verify_qualifications');
    }
};
