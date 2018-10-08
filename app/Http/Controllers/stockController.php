<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class stockController extends Controller
{
    public function __construct ()
    {
        date_default_timezone_set('Asia/Jakarta');
    }
    public function index(Request $request)
    {           
        $data_group = $request->get('data_group');
        $data_menu  = $request->get('data_menu');
        $show       = $this->show();
        return view('logistik/stock',
                    [   'data_group'=>$data_group, 
                        'data_menu'=>$data_menu,
                        'data' => $show
                    ]);
    }
    public function show($tanggal=null)
    {   
        $now        = strtotime( date('Y-m-d') );
        $xtanggal   = strtotime($tanggal);
        $tanggal    = isset($tanggal) ? date("Y-m-d", $xtanggal ) : date('Y-m-d', $now );
        $tanggal	= $this->cekData($tanggal);

        $ret = DB::table('stock')
                ->select('dateload','deskripsi_kode','material',DB::RAW('FORMAT(sum(quantity),2) as quantity') )
                ->where(DB::RAW('DATE_FORMAT(dateload,"%Y-%m-%d")'),$tanggal)
                ->groupBy('deskripsi_kode')->get();
        return $ret;
        
    }
    public function cekData($tanggal,$hitung=0)
    {
    	$ret 	= DB::table('stock')
                    ->select( 
								'dateload',
								'deskripsi_kode',
								'material',
								DB::RAW('FORMAT(sum(quantity),2) as quantity') 
                    		)
                    ->where(DB::RAW('DATE_FORMAT(dateload,"%Y-%m-%d")'),$tanggal)
                    ->groupBy('deskripsi_kode');
        
        // jika ada data tampilkan tanggalnya         
        if( $ret->count() > 0 ){
	        return $tanggal;
        }else{
            // jika tidak ada data, tanggal yang di cari di kurangin
            // sampai menapatkan data pengulakan max 3x
	        $xtime     = strtotime($tanggal);
	        $tanggal   = date("Y-m-d",strtotime('-1 day', $xtime ) );
	        $hitung    = $hitung+1;

            // jika pengurangan sampai 3x tidak menampatkan data 
            // maka tanggal yang di cari di tambah sampai #x
            if($hitung > 3){
                $tanggal   = date("Y-m-d",strtotime('+1 day', $xtime ) );

                // jika penambahan sampai 9x tidak menampatkan data 
                // maka tampilkan tanggal terahir yang ada di tabel
                if($hitung > 12){
                    $tanggal = $this->lastRecord();
                }
            }
	        return $this->cekData($tanggal,$hitung);
        }
        
    }
    public function lastRecord()
    {
        $DB = DB::table('stock')->orderBy('dateload','desc')->limit(1)->get();
        return date('Y-m-d',strtotime($DB[0]->dateload));
    }
    public function detail($tanggal=null,$description = null)
    {
        /*
        $now        = strtotime( date('Y-m-d') );
        $xtanggal   = strtotime($tanggal);
        $tanggal    = isset($tanggal) ? date("Y-m-d",strtotime('-1 day',$xtanggal)) : date('Y-m-d',strtotime('-1 day',$now));
        $tanggal    = isset($tanggal) ? date("Y-m-d",$xtanggal) : date('Y-m-d',strtotime('-1 day',$now));
        */

        $xtanggal   = strtotime($tanggal);
        if($tanggal){
            $tanggal = date("Y-m-d",$xtanggal);
        }else{
            die("tanggal Kosong");
        }
        $ret = DB::table('stock')
                ->select('deskripsi_kode','material','plant','sloc',DB::RAW('FORMAT(quantity,2) as quantity'))
                ->where('deskripsi_kode',$description)
                ->where(DB::RAW('DATE_FORMAT(dateload,"%Y-%m-%d")'),$tanggal)
                ->groupBy('material','plant','sloc')
                ->get();
        return $ret;
    }
    
}
