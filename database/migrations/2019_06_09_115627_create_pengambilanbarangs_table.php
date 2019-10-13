<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengambilanbarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengambilanbarangs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_order')->unsigned();
            $table->foreign('id_order')->references('id')->on('ordered_items')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nama_penerima',30);
            $table->dateTime('tanggal_ambil');
            $table->string('no_telf_pengambil',13);
            $table->string('status_penerimaan',2);
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
        Schema::dropIfExists('pengambilanbarangs');
    }
}
