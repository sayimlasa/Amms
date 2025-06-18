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
        Schema::create('applicant_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('applicant_user_id');
            $table->string('index_no');
            $table->unsignedBigInteger('type_id');
            $table->string('doc_url');
            $table->timestamps();

            $table->foreign('applicant_user_id')->references('id')->on('applicants_users')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('attachment_types')->onDelete('cascade');
       
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applicant_attachments');
    }
};
