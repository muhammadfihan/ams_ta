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
        Schema::create('jamabsen', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('id_admin')->unsigned();
            $table->foreign('id_admin')->references('id')->on('users');
            $table->time('jam_masuk')->default('00:00:00');
            $table->time('jam_pulang')->default('00:00:00');
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
        Schema::dropIfExists('jamabsen');
    }
};
