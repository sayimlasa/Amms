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
        Schema::create('store_invetories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ac_id');
            $table->string('source', 20)->nullable();
            $table->date('date_received')->nullable();
            $table->string('store_location', 20)->nullable();
            $table->enum('initial_status', ['New', 'Used', 'Damaged'])->nullable();
            $table->enum('updated_status', ['New', 'Used', 'Damaged'])->nullable();
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
        Schema::dropIfExists('store_invetories');
    }
};
