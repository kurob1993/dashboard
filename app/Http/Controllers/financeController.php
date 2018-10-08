<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\produk;
use App\finance;
//use App\data;
class financeController extends Controller
{
	public function __construct ()
	{
		
	}
	public function index(Request $request)
	{
		$tahun = $this->tahun();

        $data_group = $request->get('data_group');
        $data_menu = $request->get('data_menu');
    	return view('operation/finance',['data_group'=>$data_group, 'data_menu'=>$data_menu,'tahun'=>$tahun]);
	}
	public function tahun()
	{
		$tahun = array();

		$x = date("Y") - 2014;
		for ($i=0; $i < $x+1; $i++) { 
			$thn = date("Y");
			$thn = $thn-$i;
			array_push($tahun, $thn);
		}

		return $tahun;
	}
	public function findaily(Request $request)
    {
		$m          = date("m");
		$y			= $request->get('thn')!== null ?$request->get('thn'):date("Y");
		$ttlhr 		= 12;//cal_days_in_month(CAL_GREGORIAN, $m, $y);
		// die($y);
		$cate		=''; 
		$arr 		= array();

		$bulan = array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des');
    

		for ($i=1;$i<=$ttlhr;$i++){
			$cate = array ( 'label'=>$bulan[$i], 'stepSkipped'=>false, 'appliedSmartLabel'=> true );
			array_push($arr,$cate );
		}
		
		$kate['category']	= $arr;
		$kat ['categories'] = array($kate);
		
		//get dataset
		
		
		$p		= "select persediaan as value from likuiditas  where  YEAR(likuiditas_date)=".$y;
		$s		= "select saldokas as value from likuiditas  where  YEAR(likuiditas_date)=".$y;
		$u		= "select piutang as value from likuiditas  where  YEAR(likuiditas_date)=".$y;
		$h		= "select hutang as value from likuiditas  where  YEAR(likuiditas_date)=".$y;
		
		//echo $p;
		
		$ps		= DB::select($p);
		$sk		= DB::select($s);
		$pi		= DB::select($u);
		$hu		= DB::select($h);
		
		
		$per ['seriesname'] 	= 'Persediaan';
		$per ['data'] 			= $ps;
		
		$sal ['seriesname'] 	= 'Saldo Kas';
		$sal ['data'] 			= $sk;
		
		$piu ['seriesname'] 	= 'Piutang';
		$piu ['data'] 			= $pi;
		
		$hut ['seriesname'] 	= 'Hutang';
		$hut ['data'] 			= $hu;
		
		$hsl 					= [ $per, $sal, $piu, $hut];
		
		
        $return['categories'] 	= array($kate);
		$return['dataset'] 		= $hsl;
		$return['thn'] 		= $y;
		
		//json_encode($return);
        return $return ;
    }
    public function lastUpdate()
    {
    	$ret = "";
    	$data = DB::table('likuiditas')->orderby('update','DESC')->limit(1)->get();
    	foreach ($data as $key => $value) {
    		$ret = $value->update;
    	}
    	return $ret;
    	
    }
}
