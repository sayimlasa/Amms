<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('foundation_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_user_id')->constrained('applicants_users')->onDelete('cascade');
            $table->string('reg_no');
            $table->string('index_no');
            $table->string('first_name');
            $table->string('mid_name')->nullable();
            $table->string('surname');
            $table->char('gender', 1);
            $table->date('birth_date')->nullable();
            $table->string('academic_year');
            $table->float('gpa', 3, 2);
            $table->string('classification');
            $table->string('subject_code');
            $table->string('subject_name');
            $table->string('grade');
            $table->integer('status');
            $table->string('status_description');
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
        Schema::dropIfExists('foundation_results');
    }
};
