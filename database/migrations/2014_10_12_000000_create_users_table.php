<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idUser',10);
            $table->string('name',30);
            $table->string('username',30)->unique();
            $table->string('email',30)->unique();
            $table->string('password');
            $table->string('role',15);
            $table->string('status',2);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        DB::table('users')->insert([
            'idUser' => 'USR01',
            'name' => 'adminsys',
            'username' => 'adminsys',
            'email' => 'adminsys@arie.id',
            'role' => 'adminsystem',
            'status' => '1',
            'password' => Hash::make('adminsystem'), // secret
            'remember_token' => str_random(10),
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now(),
        ]);
        DB::table('users')->insert([
            'idUser' => 'USR07',
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@arie.id',
            'role' => 'admin',
            'status' => '1',
            'password' => Hash::make('admin'), // secret
            'remember_token' => str_random(10),
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now(),
        ]);
        DB::table('users')->insert([
            'idUser' => 'USR02',
            'name' => 'Finance',
            'username' => 'finance',
            'email' => 'finance@arie.id',
            'role' => 'finance',
            'status' => '1',
            'password' => Hash::make('finance'), // secret
            'remember_token' => str_random(10),
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now(),
        ]);
        DB::table('users')->insert([
            'idUser' => 'USR03',
            'name' => 'Gudang',
            'username' => 'gudang',
            'email' => 'gudang@arie.id',
            'role' => 'gudang',
            'status' => '1',
            'password' => Hash::make('gudang'), // secret
            'remember_token' => str_random(10),
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now(),
        ]);
        DB::table('users')->insert([
            'idUser' => 'USR04',
            'name' => 'setting',
            'username' => 'setting',
            'email' => 'setting@arie.id',
            'role' => 'setting',
            'status' => '1',
            'password' => Hash::make('setting'), // secret
            'remember_token' => str_random(10),
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now(),
        ]);
        DB::table('users')->insert([
            'idUser' => 'USR05',
            'name' => 'supervisor',
            'username' => 'supervisor',
            'email' => 'supervisor@arie.id',
            'role' => 'supervisor',
            'status' => '1',
            'password' => Hash::make('supervisor'), // secret
            'remember_token' => str_random(10),
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now(),
        ]);
        DB::table('users')->insert([
            'idUser' => 'USR06',
            'name' => 'manajer',
            'username' => 'manajer',
            'email' => 'manajer@arie.id',
            'role' => 'manajer',
            'status' => '1',
            'password' => Hash::make('manajer'), // secret
            'remember_token' => str_random(10),
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now(),
        ]);
        DB::table('users')->insert([
            'idUser' => 'USR08',
            'name' => 'direktur',
            'username' => 'direktur',
            'email' => 'direktur@arie.id',
            'role' => 'direktur',
            'status' => '1',
            'password' => Hash::make('direktur'), // secret
            'remember_token' => str_random(10),
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now(),
        ]);
        DB::table('users')->insert([
            'idUser' => 'USR09',
            'name' => 'cutting',
            'username' => 'cutting',
            'email' => 'cutting@arie.id',
            'role' => 'cutting',
            'status' => '1',
            'password' => Hash::make('cutting'), // secret
            'remember_token' => str_random(10),
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now(),
        ]);
        DB::table('users')->insert([
            'idUser' => 'USR10',
            'name' => 'finishing',
            'username' => 'finishing',
            'email' => 'finishing@arie.id',
            'role' => 'finishing',
            'status' => '1',
            'password' => Hash::make('finishing'), // secret
            'remember_token' => str_random(10),
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now(),
        ]);
        DB::table('users')->insert([
            'idUser' => 'USR11',
            'name' => 'offset',
            'username' => 'offset',
            'email' => 'offset@arie.id',
            'role' => 'offset',
            'status' => '1',
            'password' => Hash::make('offset'), // secret
            'remember_token' => str_random(10),
            'created_at' => Carbon\Carbon::now(),
            'updated_at' => Carbon\Carbon::now(),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
