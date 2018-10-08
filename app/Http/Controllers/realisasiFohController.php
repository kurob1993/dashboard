<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class realisasiFohController extends Controller
{
	public function __construct ()
	{
	   date_default_timezone_set('Asia/Jakarta');
	}
	public function index(Request $request,$tahun=null)
	{
        $tahun      = isset($tahun) ? $tahun : date('Y');
        $tahun_lama = isset($tahun) ? $tahun-1 : date('Y')-1;
		$data_group = $request->get('data_group');
        $data_menu  = $request->get('data_menu');
        $data_foh   = $this->foh($tahun);
        $data_pk    = $this->pk($tahun);
        $data_tahun = $this->tahun();
        $data_lastUpdate = $this->lastUpdate($tahun);
        return view('finance.realisasiFoh',
            [   'data_group'=>$data_group,
                'data_menu'=>$data_menu,
                'foh'=>$data_foh,
                'pk'=>$data_pk,
                'pilih_tahun'=>$data_tahun,
                'tahun'=>$tahun,
                'tahun_lama'=>$tahun_lama,
                'lastUpdate'=>$data_lastUpdate,
            ]
        );
	}
    public function lastUpdate($tahun)
    {
        $data = DB::table('realisasi_foh')->where('tahun',$tahun)->limit(1)->get();
        $data = isset($data[0]->datefile) ? date('d-m-Y',strtotime($data[0]->datefile) ) : "-";
        return $data;
    }
    public function show(Request $request)
    {
        return redirect('/daily_report/realisasi_foh/'.$request->tahun); 
    }
    public function tahun()
    {
        $data = DB::table('realisasi_foh')->groupBy('tahun')->get();
        return $data;
    }
	public function pk($tahun)
    {
        $ret = DB::table('realisasi_foh')
        ->selectRaw('
        	sum(realisasi_lama) as realisasi_lama, 
        	sum(rata_rata_lama) as rata_rata_lama, 
        	sum(realisasi_januari) as realisasi_januari, 
        	sum(realisasi_februari) as realisasi_februari, 
        	sum(realisasi_maret) as realisasi_maret, 

        	sum(realisasi_april) as realisasi_april, 
        	sum(realisasi_mei) as realisasi_mei, 
        	sum(realisasi_juni) as realisasi_juni, 
        	sum(real_smt_1) as real_smt_1, 
        	sum(realisasi_juli) as realisasi_juli,

        	sum(realisasi_agustus) as realisasi_agustus, 
        	sum(realisasi_september) as realisasi_september, 
        	sum(realisasi_oktober) as realisasi_oktober, 
        	sum(realisasi_november) as realisasi_november, 
        	sum(realisasi_desember) as realisasi_desember, 
 
        	sum(real_q123) as real_q123, 
        	sum(real_jan_des) as real_jan_des, 
        	sum(anggaran_smt_1) as anggaran_smt_1, 
        	sum(anggaran_per_bulan) as anggaran_per_bulan, 
        	sum(rkap) as rkap, 
        	sum(anggaran_jan_des) as anggaran_jan_des, 
        	sum(sisa_anggaran) as sisa_anggaran, 
        	
        	pk, deskripsi
        ')->where('tahun', $tahun )->groupBy('PK')->get();
        return $ret;
    }
    public function foh($tahun)
    {
        $ret = DB::table('realisasi_foh')->where('tahun', $tahun )->get();
        return $ret;
    }
}
