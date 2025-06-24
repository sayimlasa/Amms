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
        Schema::create('asset_attachments', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number', 200)->unique();
            $table->string('derivery_note_number', 200)->nullable();
            $table->string('invoice_no', 200)->nullable();
            $table->string('derivery_note_attachment', 200)->nullable();
            $table->string('invoice_number_attachment', 200)->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('asset_attachments');
    }
};
