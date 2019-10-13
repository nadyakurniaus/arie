<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePembelianDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelian_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_bahanbaku');
            $table->integer('id_pembelian')->unsigned();
            $table->foreign('id_pembelian')->references('id')->on('pembelians')->onDelete('cascade')->onUpdate('cascade');
            $table->string('jenis');
            $table->integer('id_ukuran');
            $table->string('satuan');
            $table->string('kode_pembelian');
            $table->integer('qty');
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
        Schema::dropIfExists('pembelian_details');
    }
}
