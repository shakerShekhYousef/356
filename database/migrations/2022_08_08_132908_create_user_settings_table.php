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
        Schema::create('user_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('get_all_notifications')->default(1);
            $table->boolean('night_node')->default(1);
            $table->foreignId('user_id');
            $table->foreign('user_id')
                ->on('users')
                ->references('id')
                ->onDelete('cascade');
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
        Schema::dropIfExists('user_settings');
    }
};
