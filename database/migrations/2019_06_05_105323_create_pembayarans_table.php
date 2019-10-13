<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePembayaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_order')->unsigned();
            $table->foreign('id_order')->references('id')->on('penjualans')->onDelete('cascade')->onUpdate('cascade');
            $table->text('tipe_pembayaran',30);
            $table->decimal('uang_masuk',9,2);
            $table->decimal('total_pembayaran',9,2);
            $table->decimal('sisa_pembayaran',9,2);
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
        Schema::dropIfExists('pembayarans');
    }
}
