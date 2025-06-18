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
        Schema::create('tamisemi_lists', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('fullname');
            $table->year('application_year');
            $table->string('programe_name');
            $table->string('institution_name');
            $table->enum('sex', ['MALE', 'FEMALE']);
            $table->date('date_of_birth');
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('district')->nullable();
            $table->string('region')->nullable();
            $table->string('Next_of_kin_fullname')->nullable();
            $table->string('Next_of_kin_phone_number')->nullable();
            $table->string('Next_of_kin_email')->nullable();
            $table->string('Next_of_kin_address')->nullable();
            $table->string('Next_of_kin_region')->nullable();
            $table->string('relationship')->nullable();
            $table->integer('academic_year_id')->nullable();
            $table->integer('intake_id')->nullable();
            $table->integer('programme_id')->nullable();
            $table->integer('campus_id')->nullable();
            $table->integer('window_id')->nullable();
            $table->boolean('status')->default(false); // Default value set to false (0)
            $table->boolean('ors_status')->default(false); // Default 
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
        Schema::dropIfExists('tamisemi_lists');
    }
};
