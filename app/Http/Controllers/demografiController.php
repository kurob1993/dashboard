<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class demografiController extends Controller
{
    public function __construct ()
    {
        date_default_timezone_set('Asia/Jakarta');
    }
    public function index(Request $request)
    {
        $select_tahun           = isset($request->tahun) ? $request->tahun : $this->SelectTahun();
        $tahun_lama             = isset($request->tahun) ? $request->tahun-1 : date('Y')-1;
    	$data_group             = $request->get('data_group');
        $data_menu              = $request->get('data_menu');
        $session_nik            = $request->session()->get('nik');
        $data_demoStatus        = $this->demoStatus($select_tahun);
        $data_demoGolongan      = $this->demoGolongan($select_tahun);
        $data_demoPendidikan    = $this->demoPendidikan($select_tahun);
        $demoUsia               = $this->demoUsia($select_tahun);
        $demoTahun              = $this->demoTahun();
        
        $data 	= [ 'data_group' => $data_group, 
					'data_menu' => $data_menu, 
					'demo_status'=>$data_demoStatus, 
					'demo_golongan'=>$data_demoGolongan,
					'demo_pendidikan'=>$data_demoPendidikan,
					'demo_usia'=>$demoUsia,
                    'session_nik'=>$session_nik,
                    'tahun'=>$demoTahun,
                    'tahun_lama'=>$tahun_lama,
                    'select_tahun'=>$select_tahun
        		];
        return view('sdm.demografi',$data);
    }
    public function demoStatus($tahun)
    {
    	$data = DB::table('demografi')->where('part','status')->where('tahun',$tahun)->get();
    	return $data;
    }
    public function demoGolongan($tahun)
    {
    	$data = DB::table('demografi')->where('part','golongan')->where('tahun',$tahun)->get();
    	return $data;
    }
    public function demoPendidikan($tahun)
    {
        $data = DB::table('demografi')->where('part','pendidikan')->where('tahun',$tahun)->get();
        return $data;
    }
    public function demoUsia($tahun)
    {
        $data = DB::table('demografi_usia')->where('tahun',$tahun)->get();
        return $data;
    }
    public function demoTahun()
    {
    	$data = DB::table('demografi')->select('tahun')->groupBy('tahun')->get();
    	return $data;
    }
    public function SelectTahun()
    {
        $x = DB::table('demografi')
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
}
