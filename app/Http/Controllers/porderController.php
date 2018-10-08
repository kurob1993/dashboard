<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use App\produk;
use App\porder;
//use App\data;
class porderController extends Controller
{
	public function __construct ()
	{

	}
	public function index(Request $request)
	{
		//$produk         = new produk;
        //$produk_ret = $produk::all();

        $data_group = $request->get('data_group');
        $data_menu = $request->get('data_menu');
    	return view('logistik/porder',['data_group'=>$data_group, 'data_menu'=>$data_menu]);
	}

	public function poeqbln(Request $request)
    {
		$bln 	= '9';//date('m');
		$thn	= '2017';
		//$db 	= new Database();
		$sqlb	= ("SELECT pogrp as label, sum(totalprice) as `value` from po where month(createdtpo)='".$bln."' and year(createdtpo)='".$thn."' Group By pogrp");
		$sqlj	= ("select * from vncs");
		
		$prb	= DB::select($sqlb);
		$prj	= DB::select($sqlj);
		
		$sqlbb	= ("SELECT SUBSTR(material, 1, 2) as `label`, 
				IFNULL(SUM(TotalPrice),0) as `value` from po 
				where POgrp='SCKS' and month(createdtpo)='".$bln."' and year(createdtpo)='".$thn."' 
				Group By `label`");
		$sqlbj	= ("SELECT CASE SUBSTR(pgr FROM 1 FOR 2) 
				WHEN 'JP' then 'JASA PRWT'
				WHEN 'PM' then 'JASA PRWT'
				WHEN 'JN' then 'JASA NON PRWT'
				WHEN 'ES' then 'JASA ENERGY & SUBSIDIARIES'
				END AS `label`, IFNULL(SUM(totalprice),0) as `value`
				FROM po
				WHERE POGrp='JSKS' AND MONTH(CreateDTPO)='".$bln."' AND YEAR(CreatedtPO)='".$thn."'
				GROUP BY `label`
				ORDER BY `label` DESC
				");	
		
		$prbb	= DB::select($sqlbb);
		$prbj	= DB::select($sqlbj);
		
		$return['br'] 	= $prb;
		$return['js'] 	= $prj;
		$return['bbr'] 	= $prbb;
		$return['bjs'] 	= $prbj;
        return $return ;
    }
}
