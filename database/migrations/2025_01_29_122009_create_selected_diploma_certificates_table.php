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
        Schema::create('selected_diploma_certificates', function (Blueprint $table) {
            $table->id();
            $table->integer('applicant_user_id')->nullable();
            $table->string('index_no')->nullable();
            $table->string('qualification_no')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('disability')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('physical_address')->nullable();
            $table->integer('campus_id')->nullable();
            $table->string('region')->nullable();
            $table->string('district')->nullable();
            $table->string('nationality')->nullable();
            $table->string('next_kin_name')->nullable();
            $table->string('next_kin_address')->nullable();
            $table->string('next_kin_email')->nullable();
            $table->string('next_kin_phone')->nullable();
            $table->string('next_kin_region')->nullable();
            $table->string('next_kin_district')->nullable();
            $table->string('next_kin_nationality')->nullable();
            $table->string('next_kin_relationship')->nullable();
            $table->string('iaa_programme_code')->nullable();
            $table->string('nacte_programme_code')->nullable();
            $table->string('application_year')->nullable();
            $table->string('intake')->nullable();
            $table->string('nta_level')->nullable();
            $table->string('window')->nullable();
            $table->integer('application_category_id')->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('selected_diploma_certificates');
    }
};
