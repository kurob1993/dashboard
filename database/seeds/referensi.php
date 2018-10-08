<?php

use Illuminate\Database\Seeder;

class referensi extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('referensi')->insert([
        	['group' => '1',
            'tag_name' => 'Bahan Baku',
            'unit' => '-',
            'description' => '-',
            'sap_tag_name' => '-'],
            ['group' => '2',
            'tag_name' => 'Open Rolling',
            'unit' => '-',
            'description' => '-',
            'sap_tag_name' => '-'],
            ['group' => '3',
            'tag_name' => 'Produksi',
            'unit' => '-',
            'description' => '-',
            'sap_tag_name' => '-'],
            ['group' => '4',
            'tag_name' => 'Shipment',
            'unit' => '-',
            'description' => '-',
            'sap_tag_name' => '-'],
            ['group' => '5',
            'tag_name' => 'Stock FG',
            'unit' => '-',
            'description' => '-',
            'sap_tag_name' => '-'],

            ['group' => '6',
            'tag_name' => 'WIP',
            'unit' => '-',
            'description' => '-',
            'sap_tag_name' => '-']
        ]);
    }
}
