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
        $select_tahun   = isset($request->tahun) ? $request->tahun : $this->SelectTahun();
        $mhlTahun       = $this->mhlTahun();
        $data_group     = $request->get('data_group');
        $data_menu      = $request->get('data_menu');
        $data           = DB::table('mhl')->where('tahun',$select_tahun)->get();

        $ret 	= [ 'data_group' => $data_group, 
					'data_menu' => $data_menu,
                    'tahun'=> $mhlTahun,
                    'select_tahun'=> $select_tahun,
                    'data'=> $data
        		];
        return view('sdm.mhl',$ret);
    }
    public function mhlTahun()
    {
    	$data = DB::table('mhl')->select('tahun')->groupBy('tahun')->get();
    	return $data;
    }
    public function SelectTahun()
    {
        $x = DB::table('mhl')
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
