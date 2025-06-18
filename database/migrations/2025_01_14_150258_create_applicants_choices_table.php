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
        Schema::create('applicants_choices', function (Blueprint $table) {
            $table->id();
            $table->integer("applicant_user_id")->nullable();
            $table->string('index_no')->nullable();
            $table->integer('choice1')->nullable();
            $table->integer('choice2')->nullable();
            $table->integer('choice3')->nullable();
            $table->integer('campus_id')->nullable();
            $table->integer('intake_id')->nullable();
            $table->integer('academic_year_id')->nullable();
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('applicants_choices');
    }
};
