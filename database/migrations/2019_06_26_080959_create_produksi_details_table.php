<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProduksiDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produksi_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_produksi')->unsigned();
            $table->foreign('id_produksi')->references('id')->on('produksis')->onDelete('cascade')->onUpdate('cascade');
            $table->date('qty');
            $table->string('type');
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
        Schema::dropIfExists('produksi_details');
    }
}
