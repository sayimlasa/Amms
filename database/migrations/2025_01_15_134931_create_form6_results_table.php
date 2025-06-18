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
        Schema::create('form6_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_user_id')->constrained('applicants_users')->onDelete('cascade');
            $table->string('qualification_no');
            $table->string('subject_code');
            $table->string('subject_name');
            $table->integer('marks')->nullable();
            $table->char('grade');
            $table->string('status');
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
        Schema::dropIfExists('form6_results');
    }
};
