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
        $count = DB::table('invoice')
        ->where('billing_date',$tanggal)
        ->orderBy('datefile','DESC')
        ->limit(1)->count();

        $ret = "";
        if($count == 0){
            $ret = DB::table('invoice')
            ->orderBy('billing_date','DESC')
            ->limit(1)->get();
        }else{
            $ret = DB::table('invoice')
            ->where('billing_date',$tanggal)
            ->orderBy('datefile','DESC')
            ->limit(1)->get();
        }
        return $ret[0]->datefile;
    }
    public function targerRkap($month,$year,$tag_name,$lastDay)
    {
        $RKAP    = DB::table('target_rkap')->where('BULAN',$month)->where('TAHUN',$year)->get();
        if($RKAP){
            return $RKAP[0]->$tag_name;
        }
    }

    public function nilaiInvoice($tag_name,$first,$tangal)
    {
        $ret = DB::table('invoice');

        switch ($tag_name) {
            case 'DOM_HRT':
                return $ret->where( DB::RAW('left(material,1)'),'H' )
                            ->where( DB::RAW('right(material,1)'),'T' )
                            ->where( 'billing_date','>=',$first )
                            ->where( 'billing_date','<=',$tangal )
                            ->where('dist_channel','D0')
                            ->sum('invoice_value_usd');
                break;
                
            case 'DOM_HRC':
                return $ret->where( DB::RAW('left(material,1)'),'H' )
                            ->where( DB::RAW('right(material,1)'),'<>','T' )
                            ->where( 'billing_date','>=',$first )
                            ->where( 'billing_date','<=',$tangal )
                            ->where('dist_channel','D0')
                            ->sum('invoice_value_usd');
                break;

            case 'DOM_HRPO':
                return $ret->where( DB::RAW('left(material,1)'),'P' )
                            ->where( 'billing_date','>=',$first )
                            ->where( 'billing_date','<=',$tangal )
                            ->where('dist_channel','D0')
                            ->sum('invoice_value_usd');
                break;

            case 'DOM_CRC':
                return $ret->whereIn( DB::RAW('left(material,1)'),['C','F'] )
                            ->where( 'billing_date','>=',$first )
                            ->where( 'billing_date','<=',$tangal )
                            ->where('dist_channel','D0')
                            ->sum('invoice_value_usd');
                break;

            case 'DOM_WR':
                return $ret->where( DB::RAW('left(material,1)'),'W' )
                            ->where( 'billing_date','>=',$first )
                            ->where( 'billing_date','<=',$tangal )
                            ->where('dist_channel','D0')
                            ->sum('invoice_value_usd');
                break;
                
            case 'EKS_HRC':
                return $ret->where( DB::RAW('left(material,1)'),'H' )
                            ->where( DB::RAW('right(material,1)'),'<>','T' )
                            ->where( 'billing_date','>=',$first )
                            ->where( 'billing_date','<=',$tangal )
                            ->where('dist_channel','E0')
                            ->sum('invoice_value_usd');
                break;

            case 'EKS_HRPO':
                return $ret->where( DB::RAW('left(material,1)'),'P' )
                            ->where( 'billing_date','>=',$first )
                            ->where( 'billing_date','<=',$tangal )
                            ->where('dist_channel','E0')
                            ->sum('invoice_value_usd');
                break;

            case 'EKS_CRC':
                return $ret->whereIn( DB::RAW('left(material,1)'),['C','F'] )
                            ->where( 'billing_date','>=',$first )
                            ->where( 'billing_date','<=',$tangal )
                            ->where('dist_channel','E0')
                            ->sum('invoice_value_usd');
                break;

            case 'EKS_WR':
                return $ret->where( DB::RAW('left(material,1)'),'W' )
                            ->where( 'billing_date','>=',$first )
                            ->where( 'billing_date','<=',$tangal )
                            ->where('dist_channel','E0')
                            ->sum('invoice_value_usd');
                break;
            
            default:
                # code...
                break;
        }
    }
    public function tonInvoice($tag_name,$first,$tangal)
    {
        $ret = DB::table('invoice');

        switch ($tag_name) {
            case 'DOM_HRT':
                return $ret->where( DB::RAW('left(material,1)'),'H' )
                            ->where( DB::RAW('right(material,1)'),'T' )
                            ->where( 'billing_date','>=',$first )
                            ->where( 'billing_date','<=',$tangal )
                            ->where('dist_channel','D0')
                            ->sum('net_weight');
                break;
                
            case 'DOM_HRC':
                return $ret->where( DB::RAW('left(material,1)'),'H' )
                            ->where( DB::RAW('right(material,1)'),'<>','T' )
                            ->where( 'billing_date','>=',$first )
                            ->where( 'billing_date','<=',$tangal )
                            ->where('dist_channel','D0')
                            ->sum('net_weight');
                break;

            case 'DOM_HRPO':
                return $ret->where( DB::RAW('left(material,1)'),'P' )
                            ->where( 'billing_date','>=',$first )
                            ->where( 'billing_date','<=',$tangal )
                            ->where('dist_channel','D0')
                            ->sum('net_weight');
                break;

            case 'DOM_CRC':
                return $ret->whereIn( DB::RAW('left(material,1)'),['C','F'] )
                            ->where( 'billing_date','>=',$first )
                            ->where( 'billing_date','<=',$tangal )
                            ->where('dist_channel','D0')
                            ->sum('net_weight');
                break;

            case 'DOM_WR':
                return $ret ->where( DB::RAW('left(material,1)'),'W' )
                            ->where( 'billing_date','>=',$first )
                            ->where( 'billing_date','<=',$tangal )
                            ->where('dist_channel','D0')
                            ->sum('net_weight');
                break;

            case 'EKS_HRC':
                return $ret->where( DB::RAW('left(material,1)'),'H' )
                            ->where( DB::RAW('right(material,1)'),'<>','T' )
                            ->where( 'billing_date','>=',$first )
                            ->where( 'billing_date','<=',$tangal )
                            ->where('dist_channel','E0')
                            ->sum('net_weight');
                break;

            case 'EKS_HRPO':
                return $ret->where( DB::RAW('left(material,1)'),'P' )
                            ->where( 'billing_date','>=',$first )
                            ->where( 'billing_date','<=',$tangal )
                            ->where('dist_channel','E0')
                            ->sum('net_weight');
                break;

            case 'EKS_CRC':
                return $ret->whereIn( DB::RAW('left(material,1)'),['C','F'] )
                            ->where( 'billing_date','>=',$first )
                            ->where( 'billing_date','<=',$tangal )
                            ->where('dist_channel','E0')
                            ->sum('net_weight');
                break;

            case 'EKS_WR':
                return $ret ->where( DB::RAW('left(material,1)'),'W' )
                            ->where( 'billing_date','>=',$first )
                            ->where( 'billing_date','<=',$tangal )
                            ->where('dist_channel','E0')
                            ->sum('net_weight');
                break;
            
            default:
                # code...
                break;
        }
    }
    public function getFiles()
    {
        //server
        $readdir = "/nfs/interface/dashboard/";
        $movedir = "/nfs/interface/dashboard/archive/";

        //local
        //$readdir = './public/uploads/';
        //$movedir = "./public/uploads/archive/";
        
        $arfile  = scandir($readdir);
        foreach ($arfile as $arsip) {
            if ($arsip!='.' && $arsip!='..') {
                $prefix=explode('_', $arsip);
                $kode = array('invoice');
                if (in_array(strtolower($prefix[0]), $kode)) {

                    //arsipkan file
                    $copy = copy($readdir.$arsip, $movedir.$arsip);
                    if(!$copy){
                        die('Prosess File Gagal '.$movedir.$arsip);
                    }

                    $file_handle = fopen($readdir.$arsip, "rb");
                    $i = 1;

                    while (!feof($file_handle)) {
                        $line_of_text = fgets($file_handle);
                        if ($i>1) {
                            if (strlen($line_of_text)>0) {
                                $hsl = $this->tulisfile(strtolower($prefix[0]), $line_of_text, $prefix[1]);
                            }
                        }
                        $i++;
                    }
                    fclose($file_handle);
                    // copy($readdir.$arsip, $movedir.$arsip);
                    DB::table('log_down')->insert(
                        [
                            'isinya'  => 'Proses Download File '.$arsip,
                            'stat'    => '1'
                        ]
                    );
                    unlink($readdir.$arsip);
                }
            }
        }
        set_time_limit(60);
    }
    public function convert($value=NULL)
    {
      isset($value) ? $ret = trim($value) : $ret = NULL;
      if (substr($ret, -1)=='-') { 
        $ret = trim(substr($ret, -1)).trim(substr($ret, 0, strlen($ret)-1)); 
      }
      return $ret;
    }
    public function toNumber($teks)
    {
        $hsl	= str_replace(".", "", $teks);
        $ret	= str_replace(",", ".", $hsl);

        return $ret;
    }
    public function tulisfile($tabel, $teks, $dateOnFile)
    {
        $date		= strtotime(substr($dateOnFile, 0, 8));
        $tanggal    = date("Y-m-d", $date);

        $delimiter = "|";
        $splitcontents = explode($delimiter, $teks);
        
        $val0 = $this->convert($splitcontents[0]);
        $val1 = $this->convert($splitcontents[1]);
        $val2 = $this->convert($splitcontents[2]);
        $val3 = $this->convert($splitcontents[3]);
        $val4 = $this->convert($splitcontents[4]);
        $val5 = $this->convert($splitcontents[5]);
        $val6 = $this->convert($splitcontents[6]);
        $val7 = $this->convert($splitcontents[7]);
        $val8 = $this->convert($splitcontents[8]);
        $val9 = $this->convert($splitcontents[9]);

        $val10 = $this->convert($splitcontents[10]);
        $val11 = $this->convert($splitcontents[11]);
        $val12 = $this->convert($splitcontents[12]);
        $val13 = $this->convert($splitcontents[13]);
        $val14 = $this->convert($splitcontents[14]);
        $val15 = $this->convert($splitcontents[15]);
        $val16 = $this->convert($splitcontents[16]);

        DB::table('invoice')->insert([
            'material' => $val0,
            'description' => $val1,
            'sales_value_rp' => $this->toNumber($val2),
            'sales_value_usd' => $this->toNumber($val3),
            'billing_date' => date("Y-m-d", strtotime($val4)),
            'billing_number' => $val5,
            'net_weight' => $this->toNumber($val6),
            'uom' => $val7,
            'dist_channel' => $val8,
            'invoice_value_rp' => $this->toNumber($val9),
            'dp_value_rp' => $this->toNumber($val10),
            'ppn_value_rp' => $this->toNumber($val11),
            'pph_value_rp' => $this->toNumber($val12),
            'invoice_value_usd' => $this->toNumber($val13),
            'dp_value_usd' => $this->toNumber($val14),
            'ppn_value_usd' => $this->toNumber($val15),
            'pph_value_usd' => $this->toNumber($val16),
            'datefile' => $tanggal,
        ]);
    }
}
