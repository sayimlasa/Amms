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
        Schema::create('applicants_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('applicant_user_id');
            $table->string('index_no');
            $table->string('reg_no')->nullable();
            $table->string('amount');
            $table->unsignedBigInteger('bill_id');
            $table->date('bill_generated_at')->nullable();
            $table->string('control_no')->nullable();
            $table->timestamp('controlno_generated_at')->nullable();
            $table->string('receipt_no')->nullable();
            $table->timestamp('pay_date')->nullable();
            $table->string('pay_ref')->nullable();
            $table->string('pay_channel')->nullable();
            $table->string('pay_method')->nullable();
            $table->string('error_code')->nullable();
            $table->boolean('status')->default(0); // Default status to 0
            $table->unsignedBigInteger('academic_year_id');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('applicant_user_id')->references('id')->on('applicants_users')->onDelete('cascade');
            $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('cascade');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applicants_payments');
    }
};
