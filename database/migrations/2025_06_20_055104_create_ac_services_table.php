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
        Schema::create('ac_services', function (Blueprint $table) {
           $table->id();
            $table->unsignedBigInteger('ac_id');
            $table->date('service_date')->nullable();
            $table->string('service_type')->nullable();
            $table->foreignId('technical_name')->nullable()->constrained('users')->onDelete('set null');
            $table->text('issues_found')->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('location_id')->nullable()->constrained('locations')->onDelete('set null');
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
        Schema::dropIfExists('ac_services');
    }
};
