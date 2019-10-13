<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUkuranBahanBaku extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ukuran_bahans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idUkuran',10);
            $table->string('nama',30);
            $table->integer('id_bahanbaku')->unsigned();
            $table->foreign('id_bahanbaku')->references('id')->on('bahan_bakus')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('stok');
            $table->string('satuan',30);
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
        Schema::table('ukuran_bahan', function (Blueprint $table) {
            $table->dropForeign('id_bahanbaku');
        });
        Schema::dropIfExists('ukuran_bahan');
    }
}
