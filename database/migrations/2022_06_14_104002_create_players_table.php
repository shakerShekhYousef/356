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
        Schema::create('players', function (Blueprint $table) {
            $table->bigInteger('id')->primary();
            $table->string('name')->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->integer('age')->nullable();
            $table->string('nationality')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->boolean('injured')->nullable();
            $table->string('photo')->nullable();
            $table->string('birth_date')->nullable();
            $table->string('birth_place')->nullable();
            $table->string('birth_country')->nullable();
            $table->foreignId('team_id')->nullable();
            $table->foreignId('season_id')->nullable();
            $table->foreignId('league_id')->nullable();
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
        Schema::dropIfExists('players');
    }
};
