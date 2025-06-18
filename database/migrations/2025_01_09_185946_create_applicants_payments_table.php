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
            $table->string('index_id');
            $table->string('reg_no')->nullable();
            $table->string('name')->nullable();
            $table->string("control_number")->nullable();
            $table->integer("billId")->nullable();
            $table->decimal('amount', 8, 2)->nullable();
            $table->string('generated_at')->nullable();
            $table->string('date_paid')->nullable();
            $table->string('receipt_no')->nullable();
            $table->string('pay_date')->nullable();
            $table->string('pay_ref')->nullable();
            $table->string('pay_channel')->nullable();
            $table->string('pay_method')->nullable();
            $table->boolean('status')->default(0); // Default status to 0
            $table->timestamps();
        });
    
    }
    public function down()
    {
        Schema::dropIfExists('applicants_payments');
    }
};
