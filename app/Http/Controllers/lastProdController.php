<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

use App\sys_menu;
use App\sys_group;

class lastProdController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }
    public function index(Request $request)
    {
        $data_group 	= $request->get('data_group');
        $data_menu 		= $request->get('data_menu');
        $HSM			= $this->show('HSM');
        $CRM			= $this->show('CRM');
        $SSP1			= $this->show('SSP1');
        $SSP2			= $this->show('SSP2');
        return view('operation.lastprod', [
                    'data_group'=> $data_group,
                    'data_menu'	=> $data_menu,
                    'HSM'		=> $HSM,
                    'CRM'		=> $CRM,
                    'SSP1' 		=> $SSP1,
                    'SSP2' 		=> $SSP2,
        ]);
    }
    public function show($plant='HSM')
    {
        if ($plant == null) {
            $ret = null;
        } else {
            $ret = DB::table('v_prod_last')
                    ->where('BEREICH', $plant)
                    ->orderBy('LAST_PROD', 'DESC')
                    ->get();
        }
        return $ret;
    }
    public function getData()
    {
        $client 	= new \GuzzleHttp\Client();
        $res 		= $client->request('GET', 'http://10.10.8.129/ws-mes/lastprod/index/format/json');
        $dataAPI 	= json_decode($res->getBody());

        foreach ($dataAPI as $key => $value) {
            $count 	= DB::table("prod_last")
                        ->where("BEREICH", $value->BEREICH)
                        ->where("ANLAGE", $value->ANLAGE)
                        ->where("LAST_PROD", $value->LAST_PROD)
                        ->count();

            if ($count == 0) {
                DB::table("prod_last")->insert([
                    "BEREICH" => $value->BEREICH,
                    "ANLAGE" => $value->ANLAGE,
                    "LAST_PROD" => $value->LAST_PROD,
                    "GEWINPUT" => $value->GEWINPUT,
                    "GEWOUTPUT" => $value->GEWOUTPUT,
                    "SCRAPWEIGHT" => $value->SCRAPWEIGHT
                ]);
                $GEWINPUT_TOTAL = DB::table("prod_last")
                                    ->where("BEREICH", $value->BEREICH)
                                    ->where("ANLAGE", $value->ANLAGE)
                                    ->where(DB::raw("DATE_FORMAT(LAST_PROD,'%Y-%m-%d')"), date("Y-m-d", strtotime($value->LAST_PROD)))
                                    ->sum("GEWINPUT");
                $GEWOUTPUT_TOTAL = DB::table("prod_last")
                                    ->where("BEREICH", $value->BEREICH)
                                    ->where("ANLAGE", $value->ANLAGE)
                                    ->where(DB::raw("DATE_FORMAT(LAST_PROD,'%Y-%m-%d')"), date("Y-m-d", strtotime($value->LAST_PROD)))
                                    ->sum("GEWOUTPUT");
                $SCRAPWEIGHT_TOTAL = DB::table("prod_last")
                                    ->where("BEREICH", $value->BEREICH)
                                    ->where("ANLAGE", $value->ANLAGE)
                                    ->where(DB::raw("DATE_FORMAT(LAST_PROD,'%Y-%m-%d')"), date("Y-m-d", strtotime($value->LAST_PROD)))
                                    ->sum("SCRAPWEIGHT");

                DB::table("prod_last")
                        ->where("BEREICH", $value->BEREICH)
                        ->where("ANLAGE", $value->ANLAGE)
                        ->where("LAST_PROD", $value->LAST_PROD)
                        ->update([
                            "GEWINPUT_TOTAL"=>$GEWINPUT_TOTAL,
                            "GEWOUTPUT_TOTAL"=>$GEWOUTPUT_TOTAL,
                            "SCRAPWEIGHT_TOTAL"=>$SCRAPWEIGHT_TOTAL
                        ]);

                $logg =  "GET DATA LAST PRODUCTION";
                // $tr = DB::table('log_down')->insert(['isinya'	=> $logg, 'stat'	=> '1']);
            }
        }
    }

    public function chart($BEREICH = 'HSM', $ANLAGE ='HSPM')
    {
        $sqlx 	= "	SELECT BEREICH,ANLAGE,LAST_PROD, NULL AS STATUS
    	 				FROM prod_last
    	 			WHERE BEREICH = '$BEREICH' AND ANLAGE = '$ANLAGE'
    	 			ORDER BY LAST_PROD DESC LIMIT 20";
        $sql 	= "SELECT * FROM ($sqlx) AS x ORDER BY x.LAST_PROD ASC";
        $ret 	= DB::SELECT($sql);

        $keys = array_keys($ret);
        $last = end($keys);
        foreach ($ret as $key => $value) {
            if ($key >= 1) {
                $datetime1 	= date_create($ret[$key]->LAST_PROD);
                $datetime2 	= date_create($ret[$key-1]->LAST_PROD);
                $interval 	= $datetime1->diff($datetime2);
                $int 		= $interval->format('%i%');
                if ($int > 10) {
                    $ret[$key-1]->STATUS = "0";
                } else {
                    $ret[$key-1]->STATUS = "1";
                }
            }
            if ($key == $last) {
                $datetime1 	= date_create($ret[$key]->LAST_PROD);
                $datetime2 	= date_create(date('Y-m-d H:i:s'));
                $interval 	= $datetime1->diff($datetime2);
                if ($interval->format('%i%') > 10) {
                    $ret[$key]->STATUS = "0";
                } else {
                    $ret[$key]->STATUS = "1";
                }
            }
        }
        $category = array();
        $data = array();
        foreach ($ret as $key => $value) {
            array_push($category, array("label" => date('d-m-Y H:i:s', strtotime($value->LAST_PROD)) ));
            array_push($data, array("value" => $value->STATUS));
        }
        $return = array("category" => $category,"data"=>$data);
        return $return;
    }
}
