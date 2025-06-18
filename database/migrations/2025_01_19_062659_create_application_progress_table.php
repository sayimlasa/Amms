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
        Schema::create('application_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_user_id')->constrained('applicants_users')->onDelete('cascade');
            $table->string('index_no');
            $table->foreignId('academic_year_id')->constrained('academic_years')->onDelete('cascade');
            $table->string('application_step');
            $table->enum('status', ['not started', 'in progress', 'completed'])->default('not started');
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
        Schema::dropIfExists('application_progress');
    }
};
