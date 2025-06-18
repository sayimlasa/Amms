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
        Schema::create('verification_nactes', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('user_id');
            $table->string('verification_status');
            $table->string('multiple_selection');
            $table->string('academic_year');
            $table->string('intake');
            $table->string('eligibility');
            $table->text('remarks');
            $table->integer('academic_year_id')->nullable();
            $table->integer('intake_id')->nullable();
            $table->integer('programme_id')->nullable();
            $table->integer('campus_id')->nullable();
            $table->integer('window_id')->nullable();
            $table->boolean('status')->default(false); // Default value set to false (0)
            $table->boolean('ors_status')->default(false); // Default value set to false (0)
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
        Schema::dropIfExists('verification_nactes');
    }
};
