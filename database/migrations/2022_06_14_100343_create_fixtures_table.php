<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('fixtures', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->string('timzone');
            $table->string('referee')->nullable();
            $table->string('date');
            $table->bigInteger('timestamp');
            $table->string('status_long');
            $table->string('status_short');
            $table->string('status_elapsed');
            $table->bigInteger('period_first')->nullable();
            $table->bigInteger('period_second')->nullable();
            $table->foreignId('league_id')->nullable();
            $table->foreignId('home_team_id')->nullable();
            $table->foreignId('away_team_id')->nullable();
            $table->foreign('league_id')->references('id')->on('leagues')->onDelete('cascade');
            $table->foreign('home_team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('away_team_id')->references('id')->on('teams')->onDelete('cascade');
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
        Schema::dropIfExists('fixtures');
    }
};
