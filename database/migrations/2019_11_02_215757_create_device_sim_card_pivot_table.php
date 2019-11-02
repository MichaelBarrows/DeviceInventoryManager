<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceSimCardPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_sim_card', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('device_serial_number');
            $table->foreign('device_serial_number')->references('serial_number')->on('devices');
            $table->unsignedBigInteger('sim_number');
            $table->foreign('sim_number')->references('sim_number')->on('sim_cards');
            $table->date('assignment_start');
            $table->date('assignment_end');
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
        Schema::table('device_sim_card', function (Blueprint $table) {
            //
        });
    }
}
