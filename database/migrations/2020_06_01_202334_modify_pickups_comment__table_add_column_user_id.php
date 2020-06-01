<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyPickupsCommentTableAddColumnUserId extends Migration
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
        Schema::table('pickups_comments', function (Blueprint $table) {
            $table->integer('users_id')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pickups_comments', function (Blueprint $table) {
            $table->dropColumn('users_id');
        });
    }
}
