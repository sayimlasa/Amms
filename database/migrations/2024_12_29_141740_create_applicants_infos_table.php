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
        Schema::create('applicants_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('applicant_user_id');
            $table->string('index_no');
            $table->string('fname');
            $table->string('mname')->nullable();
            $table->string('lname');
            $table->string('gender');
            $table->unsignedBigInteger('cob_id')->nullable();
            $table->unsignedBigInteger('pob_id')->nullable();
            $table->unsignedBigInteger('dob_id')->nullable(); 
            $table->unsignedBigInteger('nationality')->nullable(); // Foreign Key
            $table->unsignedBigInteger('marital_status_id')->nullable();
            $table->text('physical_address')->nullable();
            $table->unsignedBigInteger('country_id')->nullable(); // Foreign Key
            $table->unsignedBigInteger('region_id')->nullable(); // Foreign Key
            $table->unsignedBigInteger('district_id')->nullable(); // Foreign Key
            $table->unsignedBigInteger('acadmic_year_id');
            $table->unsignedBigInteger('intake_id');
            $table->unsignedBigInteger('campus_id');
            $table->unsignedBigInteger('employment_status')->nullable(); // Foreign Key
            $table->unsignedBigInteger('employer_id')->nullable();
            $table->unsignedBigInteger('disability_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->timestamp('updated_by')->nullable(); 
            $table->date('birth_date')->nullable(); // Store as date
        
            // Foreign key constraints
            $table->foreign('nationality')->references('id')->on('nationalities')->onDelete('set null');
            $table->foreign('employment_status')->references('id')->on('employment_statuses')->onDelete('set null');
            $table->foreign('applicant_user_id')->references('id')->on('applicants_users');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('region_id')->references('id')->on('regions_states');
            $table->foreign('district_id')->references('id')->on('districts');
            $table->foreign('cob_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('pob_id')->references('id')->on('regions_states');
            $table->foreign('dob_id')->references('id')->on('districts')->onDelete('cascade');
            $table->foreign('acadmic_year_id')->references('id')->on('academic_years');
            $table->foreign('intake_id')->references('id')->on('intakes');
            $table->foreign('campus_id')->references('id')->on('campuses');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applicants_infos');
    }
};
