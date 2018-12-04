<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Facades\Datatables;

class mhlController extends Controller
{
    public function __construct ()
    {
       date_default_timezone_set('Asia/Jakarta');
    }
    public function index(Request $request)
    {
        $tahun = isset($request->tahun) ? $request->tahun : date('Y');
        $mhlTahun              = $this->mhlTahun();
        $data_group = $request->get('data_group');
        $data_menu  = $request->get('data_menu');
        $data = DB::table('mhl')->where('tahun','2018')->get();

        $data 	= [ 'data_group' => $data_group, 
					'data_menu' => $data_menu,
                    'tahun'=>$mhlTahun,
                    'select_tahun'=>$tahun,
                    'data'=>$data
        		];
        return view('sdm.mhl',$data);
    }
    public function mhlTahun()
    {
    	$data = DB::table('mhl')->select('tahun')->groupBy('tahun')->get();
    	return $data;
    }
}
