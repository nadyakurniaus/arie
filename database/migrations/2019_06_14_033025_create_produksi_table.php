<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProduksiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produksis', function (Blueprint $table) {
            $table->increments('id');
            $table->text('kode_produksi',10);
            $table->integer('id_item')->unsigned();
            $table->foreign('id_item')->references('id')->on('ordered_items')->onDelete('cascade')->onUpdate('cascade');
            $table->string('desc',120);
            $table->integer('id_bahan_baku')->unsigned();
            $table->foreign('id_bahan_baku')->references('id')->on('bahan_bakus')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('id_ukuran')->unsigned();
            $table->foreign('id_ukuran')->references('id')->on('ukuran_bahans')->onDelete('cascade')->onUpdate('cascade');
            $table->text('status',2);
            $table->dateTime('jadwal_produksi')->nullable();
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
        Schema::dropIfExists('produksis');
        
    }
}
