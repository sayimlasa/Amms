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
        Schema::table('applicants_choices', function (Blueprint $table) {
            $table->unsignedBigInteger('window_id')->nullable(); // Add the column
            $table->foreign('window_id') // Add the foreign key constraint
                  ->references('id')->on('application_windows')
                  ->onDelete('set null'); // Set null on delete
        
        });
    }
 
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applicants_choices', function (Blueprint $table) {
            //
        });
    }
};
