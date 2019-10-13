F<?php

use Illuminate\Database\Seeder;

class BahanBakuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bahan_bakus')->insert([
            'nama' => 'Concorde 98 gsm',
            'jenis' => 'Kertas',
            'idBB' => 'BB00001',
            'namaukuran' => 'A4'
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'Concorde 98 gsm',
            'jenis' => 'Kertas',
            'idBB' => 'BB00002',
            'namaukuran' => 'F4'
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'HVS 70 gsm',
            'jenis' => 'Kertas',
            'idBB' => 'BB00003',
            'namaukuran' => 'A4'
        ]);
         DB::table('bahan_bakus')->insert([
            'nama' => 'HVS 70 gsm',
            'jenis' => 'Kertas',
            'idBB' => 'BB00004',
            'namaukuran' => 'F4'
        ]);
         DB::table('bahan_bakus')->insert([
            'nama' => 'HVS 70 gsm',
            'jenis' => 'Kertas',
            'idBB' => 'BB00005',
            'namaukuran' => '1/2 F4'
         ]);
          DB::table('bahan_bakus')->insert([
            'nama' => 'HVS 80 gsm',
            'jenis' => 'Kertas',
            'idBB' => 'BB00010',
            'namaukuran' => 'F4'
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'HVS 80 gsm',
            'jenis' => 'Kertas',
            'idBB' => 'BB00011',
            'namaukuran' => 'F4'
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'HVS 80 gsm',
            'jenis' => 'Kertas',
            'idBB' => 'BB00012',
            'namaukuran' => '1/2 F4'
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'HVS 80 gsm',
            'jenis' => 'Kertas',
            'idBB' => 'BB00013',
            'namaukuran' => '1/3 F4'
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'HVS 80 gsm',
            'jenis' => 'Kertas',
            'idBB' => 'BB00014',
            'namaukuran' => '1/4 F4'
        ]);
        DB::table('bahan_bakus')->insert([
            'nama' => 'HVS 80 gsm',
            'jenis' => 'Kertas',
            'idBB' => 'BB00015',
            'namaukuran' => '1/6 F4'
        ]);
    }
}
