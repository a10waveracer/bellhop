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
            $table->string('price_start')->nullable();
            $table->string('price_monday_morning')->nullable();
            $table->string('price_monday_night')->nullable();
            $table->string('price_tuesday_morning')->nullable();
            $table->string('price_tuesday_night')->nullable();
            $table->string('price_wednesday_morning')->nullable();
            $table->string('price_wednesday_night')->nullable();
            $table->string('price_thursday_morning')->nullable();
            $table->string('price_thursday_night')->nullable();
            $table->string('price_friday_morning')->nullable();
            $table->string('price_friday_night')->nullable();
            $table->string('price_saturday_morning')->nullable();
            $table->string('price_saturday_night')->nullable();
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
