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
        Schema::create('ac_assets', function (Blueprint $table) {
            $table->id();
            $table->string('serial_number', 200)->unique();
            $table->string('reference_number', 200)->nullable();
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->onDelete('set null');
            $table->foreignId('brand_id')->nullable()->constrained('brands')->onDelete('set null');
            $table->string('warranty_expiry_date', 200)->nullable();
            $table->string('warranty_number', 200)->nullable();
            $table->string('model', 200)->nullable();
            $table->string('type', 200)->nullable();
            $table->string('capacity', 200)->nullable();
            $table->string('derivery_note_number', 200)->nullable();
            $table->date('derivery_note_date')->nullable();
            $table->string('lpo_no', 100)->nullable();
            $table->date('invoice_date')->nullable();
            $table->string('invoice_no', 200)->nullable();
            $table->date('installation_date')->nullable();
            $table->string('installed_by', 200)->nullable();
            $table->enum('condition', ['New', 'Mid-used', 'Old'])->default('New');
            $table->enum('status', ['Working', 'Under Repair', 'Scrapped'])->default('Working');
            $table->foreignId('location_id')->nullable()->constrained('locations')->onDelete('set null');
            $table->string('justification_form_no', 200)->nullable();
            $table->timestamps();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ac_assets');
    }
};
