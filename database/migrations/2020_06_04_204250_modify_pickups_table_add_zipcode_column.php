<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPickupsTableAddZipcodeColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Adding a new user column to pickups table, to save the user
        //that pickup depends
        Schema::table('pickups', function (Blueprint $table) {
            $table->string('zipcode')->nullable()->after('longitude');
            $table->integer('pickup_status')->nullable()->after('pickup_at');
            $table->integer('drivers_id')->nullable()->after('pickup_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pickups', function (Blueprint $table) {
            $table->dropColumn('zipcode');
            $table->dropColumn('pickup_status');
            $table->dropColumn('drivers_id');
        });
    }
}
