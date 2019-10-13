<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idProduk',10);
            $table->text('nama',30);
            $table->integer('id_bahanbaku')->unsigned();
            $table->foreign('id_bahanbaku')->references('id')->on('bahan_bakus')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('id_ukuran')->unsigned();
            $table->foreign('id_ukuran')->references('id')->on('ukuran_bahans')->onDelete('cascade')->onUpdate('cascade');
            $table->text('kebutuhan',30);
            $table->enum('jenis_cetak',['Offset','Digital Printing']);
            $table->text('sisi_cetak',30);
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
        Schema::dropIfExists('produks');
    }
}
