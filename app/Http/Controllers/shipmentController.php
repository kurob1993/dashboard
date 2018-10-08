<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\produk;
use App\shipment;
//use App\data;
class shipmentController extends Controller
{
	public function __construct ()
	{
		date_default_timezone_set('Asia/Jakarta');
	}
	public function index(Request $request)
	{
		$produk         = new produk;
        $produk_ret = $produk::all();

        $data_group = $request->get('data_group');
        $data_menu = $request->get('data_menu');
        $thn = $this->tahun();
        $now_thn = date("Y");
        $now_bln = date("m");

        $last_update = $this->shipment_last_update();
    	return view('operation.shipment',
    		['data_group'	=> $data_group,
    		'data_menu'		=> $data_menu,
    		'produk'		=> $produk_ret,
    		'thn'			=> $thn,
    		'now_thn'		=> $now_thn,
    		'now_bln'		=> $now_bln,
    		'last_update'	=> $last_update,
    	]);
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
	public function shipment_last_update()
	{
		$now = date('Y-m-d');
		$ret = DB::table('shipments')->orderBy('shipment_id','desc')->get();
		return $ret[0]->shipment_update;
	}
	public function shipprod(Request $request)
    {
		$thn		= $request->tahun;
    	$bln		= $request->bulan;

		$m          = $bln;//date("m");
		$y			= $thn;//date("Y");

		$prognosa	= $this->prognosa($m,$y);

		$ttlhr 		= cal_days_in_month(CAL_GREGORIAN, $m, $y);

		$cate		='';
		$arr 		= array();
		$no			= 0;

		for ($i=1;$i<=$ttlhr;$i++){
			$no = $no+1;
			$cate = array ( 'label'=>"$no", 'stepSkipped'=>false, 'appliedSmartLabel'=> true );
			array_push($arr,$cate );
		}

		$kate['category']	= $arr;
		$kat ['categories'] = array($kate);

		//get dataset

		$lap		= $request->produk;


		switch ($lap){
			case 'TTL' :
				$col = "(hr_dom + hrpo_dom + cr_dom + wr_dom + hr_exp + hrpo_exp + cr_exp + wr_exp)";
				break;
			case 'DMS' :
				$col = "(hr_dom + hrpo_dom + cr_dom + wr_dom)";
				break;
			case 'EKS' :
				$col = "(hr_exp + hrpo_exp + cr_exp + wr_exp)";
				break;
			case 'HR' :
				$col = "(hr_dom + hr_exp )";
				break;
			case 'PO' :
				$col = "(hrpo_dom + hrpo_exp)";
				break;
			case 'CR' :
				$col = "(cr_dom + cr_exp)";
				break;
			case 'WR' :
				$col = "(wr_dom + wr_exp)";
				break;
			case 'BLT' :
				$col = " 0 ";
				break;
		}
		$sql		= " SELECT ".$col." / 1000 as value  from shipments
						where month(shipment_date)=".(int)$m." and YEAR(shipment_date)=".$y." ORDER BY shipment_date asc";
		//dd($sql);
		$sqlt		= " SELECT ".$col." as value  from shipment_targets
						where month(target_date)=".(int)$m." and YEAR(target_date)=".$y." ORDER BY target_date asc";
		//dd($sqlt);
		$sqlc		= "	SELECT * FROM
						 (SELECT @running_count := @running_count + ".$col." / 1000  AS value
						FROM shipments, (SELECT @running_count := 0) AS T1
						WHERE month(shipment_date)=".(int)$m." and YEAR(shipment_date)=".$y."
						ORDER BY shipment_date) AS TableCount ";

		$sqlct		= "	SELECT * FROM
						 (SELECT @running_count := @running_count + ".$col."  AS value
						FROM shipment_targets, (SELECT @running_count := 0) AS T1
						WHERE month(target_date)=".(int)$m." and YEAR(target_date)=".$y."
						ORDER BY target_date) AS TableCount ";

		$shipment	= DB::select($sql);
		$target		= DB::select($sqlt);

		$accu		= DB::select($sqlc);
		$acclt		= DB::select($sqlct);

		$sip ['seriesname'] 	= 'Shipment';
		$sip ['showValues'] 	= '0';
		$sip ['placevaluesInside'] = "0";

		$sip ['data'] 			= $shipment;

		$trgt ['seriesname'] 	= 'Target';
		$trgt ['data'] 			= $target;
		//accumulated
		$accu ['seriesname'] 	= 'Shipment';
		$accu ['data'] 			= $accu;

		$acct ['seriesname'] 	= 'Target';
        $acct ['color']    		= 'CC3300';
        $acct ['renderas']    	= 'Line';
		$acct ['showValues'] 	= '0';
		$acct ['data'] 			= $acclt;

		$hsl 					= [ $sip, $trgt];
		$hslt 					= [ $accu, $acct];

		$return['categories'] 	= array($kate);
		$return['dataset'] 		= $hsl;

		$return['categoriesa'] 	= array($kate);
		$return['dataseta'] 	= $hslt;

		//$dttable []= '';
		$dttable = array();
		$attable = array();
		$jml = sizeof($shipment)-1;
		for ($i=0;$i<=$jml;$i++){
			$k = $i;
			$k++;
			isset($shipment[$i]) ? $sp = $shipment[$i]->value : $sp = 0;
			isset($target[$i])   ? $tg = $target[$i]->value : $tg = 0;
			//$dt = array($k,$shipment[$i]->value,$target[$i]->value);
			$dt = array($k,$sp,$tg);
			array_push($dttable, $dt);

			isset($accu[$i]) ? $ac = $accu[$i]->value : $ac = 0;
			isset($acclt[$i])   ? $ct = $acclt[$i]->value : $ct = 0;

			//$at = array($k,$accu[$i]->value,$acclt[$i]->value);
			$at = array($k,$ac,$ct);
			array_push($attable, $at);
		}

		//dd($dttable);
		$return['dtable'] = $dttable;
		$return['atable'] = $attable;
		$return['prognosa'] = $prognosa;
		$return['zz'] = $request->tahun;
        return $return ;
    }
    public function prognosa($m,$y)
    {
    	$tglkemarin = date('j')-1;
		$totalhari  = cal_days_in_month(CAL_GREGORIAN, $m, $y);

		$shipmentkemarin = DB::table('shipments')
								->where('shipment_date','>=',$y."-".$m."-01")
								->where('shipment_date','<=',$y."-".$m."-".$tglkemarin)
								->get();
		$total = 0;
		foreach ($shipmentkemarin as $key => $value) {
			$shipmentkemarin = ($value->hr_dom+
								$value->hrpo_dom+
								$value->cr_dom+
								$value->wr_dom+
								$value->hr_exp+
								$value->hrpo_exp+
								$value->cr_exp+
								$value->wr_exp);
			$total =$total+$shipmentkemarin; 

		}
		$ret = number_format( ($totalhari/$tglkemarin*$total)/1000,2);
		return $ret;
    }
    public function shipprodrange(Request $request)
    {
    	$errorStart['error'] = "Date start is null";
		$errorEnd['error'] = "Date end is null";
		$errorProd['error'] = "KS Product is null";

    	$startVal 	= isset($request->start)?$request->start:die( json_encode( $errorStart ) ) ;
    	$endVal 	= isset($request->end)?$request->end:die( json_encode( $errorEnd ) );
    	$ks_produk 	= isset($request->ks_produk)?$request->ks_produk:die( json_encode( $errorProd ) );

    	$start 		= date('Y-m-d',strtotime($startVal));
		$end 		= date('Y-m-d',strtotime($endVal));

		$cate		= '';
		$arr 		= array();
		$no			= 0;
		$awal 		= date('d',strtotime($startVal))*1;
		$x			= strtotime($start);

		$date1 	 = date_create($start);
		$date2	 = date_create($end);
		$diff	 = date_diff($date1,$date2);
		$ttlhr = $diff->format('%a');

		for ($i=0;$i<=$ttlhr;$i++){
			$data = date('d-M-y', strtotime('+'. $no .' day', $x ) );
			$no = $no+1;
			$cate = array ( 'label'=>"$data", 'stepSkipped'=>false, 'appliedSmartLabel'=> true );
			array_push($arr,$cate );
		}

		$kate['category']	= $arr;
		$kat ['categories'] = array($kate);

		//get dataset

		$lap		= $ks_produk;


		switch ($lap){
			case 'TTL' :
				$col = "(hr_dom + hrpo_dom + cr_dom + wr_dom + hr_exp + hrpo_exp + cr_exp + wr_exp)";
				break;
			case 'DMS' :
				$col = "(hr_dom + hrpo_dom + cr_dom + wr_dom)";
				break;
			case 'EKS' :
				$col = "(hr_exp + hrpo_exp + cr_exp + wr_exp)";
				break;
			case 'HR' :
				$col = "(hr_dom + hr_exp )";
				break;
			case 'PO' :
				$col = "(hrpo_dom + hrpo_exp)";
				break;
			case 'CR' :
				$col = "(cr_dom + cr_exp)";
				break;
			case 'WR' :
				$col = "(wr_dom + wr_exp)";
				break;
			case 'BLT' :
				$col = " 0 ";
				break;
		}
		$sql		= " SELECT ".$col." / 1000 as value  from shipments
						where shipment_date >= '".$start."' and shipment_date <= '".$end."' ORDER BY shipment_date asc";
		//dd($sql);
		$sqlt		= " SELECT ".$col." as value  from shipment_targets
						where target_date >= '".$start."' and target_date <= '".$end."' ORDER BY target_date asc";
		//dd($sqlt);
		$sqlc		= "	SELECT * FROM
						 (SELECT @running_count := @running_count + ".$col." / 1000  AS value
						FROM shipments, (SELECT @running_count := 0) AS T1
						WHERE shipment_date >= '".$start."' and shipment_date <= '".$end."'
						ORDER BY shipment_date) AS TableCount ";

		$sqlct		= "	SELECT * FROM
						 (SELECT @running_count := @running_count + ".$col."  AS value
						FROM shipment_targets, (SELECT @running_count := 0) AS T1
						WHERE target_date >= '".$start."' and target_date <= '".$end."'
						ORDER BY target_date) AS TableCount ";

		$shipment	= DB::select($sql);
		$target		= DB::select($sqlt);

		$accu		= DB::select($sqlc);
		$acclt		= DB::select($sqlct);

		$sip ['seriesname'] 	= 'Shipment';
		$sip ['showValues'] 	= '0';
		$sip ['placevaluesInside'] = "0";

		$sip ['data'] 			= $shipment;

		$trgt ['seriesname'] 	= 'Target';
		$trgt ['data'] 			= $target;
		//accumulated
		$accu ['seriesname'] 	= 'Shipment';
		$accu ['data'] 			= $accu;

		$acct ['seriesname'] 	= 'Target';
        $acct ['color']    		= 'CC3300';
        $acct ['renderas']    	= 'Line';
		$acct ['showValues'] 	= '0';
		$acct ['data'] 			= $acclt;

		$hsl 					= [ $sip, $trgt];
		$hslt 					= [ $accu, $acct];

		$return['categories'] 	= array($kate);
		$return['dataset'] 		= $hsl;

		$return['categoriesa'] 	= array($kate);
		$return['dataseta'] 	= $hslt;

		$dttable = array();
		$attable = array();
		$jml = sizeof($shipment)-1;
		for ($i=0;$i<=$jml;$i++){
			$k = $i;
			$k++;
			isset($shipment[$i]) ? $sp = $shipment[$i]->value : $sp = 0;
			isset($target[$i])   ? $tg = $target[$i]->value : $tg = 0;
			//$dt = array($k,$shipment[$i]->value,$target[$i]->value);
			// $dt = array($k,$sp,$tg);
			$dt = array($arr[$i]['label'],$sp,$tg);
			array_push($dttable, $dt);

			isset($accu[$i]) ? $ac = $accu[$i]->value : $ac = 0;
			isset($acclt[$i])   ? $ct = $acclt[$i]->value : $ct = 0;

			//$at = array($k,$accu[$i]->value,$acclt[$i]->value);
			$at = array($k,$ac,$ct);
			array_push($attable, $at);
		}

		//dd($dttable);
		$return['dtable'] = $dttable;
		$return['atable'] = $attable;
		// $return['prognosa'] = $prognosa;
        return $return ;
    }
}

?>
