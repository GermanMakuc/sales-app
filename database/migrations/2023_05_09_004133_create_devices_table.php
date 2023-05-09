<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('commerce_id');
            $table->string('name');
            $table->string('model');
            $table->string('ip');
            $table->timestamps();
        });

        Schema::table('devices', function (Blueprint $table) {
            $table->foreign('commerce_id')->references('id')->on('commerces')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('sales', function (Blueprint $table) {
            $table->foreign('device_id')->references('id')->on('devices')->onDelete('cascade')->onUpdate('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
