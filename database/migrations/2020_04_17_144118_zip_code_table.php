<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ZipCodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zipcode', function (Blueprint $table) {
            $table->increments('id');
            $table->string('zip');
            $table->string('type');
            $table->integer('decommissioned');
            $table->string('primary_city');
            $table->string('acceptable_cities');
            $table->string('unacceptable_cities');
            $table->integer('cod_state');
            $table->string('state');
            $table->string('state_ext');
            $table->string('county');
            $table->string('timezone');
            $table->string('area_codes');
            $table->string('world_region');
            $table->string('country');
            $table->double('latitude');
            $table->double('longitude');
            $table->string('irs_estimated_population_2015');
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
        Schema::dropIfExists('zipcode');
    }
}
