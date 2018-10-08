<?php

use Illuminate\Database\Seeder;

class sys_users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sys_users')->insert([
            'nik' => '1000',
            'username' => 'kurob',
            'name' => 'kurob saja',
            'jabatan' => 'Web developer',
            'email' => 'kurob1993@gmail.com',
            'level' => '1',
        ]);
        DB::table('sys_users')->insert([
            'nik' => '1001',
            'username' => 'admin',
            'name' => 'Administrator',
            'jabatan' => 'Web Administrator',
            'email' => 'admin@gmail.com',
            'level' => '1',
        ]);
    }
}
