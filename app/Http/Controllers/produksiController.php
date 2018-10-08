<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\produk;
use App\produksi;

//use App\data;
class produksiController extends Controller
{
    public function __construct()
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
        return view(
            'operation/produksi',
            ['data_group'	=> $data_group,
            'data_menu'		=> $data_menu,
            'produk'		=> $produk_ret,
            'thn'			=> $thn,
            'now_thn'		=> $now_thn,
            'now_bln'		=> $now_bln,
        ]
        );
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
    public function proddaily_old(Request $request)
    {
        $m          = date("m");
        $y			= date("Y");
        $ttlhr 		= cal_days_in_month(CAL_GREGORIAN, $m, $y);

        $cate		='';
        $arr 		= array();

        for ($i=1;$i<=$ttlhr;$i++) {
            $cate = array( 'label'=>"$i", 'stepSkipped'=>false, 'appliedSmartLabel'=> true );
            array_push($arr, $cate);
        }

        $kate['category']	= $arr;
        $kat ['categories'] = array($kate);

        //get dataset

        $lap		= $request->produk;


        switch ($lap) {
            case 'TTL':
                $col = "(drp + ssp + bsp + hsm + crc + po + wrm) ";
                break;
            case 'drp':
                $col = "( drp )";
                break;
            case 'ssp':
                $col = "( ssp )";
                break;
            case 'bsp':
                $col = "( bsp )";
                break;
            case 'hsm':
                $col = "( hsm )";
                break;
            case 'crc':
                $col = "( crc )";
                break;
            case 'po':
                $col = "( po )";
                break;
            case 'wrm':
                $col = " ( wrm ) ";
                break;
        }
        $sql		= "select ".$col." as value from prods
						where month(prod_date)=".(int)$m." and YEAR(prod_date)=".$y;

        $sqlt		= "select ".$col." as value from prod_targets
						where month(target_date)=".(int)$m." and YEAR(target_date)=".$y;


        $sqlc		= "	SELECT * FROM
						 (SELECT @running_count := @running_count + ".$col."  AS value
						FROM prods, (SELECT @running_count := 0) AS T1
						WHERE month(prod_date)=".(int)$m." and YEAR(prod_date)=".$y."
						ORDER BY prod_date) AS TableCount ";
        //echo $sqlc;
        $sqlct		= "	SELECT * FROM
						 (SELECT @running_count := @running_count + ".$col."  AS value
						FROM prod_targets, (SELECT @running_count := 0) AS T1
						WHERE month(target_date)=".(int)$m." and YEAR(target_date)=".$y."
						ORDER BY target_date) AS TableCount ";

        $produksi	= DB::select($sql);

        $target		= DB::select($sqlt);

        $accu		= DB::select($sqlc);
        $acclt		= DB::select($sqlct);

        $sip ['seriesname'] 	= 'Produksi';
        $sip ['data'] 			= $produksi;

        $trgt ['seriesname'] 	= 'Target';
        $trgt ['data'] 			= $target;
        //accumulated
        $accu ['seriesname'] 	= 'Produksi';
        $accu ['data'] 			= $accu;

        $acct ['seriesname'] 	= 'Target';
        $acct ['data'] 			= $acclt;

        $hsl 					= [ $sip, $trgt];
        $hslt 					= [ $accu, $acct];

        $return['categories'] 	= array($kate);
        $return['dataset'] 		= $hsl;

        $return['categoriesa'] 	= array($kate);
        $return['dataseta'] 	= $hslt;
        //json_encode($return);

        $dttable = array();
        $attable = array();
        $jml = sizeof($produksi)-1;
        for ($i=0;$i<=$jml;$i++) {
            $k = $i;
            $k++;

            isset($produksi[$i]) ? $pd = $produksi[$i]->value : $pd = 0;
            isset($target[$i])   ? $tg = $target[$i]->value : $tg = 0;
            $dt = array($k,$pd,$tg);
            //$dt = array($k,$produksi[$i]->value,$target[$i]->value);
            array_push($dttable, $dt);

            isset($accu[$i]) ? $ac = $accu[$i]->value : $ac = 0;
            isset($acclt[$i])   ? $ct = $acclt[$i]->value : $ct = 0;
            $at = array($k,$ac,$ct);
            //$at = array($k,$accu[$i]->value,$acclt[$i]->value);
            array_push($attable, $at);
        }

        $return['dtable'] = $dttable;
        $return['atable'] = $attable;

        return $return ;
    }

    public function proddaily(Request $request)
    {
        $thn		= $request->tahun;
        $bln		= $request->bulan;

        $m          = $bln;//date("m");
        $y			= $thn;//date("Y");
        $ttlhr 		= cal_days_in_month(CAL_GREGORIAN, $m, $y);

        $cate		='';
        $arr 		= array();

        for ($i=1;$i<=$ttlhr;$i++) {
            $cate = array( 'label'=>"$i", 'stepSkipped'=>false, 'appliedSmartLabel'=> true );
            array_push($arr, $cate);
        }

        $kate['category']	= $arr;
        $kat ['categories'] = array($kate);

        //get dataset

        $lap		= $request->produk;

        switch ($lap) {
            case '1':
                $col = "( hsm )";
                break;
            case '2':
                $col = "( crc )";
                break;
            case '3':
                $col = "( po )";
                break;
            case '4':
                $col = " ( wrm ) ";
                break;
        }
        $sqlx		= "SELECT current_value as value
						FROM datas WHERE produk_id ='$lap'
						AND `group` = '3' AND
						month(tanggal) = '$m'
						AND YEAR( tanggal ) = '$y'
					";

        $sqlxt		= "SELECT ".$col." as value from prod_targets
						where month(target_date)=".(int)$m." and YEAR(target_date)=".$y;

        $sqlxc		="	SELECT
							@running_count := @running_count + ( current_value ) AS VALUE
						FROM
							datas, ( SELECT @running_count := 0 ) AS T1
						WHERE
							MONTH ( tanggal ) = '$m'
							AND YEAR ( tanggal ) = '$y'
							and `group` = '3'
							and produk_id = '$lap'
						ORDER BY
						tanggal
					";

        $sqlct		= "	SELECT * FROM
						 (SELECT @running_count := @running_count + ".$col."  AS value
						FROM prod_targets, (SELECT @running_count := 0) AS T1
						WHERE month(target_date)=".(int)$m." and YEAR(target_date)=".$y."
						ORDER BY target_date) AS TableCount ";

        // $produksi	= DB::select($sql);
        $produksi	= DB::select($sqlx);

        // $target		= DB::select($sqlt);
        $target		= DB::select($sqlxt);

        // $accu		= DB::select($sqlc);
        $accu		= DB::select($sqlxc);

        $acclt		= DB::select($sqlct);
        // $acclt		= DB::select($sqlxc);

        $sip ['seriesname'] 	= 'Produksi';
        $sip ['data'] 			= $produksi;

        $trgt ['seriesname'] 	= 'Target';
        $trgt ['data'] 			= $target;
        //accumulated
        $accu ['seriesname'] 	= 'Produksi';
        $accu ['data'] 			= $accu;

        $acct ['seriesname'] 	= 'Target';
        $acct ['data'] 			= $acclt;

        $hsl 					= [ $sip, $trgt];
        $hslt 					= [ $accu, $acct];

        $return['categories'] 	= array($kate);
        $return['dataset'] 		= $hsl;

        $return['categoriesa'] 	= array($kate);
        $return['dataseta'] 	= $hslt;
        //json_encode($return);

        $dttable = array();
        $attable = array();
        $jml = sizeof($produksi)-1;
        for ($i=0;$i<=$jml;$i++) {
            $k = $i;
            $k++;

            isset($produksi[$i]) ? $pd = $produksi[$i]->value : $pd = 0;
            isset($target[$i])   ? $tg = $target[$i]->value : $tg = 0;
            $dt = array($k,$pd,$tg);
            //$dt = array($k,$produksi[$i]->value,$target[$i]->value);
            array_push($dttable, $dt);

            isset($accu[$i]) ? $ac = $accu[$i]->VALUE : $ac = 0;
            isset($acclt[$i])   ? $ct = $acclt[$i]->value : $ct = 0;
            $at = array($k,$ac,$ct);
            //$at = array($k,$accu[$i]->VALUE,$acclt[$i]->VALUE);
            array_push($attable, $at);
        }

        $return['dtable'] = $dttable;
        $return['atable'] = $attable;
        return $return;
    }
}
