<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_temps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_produk')->unsigned();
            $table->foreign('id_produk')->references('id')->on('produks')->onDelete('restrict')->onUpdate('cascade');
            $table->text('nama',30);
            $table->integer('jumlah');
            $table->decimal('harga',9, 2);
            $table->string('sisi_cetak',30)->nullable();

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
        Schema::dropIfExists('order_temps');
    }
}
