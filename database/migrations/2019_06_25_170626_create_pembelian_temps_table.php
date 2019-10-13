<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePembelianTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelian_temps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_bahanbaku')->unsigned();
            $table->foreign('id_bahanbaku')->references('id')->on('bahan_bakus')->onDelete('cascade')->onUpdate('cascade');
            $table->string('jenis');
            $table->integer('id_ukuran')->unsigned();
            $table->foreign('id_ukuran')->references('id')->on('ukuran_bahans')->onDelete('cascade')->onUpdate('cascade');
            $table->string('satuan');
            $table->string('kode_pembelian');
            $table->integer('qty');
            $table->date('tanggal_produksi');
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
        Schema::dropIfExists('pembelian_temps');
    }
}
