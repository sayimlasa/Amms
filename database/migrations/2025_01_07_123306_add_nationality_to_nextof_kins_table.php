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
        Schema::table('nextof_kins', function (Blueprint $table) {
            $table->unsignedBigInteger('nationality')->nullable(); // Add the column
            $table->foreign('nationality') // Add the foreign key constraint
                  ->references('id')->on('nationalities')
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
        Schema::table('nextof_kins', function (Blueprint $table) {
            //
        });
    }
};
