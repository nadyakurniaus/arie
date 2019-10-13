<?php

use Illuminate\Database\Seeder;

class UkuranbahanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ukuran_bahans')->insert([
            'nama' => 'A4',
            'id_bahanbaku' => '1',
            'stok' => '1000',
            'satuan' => 'pcs'
        ]);
        DB::table('ukuran_bahans')->insert([
            'nama' => 'F4',
            'id_bahanbaku' => '2',
            'stok' => '1000',
            'satuan' => 'pcs'
        ]);
        DB::table('ukuran_bahans')->insert([
            'nama' => 'A4',
            'id_bahanbaku' => '3',
            'stok' => '1000',
            'satuan' => 'pcs'
        ]);
        DB::table('ukuran_bahans')->insert([
            'nama' => 'F4',
            'id_bahanbaku' => '4',
            'stok' => '1000',
            'satuan' => 'pcs'
        ]);
        DB::table('ukuran_bahans')->insert([
            'nama' => '1/2 F4',
            'id_bahanbaku' => '5',
            'stok' => '1000',
            'satuan' => 'pcs'
        ]);
        DB::table('ukuran_bahans')->insert([
            'nama' => '1/3 F4',
            'id_bahanbaku' => '6',
            'stok' => '1000',
            'satuan' => 'pcs'
        ]);
        DB::table('ukuran_bahans')->insert([
            'nama' => '1/4 F4',
            'id_bahanbaku' => '7',
            'stok' => '1000',
            'satuan' => 'pcs'
        ]);
        DB::table('ukuran_bahans')->insert([
            'nama' => '1/6 F4',
            'id_bahanbaku' => '8',
            'stok' => '1000',
            'satuan' => 'pcs'
        ]);
        DB::table('ukuran_bahans')->insert([
            'nama' => 'A4',
            'id_bahanbaku' => '9',
            'stok' => '1000',
            'satuan' => 'pcs'
        ]);
        DB::table('ukuran_bahans')->insert([
            'nama' => 'F4',
            'id_bahanbaku' => '10',
            'stok' => '1000',
            'satuan' => 'pcs'
        ]);
         DB::table('ukuran_bahans')->insert([
            'nama' => 'F4',
            'id_bahanbaku' => '11',
            'stok' => '1000',
            'satuan' => 'pcs'
        ]);
          DB::table('ukuran_bahans')->insert([
            'nama' => '1/2 F4',
            'id_bahanbaku' => '12',
            'stok' => '1000',
            'satuan' => 'pcs'
        ]);
           DB::table('ukuran_bahans')->insert([
            'nama' => '1/3 F4',
            'id_bahanbaku' => '13',
            'stok' => '1000',
            'satuan' => 'pcs'
        ]);
            DB::table('ukuran_bahans')->insert([
            'nama' => '1/4 F4',
            'id_bahanbaku' => '14',
            'stok' => '1000',
            'satuan' => 'pcs'
        ]);
            DB::table('ukuran_bahans')->insert([
            'nama' => '1/6 F4',
            'id_bahanbaku' => '15',
            'stok' => '1000',
            'satuan' => 'pcs'
        ]);

    }
}
