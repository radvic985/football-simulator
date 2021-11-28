<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('match_results', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('week')->index();
            $table->unsignedInteger('home_team_id');
            $table->unsignedInteger('guest_team_id');
            $table->unsignedTinyInteger('home_goals');
            $table->unsignedTinyInteger('guest_goals');
            $table->unsignedTinyInteger('home_pts');
            $table->unsignedTinyInteger('guest_pts');
        });

        Schema::table('match_results', function (Blueprint $table) {
            $table->foreign('home_team_id')->references('id')->on('teams');
            $table->foreign('guest_team_id')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('match_results', function (Blueprint $table) {
            $table->dropForeign(['home_team_id']);
            $table->dropForeign(['guest_team_id']);
        });

        Schema::dropIfExists('match_results');
    }
}
