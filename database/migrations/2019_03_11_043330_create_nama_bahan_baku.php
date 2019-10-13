<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNamaBahanBaku extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bahan_bakus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idBB',10);
            $table->string('nama',30);
            $table->string('namaukuran',30);
            $table->string('jenis',30);
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
        Schema::table('bahan_baku', function (Blueprint $table) {
            $table->dropForeign('id_jenis');
        });
        Schema::dropIfExists('bahan_baku');
    }
}
