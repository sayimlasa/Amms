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
        Schema::create('role_user', function (Blueprint $table) {
        $table->unsignedBigInteger('user_id');
        $table->foreign('user_id', 'user_id_fk_10194074')->references('id')->on('users')->onDelete('cascade');
        $table->unsignedBigInteger('role_id');
        $table->foreign('role_id', 'role_id_fk_10194074')->references('id')->on('roles')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_user');
    }
};
