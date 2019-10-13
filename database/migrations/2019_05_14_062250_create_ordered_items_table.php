<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderedItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordered_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_order')->unsigned();
            $table->foreign('id_order')->references('id')->on('penjualans')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('id_produk')->unsigned();
            $table->foreign('id_produk')->references('id')->on('produks')->onDelete('cascade')->onUpdate('cascade');
            $table->text('nama',30);
            $table->decimal('harga',9,2);
            $table->integer('jumlah');
            $table->string('sisi_cetak',30)->nullable();
            $table->text('proses',2)->nullable();
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
        Schema::table('ordered_items', function (Blueprint $table) {
            $table->dropForeign('id_order');
            $table->dropForeign('id_produk');
        });
        Schema::dropIfExists('ordered_items');
    }
}
