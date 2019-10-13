<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHargasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hargas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_produk')->unsigned();
            $table->foreign('id_produk')->references('id')->on('produks')->onDelete('cascade')->onUpdate('cascade');
            $table->text('sisi_cetak',30);
            $table->text('quantity',10);
            $table->decimal('harga',9 ,2);
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
        Schema::dropIfExists('hargas');
    }
}
