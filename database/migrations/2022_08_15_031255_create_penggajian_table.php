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
        Schema::create('penggajian', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_admin');
            $table->string('email');
            $table->integer('id_jabatan')->unsigned();
            $table->integer('id_golongan')->unsigned()->nullable();
            $table->foreign('id_golongan')->references('id')->on('golongan');
            $table->string('id_tunjangan')->default('-');
            $table->string('id_bonus')->default('-');
            $table->string('id_potongan')->default('-');
            $table->integer('total_tunjangan')->nullable();
            $table->integer('total_bonus')->nullable();
            $table->integer('total_potongan')->nullable();
            $table->integer('total_gaji')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('status')->default('Belum Diambil');
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
        Schema::dropIfExists('penggajian');
    }
};
