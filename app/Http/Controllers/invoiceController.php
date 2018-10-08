<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\sys_user;
use App\sys_group;

class invoiceController extends Controller
{
    public function __construct ()
    {
       date_default_timezone_set('Asia/Jakarta');
    }
    public function index(Request $request)
    {
        $data_group = $request->get('data_group');
        $data_menu  = $request->get('data_menu');
        
        return view('finance.invoice',
            [
                'data_group' =>$data_group,
                'data_menu'  => $data_menu,
            ]
        );
    }
    public function show(Request $request)
    {   
        $tangal  = date('Y-m-d', strtotime($request->date));
        $first   = date('Y-m-01',strtotime($request->date));
        $month   = date('m',strtotime($request->date));
        $year    = date('Y',strtotime($request->date));
        $lastDay = date('t',strtotime($request->date));

        //domestik
        $RKAP_DOM_HRC   = $this->targerRkap($month,$year,'DOM_HRC',$lastDay);
        $RKAP_DOM_HRT   = $this->targerRkap($month,$year,'DOM_HRT',$lastDay);
        $RKAP_DOM_HRPO  = $this->targerRkap($month,$year,'DOM_HRPO',$lastDay);
        $RKAP_DOM_CRC   = $this->targerRkap($month,$year,'DOM_CRC',$lastDay);
        $RKAP_DOM_BLT   = $this->targerRkap($month,$year,'DOM_BLT',$lastDay);
        $RKAP_DOM_WR    = $this->targerRkap($month,$year,'DOM_WR',$lastDay);
        
        $DOM_HRT_NILAI  = $this->nilaiInvoice("DOM_HRT",$first,$tangal);
        $DOM_HRC_NILAI  = $this->nilaiInvoice("DOM_HRC",$first,$tangal);
        $DOM_HRPO_NILAI = $this->nilaiInvoice("DOM_HRPO",$first,$tangal);
        $DOM_CRC_NILAI  = $this->nilaiInvoice("DOM_CRC",$first,$tangal);                    
        $DOM_WR_NILAI   = $this->nilaiInvoice("DOM_WR",$first,$tangal);

        $DOM_HRT_TON  = $this->tonInvoice("DOM_HRT",$first,$tangal);
        $DOM_HRC_TON  = $this->tonInvoice("DOM_HRC",$first,$tangal);
        $DOM_HRPO_TON = $this->tonInvoice("DOM_HRPO",$first,$tangal);
        $DOM_CRC_TON  = $this->tonInvoice("DOM_CRC",$first,$tangal);                    
        $DOM_WR_TON   = $this->tonInvoice("DOM_WR",$first,$tangal);  

        $DOM_HRT_AVG    = $DOM_HRT_TON  ? $DOM_HRT_NILAI / $DOM_HRT_TON:0;
        $DOM_HRC_AVG    = $DOM_HRC_TON  ? $DOM_HRC_NILAI / $DOM_HRC_TON:0;
        $DOM_HRPO_AVG   = $DOM_HRPO_TON ? $DOM_HRPO_NILAI / $DOM_HRPO_TON:0;
        $DOM_CRC_AVG    = $DOM_CRC_TON  ? $DOM_CRC_NILAI / $DOM_CRC_TON:0;
        $DOM_WR_AVG     = $DOM_WR_TON   ? $DOM_WR_NILAI / $DOM_WR_TON:0;

        //ekspor
        $RKAP_EKS_HRC   = $this->targerRkap($month,$year,'EKS_HRC',$lastDay);
        $RKAP_EKS_HRPO  = $this->targerRkap($month,$year,'EKS_HRPO',$lastDay);
        $RKAP_EKS_CRC   = $this->targerRkap($month,$year,'EKS_CRC',$lastDay);
        $RKAP_EKS_WR    = $this->targerRkap($month,$year,'EKS_WR',$lastDay);

        $EKS_HRC_NILAI  = $this->nilaiInvoice("EKS_HRC",$first,$tangal);
        $EKS_HRPO_NILAI = $this->nilaiInvoice("EKS_HRPO",$first,$tangal);
        $EKS_CRC_NILAI  = $this->nilaiInvoice("EKS_CRC",$first,$tangal);                    
        $EKS_WR_NILAI   = $this->nilaiInvoice("EKS_WR",$first,$tangal);

        $EKS_HRC_TON  = $this->tonInvoice("EKS_HRC",$first,$tangal);
        $EKS_HRPO_TON = $this->tonInvoice("EKS_HRPO",$first,$tangal);
        $EKS_CRC_TON  = $this->tonInvoice("EKS_CRC",$first,$tangal);
        $EKS_WR_TON   = $this->tonInvoice("EKS_WR",$first,$tangal);

        $EKS_HRC_AVG    = $EKS_HRC_TON  ? $EKS_HRC_NILAI / $EKS_HRC_TON:0;
        $EKS_HRPO_AVG   = $EKS_HRPO_TON ? $EKS_HRPO_NILAI / $EKS_HRPO_TON:0;
        $EKS_CRC_AVG    = $EKS_CRC_TON  ? $EKS_CRC_NILAI / $EKS_CRC_TON:0;
        $EKS_WR_AVG     = $EKS_WR_TON   ? $EKS_WR_NILAI / $EKS_WR_TON:0;

        $ret = array(
            "LAST_UPDATE" => $this->lastUpdate( date('Y-m-d', strtotime($request->date) ) ),
            "POSISI_INVOICE" => date('01-m-Y', strtotime($request->date))." s.d ".date('d-m-Y', strtotime($request->date)),

            "DOM_HRT"    => array('TON'=> number_format( $DOM_HRT_TON,2),
                                    'NILAI' => number_format( $DOM_HRT_NILAI,2), 
                                    'AVG' =>  number_format( $DOM_HRT_AVG,2),
                                    'RKAP' => number_format($RKAP_DOM_HRT,2),
                                ),

            "DOM_HRC"    => array('TON'=> number_format( $DOM_HRC_TON,2),
                                    'NILAI' => number_format($DOM_HRC_NILAI,2), 
                                    'AVG' => number_format($DOM_HRC_AVG,2),
                                    'RKAP' => number_format($RKAP_DOM_HRC,2),
                                ),

            "DOM_HRPO"   => array('TON'=> number_format($DOM_HRPO_TON,2),
                                    'NILAI' => number_format($DOM_HRPO_NILAI,2), 
                                    'AVG' => number_format($DOM_HRPO_AVG,2),
                                    'RKAP' => number_format($RKAP_DOM_HRPO,2),
                                ),

            "DOM_CRC"    => array('TON'=> number_format($DOM_CRC_TON,2),
                                    'NILAI' => number_format($DOM_CRC_NILAI,2), 
                                    'AVG' => number_format($DOM_CRC_AVG,2),
                                    'RKAP' => number_format($RKAP_DOM_CRC,2),
                                ),

            "DOM_WR"     => array('TON'=> number_format($DOM_WR_TON,2),
                                    'NILAI' => number_format($DOM_WR_NILAI,2), 
                                    'AVG' => number_format($DOM_WR_AVG,2),
                                    'RKAP' => number_format($RKAP_DOM_WR,2),
                                ),

            "DOM_BLT"     => array('TON'=> number_format(0,2),
                                    'NILAI' => number_format(0,2),
                                    'AVG' => number_format(0,2),
                                    'RKAP' => number_format($RKAP_DOM_BLT,2),
                                ),

            "DOM_SUBTOTAL"     => array('TON'=> number_format( $DOM_HRT_TON+$DOM_HRC_TON+$DOM_HRPO_TON+$DOM_CRC_TON+$DOM_WR_TON,2), 
                                    'NILAI' => number_format($DOM_HRT_TON+$DOM_HRC_NILAI+$DOM_HRPO_NILAI+$DOM_CRC_NILAI+$DOM_WR_NILAI,2),
                                    'AVG' => '-',
                                    'RKAP' => '-',
                                ),

            "EKS_HRC"     => array('TON'=> number_format($EKS_HRC_TON,2),
                                    'NILAI' => number_format($EKS_HRC_NILAI,2),
                                    'AVG' => number_format($EKS_HRC_AVG,2),
                                    'RKAP' => number_format($RKAP_EKS_HRC,2),
                                ),

            "EKS_CRC"     => array('TON'=> number_format($EKS_CRC_TON,2),
                                    'NILAI' => number_format($EKS_CRC_NILAI,2),
                                    'AVG' => number_format($EKS_CRC_AVG,2),
                                    'RKAP' => number_format($RKAP_EKS_CRC,2),
                                ),

            "EKS_WR"     => array('TON'=> number_format($EKS_WR_TON,2),
                                    'NILAI' => number_format($EKS_WR_NILAI,2),
                                    'AVG' => number_format($EKS_WR_AVG,2),
                                    'RKAP' => number_format($RKAP_EKS_WR,2),
                                ),

            "EKS_SUBTOTAL"     => array('TON'=> number_format( $EKS_HRC_TON+$EKS_CRC_TON+$EKS_WR_TON,2), 
                                    'NILAI' => number_format( $EKS_HRC_NILAI+$EKS_CRC_NILAI+$EKS_WR_NILAI,2),
                                    'AVG' => '-',
                                    'RKAP' => '-',
                                ),

            "TOTAL"     => array('TON'=> number_format( ($DOM_HRT_TON+$DOM_HRC_TON+$DOM_HRPO_TON+$DOM_CRC_TON+$DOM_WR_TON)+($EKS_HRC_TON+$EKS_CRC_TON+$EKS_WR_TON),2), 
                                    'NILAI' => number_format( ($DOM_HRT_TON+$DOM_HRC_NILAI+$DOM_HRPO_NILAI+$DOM_CRC_NILAI+$DOM_WR_NILAI)+($EKS_HRC_NILAI+$EKS_CRC_NILAI+$EKS_WR_NILAI),2),
                                    'AVG' => '-',
                                    'RKAP' => '-',
                                ),
        );
        return $ret;
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
    public function targerRkap($month,$year,$tag_name,$lastDay)
    {
        $RKAP    = DB::table('target_rkap')->where('BULAN',$month)->where('TAHUN',$year)->get();
        if($RKAP){
            return $RKAP[0]->$tag_name/$lastDay;
        }
    }

    public function nilaiInvoice($tag_name,$first,$tangal)
    {
        $ret = DB::table('kontribusi_margin');

        switch ($tag_name) {
            case 'DOM_HRT':
                return $ret->where( DB::RAW('left(matrial,1)'),'H' )
                            ->where( DB::RAW('right(matrial,1)'),'T' )
                            ->where( 'tanggal','>=',$first )
                            ->where( 'tanggal','<=',$tangal )
                            ->where('dist','D0')
                            ->sum('sales_value_usd');
                break;
                
            case 'DOM_HRC':
                return $ret->where( DB::RAW('left(matrial,1)'),'H' )
                            ->where( DB::RAW('right(matrial,1)'),'<>','T' )
                            ->where( 'tanggal','>=',$first )
                            ->where( 'tanggal','<=',$tangal )
                            ->where('dist','D0')
                            ->sum('sales_value_usd');
                break;

            case 'DOM_HRPO':
                return $ret->where( DB::RAW('left(matrial,1)'),'P' )
                            ->where( 'tanggal','>=',$first )
                            ->where( 'tanggal','<=',$tangal )
                            ->where('dist','D0')
                            ->sum('sales_value_usd');
                break;

            case 'DOM_CRC':
                return $ret->whereIn( DB::RAW('left(matrial,1)'),['C','F'] )
                            ->where( 'tanggal','>=',$first )
                            ->where( 'tanggal','<=',$tangal )
                            ->where('dist','D0')
                            ->sum('sales_value_usd');
                break;

            case 'DOM_WR':
                return $ret->where( DB::RAW('left(matrial,1)'),'W' )
                            ->where( 'tanggal','>=',$first )
                            ->where( 'tanggal','<=',$tangal )
                            ->where('dist','D0')
                            ->sum('sales_value_usd');
                break;
                
            case 'EKS_HRC':
                return $ret->where( DB::RAW('left(matrial,1)'),'H' )
                            ->where( DB::RAW('right(matrial,1)'),'<>','T' )
                            ->where( 'tanggal','>=',$first )
                            ->where( 'tanggal','<=',$tangal )
                            ->where('dist','E0')
                            ->sum('sales_value_usd');
                break;

            case 'EKS_HRPO':
                return $ret->where( DB::RAW('left(matrial,1)'),'P' )
                            ->where( 'tanggal','>=',$first )
                            ->where( 'tanggal','<=',$tangal )
                            ->where('dist','E0')
                            ->sum('sales_value_usd');
                break;

            case 'EKS_CRC':
                return $ret->whereIn( DB::RAW('left(matrial,1)'),['C','F'] )
                            ->where( 'tanggal','>=',$first )
                            ->where( 'tanggal','<=',$tangal )
                            ->where('dist','E0')
                            ->sum('sales_value_usd');
                break;

            case 'EKS_WR':
                return $ret->where( DB::RAW('left(matrial,1)'),'W' )
                            ->where( 'tanggal','>=',$first )
                            ->where( 'tanggal','<=',$tangal )
                            ->where('dist','E0')
                            ->sum('sales_value_usd');
                break;
            
            default:
                # code...
                break;
        }
    }
    public function tonInvoice($tag_name,$first,$tangal)
    {
        $ret = DB::table('kontribusi_margin');

        switch ($tag_name) {
            case 'DOM_HRT':
                return $ret->where( DB::RAW('left(matrial,1)'),'H' )
                            ->where( DB::RAW('right(matrial,1)'),'T' )
                            ->where( 'tanggal','>=',$first )
                            ->where( 'tanggal','<=',$tangal )
                            ->where('dist','D0')
                            ->sum('quantity');
                break;
                
            case 'DOM_HRC':
                return $ret->where( DB::RAW('left(matrial,1)'),'H' )
                            ->where( DB::RAW('right(matrial,1)'),'<>','T' )
                            ->where( 'tanggal','>=',$first )
                            ->where( 'tanggal','<=',$tangal )
                            ->where('dist','D0')
                            ->sum('quantity');
                break;

            case 'DOM_HRPO':
                return $ret->where( DB::RAW('left(matrial,1)'),'P' )
                            ->where( 'tanggal','>=',$first )
                            ->where( 'tanggal','<=',$tangal )
                            ->where('dist','D0')
                            ->sum('quantity');
                break;

            case 'DOM_CRC':
                return $ret->whereIn( DB::RAW('left(matrial,1)'),['C','F'] )
                            ->where( 'tanggal','>=',$first )
                            ->where( 'tanggal','<=',$tangal )
                            ->where('dist','D0')
                            ->sum('quantity');
                break;

            case 'DOM_WR':
                return $ret ->where( DB::RAW('left(matrial,1)'),'W' )
                            ->where( 'tanggal','>=',$first )
                            ->where( 'tanggal','<=',$tangal )
                            ->where('dist','D0')
                            ->sum('quantity');
                break;

            case 'EKS_HRC':
                return $ret->where( DB::RAW('left(matrial,1)'),'H' )
                            ->where( DB::RAW('right(matrial,1)'),'<>','T' )
                            ->where( 'tanggal','>=',$first )
                            ->where( 'tanggal','<=',$tangal )
                            ->where('dist','E0')
                            ->sum('quantity');
                break;

            case 'EKS_HRPO':
                return $ret->where( DB::RAW('left(matrial,1)'),'P' )
                            ->where( 'tanggal','>=',$first )
                            ->where( 'tanggal','<=',$tangal )
                            ->where('dist','E0')
                            ->sum('quantity');
                break;

            case 'EKS_CRC':
                return $ret->whereIn( DB::RAW('left(matrial,1)'),['C','F'] )
                            ->where( 'tanggal','>=',$first )
                            ->where( 'tanggal','<=',$tangal )
                            ->where('dist','E0')
                            ->sum('quantity');
                break;

            case 'EKS_WR':
                return $ret ->where( DB::RAW('left(matrial,1)'),'W' )
                            ->where( 'tanggal','>=',$first )
                            ->where( 'tanggal','<=',$tangal )
                            ->where('dist','E0')
                            ->sum('quantity');
                break;
            
            default:
                # code...
                break;
        }
    }
}