<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Sinergi\BrowserDetector\Browser;
use Sinergi\BrowserDetector\Language;

class debugController extends Controller
{
	public function __construct ()
    {
       date_default_timezone_set('Asia/Jakarta');
    }
    public function index(Request $request)
    {
        for ($i=0; $i < 100; $i++) { 
            echo $this->numbering()."<br>";
        }
        
    }

    public function numbering()
    {
        $no     = date('dmY');
        $count  = DB::table('number')->whereRaw("date_format(tanggal,'%Y-%m')",date('Y-m'))->count();

        if( $count == 0 ){
            $sec = $no.'00001';
            DB::table('number')->insert(['number'=>$sec,'tanggal' => date('Y-m-d')]);
        }else{
            $char   = 5;
            $countx = strlen($count+1);
            $len    = $char-$countx;
            $sec    = '';
            for ($i=0; $i < $len; $i++) { 
                $sec = $sec.'0';
            }
            $sec = $no.$sec.($count+1);
            DB::table('number')->insert(['number'=>$sec,'tanggal' => date('Y-m-d')]);
        }

        return $count;
    }
    public function getDireksi($org)
    {
        $ret = DB::table('structdireksi')
            ->where('emportx', $org)
            ->limit(1);
        $ret = $ret->count() > 0 ? $ret->get()[0]->empname:NULL;
        return $ret;
    }
    public function getEmpForOrg($org)
    {
        $ret = DB::table('structdisp')
                    ->where('emporid', $org)
                    ->whereRaw("RIGHT(emp_hrp1000_s_short,8) = '00000000'")
                    ->orderBy('emppersk','asc')
                    ->limit(1)->toSql();
        return $ret;
    }

    public function fohPK1()
    {
        // $ret = DB::table('realisasi_foh')->where('tahun', date('Y') )->where('pk','PK01')->get();
        // return $ret;

        $ret = DB::table('realisasi_foh')
        ->selectRaw('sum(realisasi_lama) as realisasi_lama, pk')
        ->where('tahun', date('Y') )->groupBy('PK')->get();
        return $ret;
    }
    public function convert($value=NULL)
    {
      isset($value) ? $ret = trim($value) : $ret = NULL;
      if (substr($ret, -1)=='-') { $ret = trim(substr($ret, -1)).trim(substr($ret, 0, strlen($ret)-1)); }
      return $ret;
    }
    public function targerRkap($month,$year,$tag_name,$lastDay)
    {
        $RKAP    = DB::table('target_rkap')->where('BULAN',$month)->where('TAHUN',$year)->get();
        if($RKAP){
            return $RKAP[0]->$tag_name/$lastDay;
        }
    }
    public function lastUpdate($tanggal) {
        $count = DB::table('kontribusi_margin')
        ->where('tanggal',$tanggal)
        ->orderBy('datefile','DESC')
        ->limit(1)->count();

        $ret = "";
        if($count == 0){
            $ret = DB::table('kontribusi_margin')
            ->orderBy('tanggal','DESC')
            ->limit(1)->get();
        }else{
            $ret = DB::table('kontribusi_margin')
            ->where('tanggal',$tanggal)
            ->orderBy('datefile','DESC')
            ->limit(1)->get();
        }
        return $ret[0]->datefile;
    }
    public function nilaiInvoice($tag_name,$tangal)
    {
    	$ret = DB::table('kontribusi_margin');

    	switch ($tag_name) {
    		case 'DOM_HRT':
    			return $ret->where( DB::RAW('left(matrial,1)'),'H' )
	                    	->where( DB::RAW('right(matrial,1)'),'T' )
	                    	->where( 'tanggal',$tangal )->where('dist','D0')->sum('sales_value_usd');
    			break;

    		case 'DOM_HRC':
    			return $ret->where( DB::RAW('left(matrial,1)'),'H' )
	                    	->where( DB::RAW('right(matrial,1)'),'T' )
	                    	->where( 'tanggal',$tangal )->where('dist','D0')->sum('sales_value_usd');
    			break;
    		
    		default:
    			# code...
    			break;
    	}

    }
}
