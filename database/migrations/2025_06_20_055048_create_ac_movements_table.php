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
        Schema::create('ac_movements', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('ac_id');
            // When a location is deleted, null out these fields:
            $table->foreignId('from_location_id')
                ->nullable()
                ->constrained('locations')
                ->onDelete('set null');
            $table->foreignId('to_location_id')
                ->nullable()
                ->constrained('locations')
                ->onDelete('set null');

            $table->string('movement_type', 20)->nullable();

            // When a user (who moved it) is deleted, null out:
            $table->foreignId('moved_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');

            $table->text('remark')->nullable();
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('ac_movements');
    }
};
