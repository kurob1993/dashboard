<?php

use Illuminate\Database\Seeder;

class dataMaster extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('produks')->insert([
        	['id'=>'1','produk' => 'HR','ket' => '-'],
        	['id'=>'2','produk' => 'CR','ket' => '-'],
        	['id'=>'3','produk' => 'PO','ket' => '-'],
        	['id'=>'4','produk' => 'WR','ket' => '-']
        ]);

        DB::table('rkaps')->insert([
        	['produk_id' => '1','bulan' => '1','tahun' => '2018','target'=> '1000'],
        	['produk_id' => '2','bulan' => '1','tahun' => '2018','target'=> '1000'],
        	['produk_id' => '3','bulan' => '1','tahun' => '2018','target'=> '1000'],
        	['produk_id' => '4','bulan' => '1','tahun' => '2018','target'=> '1000']
        ]);

        DB::table('datas')->insert([
             ['produk_id' => '1','tanggal' => '2018-01-18','group' => '1','tag_name' => 'Bahan Baku','current_value'=>'199494,329', 'child1' => '','child2' => ''],
             ['produk_id' => '1','tanggal' => '2018-01-18','group' => '2','tag_name' => 'Open Rolling','current_value'=>'230805', 'child1' => '','child2' => ''],
             ['produk_id' => '1','tanggal' => '2018-01-18','group' => '3','tag_name' => 'Produksi','current_value'=>'18380,41', 'child1' => '','child2' => ''],
             ['produk_id' => '1','tanggal' => '2018-01-18','group' => '4','tag_name' => 'Shipment','current_value'=>'1755,9', 'child1' => '','child2' => ''],
             ['produk_id' => '1','tanggal' => '2018-01-18','group' => '5','tag_name' => 'Stock FG','current_value'=>'2885', 'child1' => 'Cargo','child2' => 'FD Memo Dinas'],
             ['produk_id' => '1','tanggal' => '2018-01-18','group' => '5','tag_name' => 'Stock FG','current_value'=>'4854', 'child1' => 'Cargo','child2' => 'Hold'],
             ['produk_id' => '1','tanggal' => '2018-01-18','group' => '5','tag_name' => 'Stock FG','current_value'=>'1669', 'child1' => 'Cargo','child2' => 'LC/SO Expired'],
             ['produk_id' => '1','tanggal' => '2018-01-18','group' => '5','tag_name' => 'Stock FG','current_value'=>'1097', 'child1' => 'Cargo','child2' => 'Others'],
             ['produk_id' => '1','tanggal' => '2018-01-18','group' => '5','tag_name' => 'Stock FG','current_value'=>'771', 'child1' => 'Cargo','child2' => 'Over Leeway'],
             ['produk_id' => '1','tanggal' => '2018-01-18','group' => '5','tag_name' => 'Stock FG','current_value'=>'7139', 'child1' => 'Cargo','child2' => 'RTS'],
             ['produk_id' => '1','tanggal' => '2018-01-18','group' => '5','tag_name' => 'Stock FG','current_value'=>'10097', 'child1' => 'CIR','child2' => 'CIR'],
             ['produk_id' => '1','tanggal' => '2018-01-18','group' => '5','tag_name' => 'Stock FG','current_value'=>'854', 'child1' => 'Free Stock','child2' => 'IM'],
             ['produk_id' => '1','tanggal' => '2018-01-18','group' => '5','tag_name' => 'Stock FG','current_value'=>'15232', 'child1' => 'Free Stock','child2' => 'IP'],
             ['produk_id' => '1','tanggal' => '2018-01-18','group' => '5','tag_name' => 'Stock FG','current_value'=>'6464', 'child1' => 'Free Stock','child2' => 'IS'],
             ['produk_id' => '1','tanggal' => '2018-01-18','group' => '6','tag_name' => 'WIP','current_value'=>'10306,87', 'child1' => 'WIP','child2' => 'OPG'],
             ['produk_id' => '1','tanggal' => '2018-01-18','group' => '6','tag_name' => 'WIP','current_value'=>'8708,33', 'child1' => 'WIP','child2' => 'OPD'],
             ['produk_id' => '1','tanggal' => '2018-01-18','group' => '6','tag_name' => 'WIP','current_value'=>'1933,21', 'child1' => 'WIP','child2' => 'WIP 629Blnk'],
             ['produk_id' => '1','tanggal' => '2018-01-18','group' => '6','tag_name' => 'WIP','current_value'=>'548,22', 'child1' => 'WIP','child2' => 'Wait Cut Sample'],
             ['produk_id' => '1','tanggal' => '2018-01-18','group' => '6','tag_name' => 'WIP','current_value'=>'1986,93', 'child1' => 'WIP','child2' => 'Others'],
        ]);
        
    }
}
