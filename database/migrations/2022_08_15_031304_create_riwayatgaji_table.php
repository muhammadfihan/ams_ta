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
        Schema::create('riwayatgaji', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_admin');
            $table->string('email');
            $table->integer('id_jabatan')->unsigned();
            $table->integer('id_golongan')->unsigned()->nullable();
            $table->foreign('id_golongan')->references('id')->on('golongan');
            $table->string('tunjangan')->nullable();
            $table->string('nominal_tunjangan')->nullable();
            $table->string('total_tunjangan')->nullable();
            $table->string('bonus')->nullable();
            $table->string('nominal_bonus')->nullable();
            $table->string('total_bonus')->nullable();
            $table->string('potongan')->nullable();
            $table->string('nominal_potongan')->nullable();
            $table->string('total_potongan')->nullable();
            $table->string('gaji_kotor')->nullable();
            $table->string('gaji_bersih')->nullable();
            $table->string('gaji_pokok')->nullable();
            $table->string('status')->default('Belum Diambil');
            $table->date('tanggal_ambil')->nullable();
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
        Schema::dropIfExists('riwayatgaji');
    }
};
