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
        Schema::create('applicant_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('index_number');
            $table->integer('programme_id');
            $table->integer('campus_id');
            $table->integer('intake_id');
            $table->integer('academic_year_id');
            $table->boolean('status')->default(false);
            $table->boolean('sms_status')->default(false);
            $table->boolean('ors_status')->default(false); 
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
        Schema::dropIfExists('applicant_statuses');
    }
};
