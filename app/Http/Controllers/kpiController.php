<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class kpiController extends Controller
{
    public function __construct ()
    {
        date_default_timezone_set('Asia/Jakarta');
    }
    public function index(Request $request)
    {
        $SelectTahun      = isset($request->tahun) ? $request->tahun : $this->SelectTahun();
        $SelectBulan      = isset($request->bulan) ? $request->bulan : $this->SelectBulan();
        
        $kpiTahun   = $this->kpiTahun();
        $kpiBulan   = $this->kpiBulan();
        $data_group = $request->get('data_group');
        $data_menu  = $request->get('data_menu');

        $pkp        = $this->pkp($SelectBulan,$SelectTahun);
        $SdmPu      = $this->SdmPu($SelectBulan,$SelectTahun);
        $hcm      = $this->hcm($SelectBulan,$SelectTahun);
        $pmcc      = $this->pmcc($SelectBulan,$SelectTahun);
        $odhcp      = $this->odhcp($SelectBulan,$SelectTahun);
        $hcdlc      = $this->hcdlc($SelectBulan,$SelectTahun);

        $ret 	= [ 
                    'data_group' => $data_group, 
					'data_menu' => $data_menu,
                    'tahun'=> $kpiTahun,
                    'bulan'=> $kpiBulan,
                    'select_tahun'=> $SelectTahun,
                    'select_bulan'=> $SelectBulan,
                    'data_pkp'=> $pkp,
                    'data_sdmpu'=> $SdmPu,
                    'data_hcm'=> $hcm,
                    'data_pmcc'=> $pmcc,
                    'data_odhcp'=> $odhcp,
                    'data_hcdlc'=> $hcdlc
        		];
        return view('sdm.kpi',$ret)->with('ini',$this);
    }
    public function formatNumber($str)
    {   
        $ret = '';
        //remove all with space adn comma [,]
        $num = preg_replace('/[,]|\s+/', '', $str);
        if (is_numeric( $num )) {
            $ret =  number_format($num,2);
        }else{
            $ret = "<pre>".$str."</pre>";
        }
        return $ret;
    }
    public function pkp($bulan,$tahun)
    {
        $data   = DB::table('kpi')
                    ->where('part','pkp')
                    ->where('bulan',$bulan)
                    ->where('tahun',$tahun)
                    ->get();
        return $data->groupBy('grup');
    }
    public function SdmPu($bulan,$tahun)
    {
        $data   = DB::table('kpi')
                    ->where('part','sdm&pu')
                    ->where('bulan',$bulan)
                    ->where('tahun',$tahun)
                    ->get();
        return $data->groupBy('grup');
    }
    public function hcm($bulan,$tahun)
    {
        $data   = DB::table('kpi')
                    ->where('part','shcm')
                    ->where('bulan',$bulan)
                    ->where('tahun',$tahun)
                    ->get();
        return $data->groupBy('grup');
    }
    public function pmcc($bulan,$tahun)
    {
        $data   = DB::table('kpi')
                    ->where('part','dpm&c')
                    ->where('bulan',$bulan)
                    ->where('tahun',$tahun)
                    ->get();
        return $data->groupBy('grup');
    }
    public function odhcp($bulan,$tahun)
    {
        $data   = DB::table('kpi')
                    ->where('part','odhcp')
                    ->where('bulan',$bulan)
                    ->where('tahun',$tahun)
                    ->get();
        return $data->groupBy('grup');
    }
    public function hcdlc($bulan,$tahun)
    {
        $data   = DB::table('kpi')
                    ->where('part','hcdlc')
                    ->where('bulan',$bulan)
                    ->where('tahun',$tahun)
                    ->get();
        return $data->groupBy('grup');
    }
    public function kpiTahun()
    {
    	$data = DB::table('kpi')->select('tahun')->groupBy('tahun')->get();
    	return $data;
    }
    public function kpiBulan()
    {
    	$data = [
            ['bulan'=>'01','nama'=>'Januari'],
            ['bulan'=>'02','nama'=>'Februari'],
            ['bulan'=>'03','nama'=>'Maret'],
            ['bulan'=>'04','nama'=>'April'],
            ['bulan'=>'05','nama'=>'Mei'],
            ['bulan'=>'06','nama'=>'Juni'],
            ['bulan'=>'07','nama'=>'Juli'],
            ['bulan'=>'08','nama'=>'Agustus'],
            ['bulan'=>'09','nama'=>'September'],
            ['bulan'=>'10','nama'=>'Oktober'],
            ['bulan'=>'11','nama'=>'November'],
            ['bulan'=>'12','nama'=>'Desember']
        ];
    	return $data;
    }
    public function SelectTahun()
    {
        $x = DB::table('kpi')
                ->select('tahun')
                ->groupBy('tahun')
                ->orderBy('tahun','desc')
                ->get();
        $z = '';
        if( count($x) ){
            $z = $x[0]->tahun;
        }else{
            $z = date('Y');
        }
        return $z;
    }
    public function SelectBulan()
    {
        $x = DB::table('kpi')
                ->select('bulan')
                ->where('tahun',$this->SelectTahun())
                ->groupBy('bulan')
                ->orderBy('bulan','desc')
                ->get();
        $z = '';
        if( count($x) ){
            $z = $x[0]->bulan;
        }else{
            $z = date('m');
        }
        return $z;
    }
}
