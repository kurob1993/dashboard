<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class data extends Model
{
	protected $table = 'datas_vd';
	public $timestamps = false;

	public function view_wipChild1($produk_id,$tgl_kemarin)
	{
		$ret = DB::table('wip_child1_vd')
					->where('produk_id',$produk_id)
					->where('tanggal',$tgl_kemarin)
					->get();
		return $ret; 
	}
	public function view_wipChild2($produk_id,$tgl_kemarin)
	{
		$ret = DB::table('wip_child2_vd')
					->where('produk_id',$produk_id)
					->where('tanggal',$tgl_kemarin)
					->get();
		return $ret; 
	}
	
	public function data_total($produk_id,$tgl_kemarin)
	{
		$ret = DB::table('data_total_vd')
					->where('produk_id',$produk_id)
					// ->where('tanggal',$tgl_kemarin)
					->get();
		return $ret; 
	}
}
