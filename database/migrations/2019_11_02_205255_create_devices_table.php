<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->string('serial_number')->primary();
            $table->bigInteger('imei');
            $table->unsignedBigInteger('device_type_id');
            $table->foreign('device_type_id')->references('id')->on('device_types');
            $table->unsignedBigInteger('model_id');
            $table->foreign('model_id')->references('id')->on('models');
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
        Schema::dropIfExists('devices');
    }
}
