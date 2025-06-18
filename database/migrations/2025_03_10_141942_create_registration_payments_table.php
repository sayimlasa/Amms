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
        Schema::create('registration_payments', function (Blueprint $table) {
            $table->id();
            $table->string('index_no')->nullable();
            $table->string('control_no')->nullable();
            $table->integer('billId')->nullable();
            $table->string('regno')->nullable();
            $table->double('amount')->nullable();
            $table->string('nta')->nullable();
            $table->integer('academic_year_id')->nullable();
            $table->date('date_request')->nullable();
            $table->date('date_paid')->nullable();
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('registration_payments');
    }
};
