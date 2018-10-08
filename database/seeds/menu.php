<?php

use Illuminate\Database\Seeder;

class menu extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//group menu
        DB::table('sys_groups')->insert([
            'node_group' => '1',
            'group' => 'Data Master',
            'icon' => 'fa fa-database'
        ]);

        //menu
        DB::table('sys_menus')->insert([
            'node_group' => '1',
            'node_menu' => '1',
            'link' => '/rkap',
            'menu' => 'RKAP',
            'level' => '1',
            'status' => 'Y'
        ]);
        DB::table('sys_menus')->insert([
            'node_group' => '1',
            'node_menu' => '2',
            'link' => '/data',
            'menu' => 'DATA',
            'level' => '1',
            'status' => 'Y'
        ]);
    }
}
