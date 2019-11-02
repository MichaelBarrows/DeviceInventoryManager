<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhoneNumberSimCardPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phone_number_sim_card', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('phone_number');
            $table->foreign('phone_number')->references('phone_number')->on('phone_numbers');
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
        Schema::dropIfExists('phone_number_sim_card');
    }
}
