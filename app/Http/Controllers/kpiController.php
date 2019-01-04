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

        $ret 	= [ 
                    'data_group' => $data_group, 
					'data_menu' => $data_menu,
                    'tahun'=> $kpiTahun,
                    'bulan'=> $kpiBulan,
                    'select_tahun'=> $SelectTahun,
                    'select_bulan'=> $SelectBulan,
                    'data_pkp'=> $pkp
        		];
        return view('sdm.kpi',$ret)->with('ini',$this);
    }
    public function formatNumber($str)
    {   
        if (is_numeric($str)) {
            $str = number_format($str,2);
        } 
        return $str;
    }
    public function pkp($bulan,$tahun)
    {
        $data   = DB::table('kpi')
                    ->where('bulan',$bulan)
                    ->where('tahun',$tahun)
                    ->get();
        $ret = [];
        foreach ($data as $key => $value) {
            $ret[$value->grup][] = $value;
        }
        return $ret;
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
