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
        Schema::create('absensipegawai', function (Blueprint $table) {
            $table->increments('uid');
            $table->integer('id');
            $table->integer('id_admin');
            $table->string('name');
            $table->string('nama_lengkap');
            $table->string('email');
            $table->string('selfie_masuk')->nullable();
            $table->string('selfie_pulang')->nullable();
            $table->date('tanggal')->nullable();
            $table->time('jam_masuk')->nullable();
            $table->time('jam_pulang')->nullable();
            $table->time('jam_kerja')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('latitude');
            $table->string('longitude');
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
        Schema::dropIfExists('absensipegawai');
    }
};
