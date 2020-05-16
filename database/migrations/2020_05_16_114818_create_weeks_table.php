<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeeksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weeks', function (Blueprint $table) {
            $table->id();
            $table->string('year');
            $table->string('week');
            $table->string('price_start');
            $table->string('price_monday_morning');
            $table->string('price_monday_night');
            $table->string('price_tuesday_morning');
            $table->string('price_tuesday_night');
            $table->string('price_wednesday_morning');
            $table->string('price_wednesday_night');
            $table->string('price_thursday_morning');
            $table->string('price_thursday_night');
            $table->string('price_friday_morning');
            $table->string('price_friday_night');
            $table->string('price_saturday_morning');
            $table->string('price_saturday_night');
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
        Schema::dropIfExists('weeks');
    }
}
