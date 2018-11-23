<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Facades\Datatables;

class budgetProjectController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }
    public function index(Request $request)
    {
        $data_group 	= $request->get('data_group');
        $data_menu 		= $request->get('data_menu');

        return view('project.budegtProject', [
                    'data_group'=> $data_group,
                    'data_menu'	=> $data_menu,
        ]);
    }
    public function show(Request $request)
    {
        $data = DB::table('budget_project')
        ->orderBy('progress_overall','desc')
        ->get();
        return Datatables::of($data)->make(true);
    }
    public function getFiles()
    {
        //server
        // $readdir = "/mnt/winnt/";
        // $movedir = "/mnt/winnt/archive/";

        //local
        $readdir = './public/uploads/';
        $movedir = "./public/uploads/archive/";
        
        $arfile  = scandir($readdir);
        foreach ($arfile as $arsip) {
            if ($arsip!='.' && $arsip!='..') {
                $prefix=explode('_', $arsip);
                $kode = array('zps7008');
                if (in_array(strtolower($prefix[0]), $kode)) {

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

                    copy($readdir.$arsip, $movedir.$arsip);
                    $tr = DB::table('log_down')->insert(
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
        $val9 = $tanggal;

        $count = DB::table('budget_project')
        ->where('level',$val0)
        ->where('wbs_element',$val1)
        ->count();

        if($count > 0){
            DB::table('budget_project')
            ->where('level',$val0)
            ->where('wbs_element',$val1)
            ->update([
                'description' => $val2,
                'im_position' => $val3,
                'im_budget_overall' => $this->toNumber($val4),
                'wbs_budget_overall' => $this->toNumber($val5),
                'act_payment_total' => $this->toNumber($val6),
                'available_overall' => $this->toNumber($val7),
                'progress_overall' => $this->toNumber($val8),
                'datefile' => $val9,
            ]);
            echo "update - ".$val0." - ".$val1." <br>";
        }else{
            DB::table('budget_project')->insert([
                'level' => $val0,
                'wbs_element' => $val1,
                'description' => $val2,
                'im_position' => $val3,
                'im_budget_overall' => $this->toNumber($val4),
                'wbs_budget_overall' => $this->toNumber($val5),
                'act_payment_total' => $this->toNumber($val6),
                'available_overall' => $this->toNumber($val7),
                'progress_overall' => $this->toNumber($val8),
                'datefile' => $val9,
            ]);
            echo "insert - ".$val0." - ".$val1." <br>";
        }
        
    }
}
