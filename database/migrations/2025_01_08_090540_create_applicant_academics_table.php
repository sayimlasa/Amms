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
        Schema::create('applicant_academics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('applicant_user_id');
            $table->string('index_no');
            $table->unsignedBigInteger('education_level')->nullable();
            $table->string('course');
            $table->string('qualification_no')->nullable();
            $table->string('gpa_divission');
            $table->string('yoc'); // year of completion
            $table->string('center_name');
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('region_id')->nullable();
            $table->unsignedBigInteger('district_id')->nullable();
            $table->timestamps(); // created_at and updated_at
            $table->softDeletes(); // deleted_at

            // Add foreign key constraints
            $table->foreign('applicant_user_id')->references('id')->on('applicants_users')->onDelete('cascade');
            $table->foreign('education_level')->references('id')->on('education_levels')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('region_id')->references('id')->on('regions_states')->onDelete('cascade');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applicant_academics');
    }
};
