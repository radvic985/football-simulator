<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChampionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('champions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('team_id');
            $table->unsignedTinyInteger('played');
            $table->unsignedTinyInteger('won');
            $table->unsignedTinyInteger('drawn');
            $table->unsignedTinyInteger('lost');
            $table->unsignedTinyInteger('gf');
            $table->unsignedTinyInteger('ga');
            $table->tinyInteger('gd');
            $table->unsignedTinyInteger('points');
            $table->unsignedTinyInteger('prev_pos')->default(0);
            $table->unsignedTinyInteger('pos')->default(0);
        });

        Schema::table('champions', function (Blueprint $table) {
            $table->foreign('team_id')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('champions', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
        });

        Schema::dropIfExists('champions');
    }
}
