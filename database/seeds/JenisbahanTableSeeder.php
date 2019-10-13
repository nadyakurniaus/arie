<?php

use Illuminate\Database\Seeder;

class JenisbahanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jenis_bahans')->insert([
            'nama' => 'kain'
        ]);
        DB::table('jenis_bahans')->insert([
            'nama' => 'amplop'
        ]);
        DB::table('jenis_bahans')->insert([
            'nama' => 'kertas'
        ]);
    }
}
