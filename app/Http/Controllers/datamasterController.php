<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\sys_user;
use App\sys_group;

class datamasterController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }
    public function index(Request $request)
    {
        $data_group 	= $request->get('data_group');
        $data_menu 		= $request->get('data_menu');
        $data			    = $this->dataForTransfer();
        return view('datamaster', [
                    'data_group'=> $data_group,
                    'data_menu'	=> $data_menu,
                    'data'		=> $data
        ]);
    }
    public function DataMesLong($tanggal=null,$tag_name=null,$value=null)
    {
        // cek tanggal
        if( !isset($tanggal) ){
          die('Date is empty');
        }else{
          $strtotime  = strtotime($tanggal);
          $tanggal    = date('Y-m-d 00:00:00',$strtotime);
          if($tanggal == "1970-01-01"){
            die('Wrong date');
          }
        }

        // cek tag name
        if( !isset($tag_name) ){
          die('Tag Name is empty');
        }

        // cek nilai yang dikirim
        if( !isset($value) ){
          die('Current Value is empty');
        }else{
          $output = preg_replace( '/[^0-9]/', '', $value );
          if( $output == ''){
            die('Value not number');
          }
        }

        //cek isi tag name
        if($tag_name == 'WR_INP_ROLL' || $tag_name == 'WR_PROD' ){

            // select table
            $DB     = DB::table('data_from_up');
            $TF     = DB::table('data_for_transfer_vd')->select('produk_id','tanggal','group','tag_name','child1','child2','value as current_value');
            $datas  = DB::table('datas');

            //cek data yang dikirim ada/kosong
            if( $DB->where('tag_name', $tag_name)->where('tanggal',$tanggal)->count() > 0 ){
                //jika ada update
                echo "Data already exists. <br>";
                $update = $DB->where('tag_name', $tag_name)->where('tanggal',$tanggal)->update(['value'=>$value]);
                if($update){
                  echo "Successfully Update Data. <br>";

                  // transfer ke table datas
                  $TF_DATA  = $TF->where('key',$tag_name)->where('tanggal',date('Y-m-d',$strtotime))->get();
                  $x        = json_decode(json_encode($TF_DATA), True);
                  $ret      = $datas->where('produk_id',$x[0]['produk_id'])
                              ->where('tag_name',$x[0]['tag_name'])
                              ->where('tanggal',$x[0]['tanggal'])
                              ->update($x[0]);
                  if($ret){
                    echo "Transfer Successfully. <br>";
                  }

                }
            }else{
              // jika kosong insert
              $insert = $DB->insert(['tanggal'=>$tanggal,'tag_name'=>$tag_name,'value'=>$value]);
              if($insert){
                  echo "Successfully Added Data. <br>";

                  // transfer ke table datas
                  $TF_DATA  = $TF->where('key',$tag_name)->where('tanggal',date('Y-m-d',$strtotime))->get();
                  $x        = json_decode(json_encode($TF_DATA), True);
                  $ret      = $datas->insert( $x );
                  if($ret){
                    echo "Transfer Successfully. <br>";
                  }

              }
            }

        }else{
            echo "Tag name is not registered.";
        }
    }
    public function TransferToDatas()
    {
        $dataFromUp = DB::table('data_from_up')->where('tag_name','WR_INP_ROLL')->get();
        return $dataFromUp;
    }
    public function getDataMes($tgl = null)
    {
        $now        = strtotime(date("Y-m-d"));
        $kemarin    = date("dmY", strtotime('-1 day', $now));
        $date 		  = isset($tgl)?date('dmY', strtotime($tgl)):$kemarin;

        $client 	 = new \GuzzleHttp\Client();
        $res 		   = $client->request('GET', 'http://10.10.8.129/ws-mes/rest/index/id/'.$date.'/format/json');
        $dataAPI 	 = json_decode($res->getBody());

        // jika data belum ada maka insert
        foreach ($dataAPI as $key => $value) {
            $data = DB::table('data_from_up')->where([
                ['tanggal','=',date("Y-m-d 00:00:00", strtotime($value->TANGGAL))],
                ['tag_name','=',$value->KRITERIA]
            ])->count();

            if ($data == 0) {
                $tr = DB::table('data_from_up')->insert(
                    [
                        'tanggal' 	=> date("Y-m-d", strtotime($value->TANGGAL)),
                        'tag_name' 	=> $value->KRITERIA,
                        'value'		=> isset($value->JUMLAH) ? $value->JUMLAH : 0,
                    ]
                );
                $logg =  'INSERT OK : '.date("Y-m-d", strtotime($value->TANGGAL)).' - '.$value->KRITERIA.' - '.$value->JUMLAH.'<br>';
                $tr = DB::table('log_down')->insert(['isinya'	=> $logg, 'stat'	=> '1']);
            }
        }

        // jika data sama dan value lebih tidak sama maka di update
        foreach ($dataAPI as $key => $value) {
            $data = DB::table('data_from_up')->where([
                ['tanggal','=',date("Y-m-d 00:00:00", strtotime($value->TANGGAL))],
                ['tag_name','=',$value->KRITERIA]
            ])->get();

            foreach ($data as $key => $value_a) {
                if ($value->JUMLAH != $value_a->value) {
                    $tr = DB::table('data_from_up')
                        ->where([
                            ['tanggal','=',date("Y-m-d 00:00:00", strtotime($value->TANGGAL))],
                            ['tag_name','=',$value->KRITERIA]
                        ])->update(
                            [
                                'tanggal' 	=> date("Y-m-d", strtotime($value->TANGGAL)),
                                'tag_name' 	=> $value->KRITERIA,
                                'value'		=> isset($value->JUMLAH) ? $value->JUMLAH : 0,
                            ]
                    );
                    $logg = 'UPDATE OK : '.date("Y-m-d", strtotime($value->TANGGAL)).' - '.$value->KRITERIA.' - '.$value->JUMLAH.'<br>';
                    $tr = DB::table('log_down')->insert(['isinya'	=> $logg, 'stat'	=> '1']);
                }
            }
        }

        // transfer to datas
        $kemarin    = date("Y-m-d", strtotime('-1 day', $now));
        $date 		= isset($tgl)?date('Y-m-d', strtotime($tgl)):$kemarin;

        $data_for_transfer = DB::table('data_for_transfer_vd')->where('tanggal', $date)->get();
        foreach ($data_for_transfer as $key => $value) {
            $data = DB::table('datas')->where([
                ['produk_id','=',$value->produk_id],
                ['tanggal','=',$value->tanggal],
                ['group','=',$value->group],
                ['tag_name','=',$value->tag_name],
                ['child1','=',$value->child1],
                ['child2','=',$value->child2]
            ])->count();
            if ($data == 0) {
                $tr = DB::table('datas')->insert(
                    [
                        'produk_id' 	=> $value->produk_id,
                        'tanggal' 		=> $value->tanggal,
                        'group'			=> $value->group,
                        'tag_name'		=> $value->tag_name,
                        'child1'		=> $value->child1,
                        'child2'		=> $value->child2,
                        'current_value'	=> $value->value
                    ]
                );
                $logg = 'TRANSFER OK : '.$value->produk_id.' - '.$value->tanggal.' - '.$value->group.' - '.$value->tag_name.' - '.$value->child1.' - '.$value->child2.' - '.$value->value.'<br>';
                $tr = DB::table('log_down')->insert(['isinya'	=> $logg, 'stat'	=> '1']);
            }
        }
        // update jika ada current_value yg berubah pada tanggal yg sama
        foreach ($data_for_transfer as $key => $value) {
            $data = DB::table('datas')->where([
                ['produk_id','=',$value->produk_id],
                ['tanggal','=',$value->tanggal],
                ['group','=',$value->group],
                ['tag_name','=',$value->tag_name],
                ['child1','=',$value->child1],
                ['child2','=',$value->child2]
            ])->get();

            foreach ($data as $key => $value_b) {
                if ($value->value != $value_b->current_value) {
                    $tr = DB::table('datas')
                            ->WHERE([
                                ['produk_id','=',$value->produk_id],
                                ['tanggal','=',$value->tanggal],
                                ['group','=',$value->group],
                                ['tag_name','=',$value->tag_name],
                                ['child1','=',$value->child1],
                                ['child2','=',$value->child2]
                            ])
                            ->UPDATE(
                                [
                                  'produk_id' 	=> $value->produk_id,
                                  'tanggal' 		=> $value->tanggal,
                                  'group'			=> $value->group,
                                  'tag_name'		=> $value->tag_name,
                                  'child1'		=> $value->child1,
                                  'child2'		=> $value->child2,
                                  'current_value'	=> $value->value
                                ]
                    );
                    $logg =  'UPDATE TRANSFER OK : '.$value->produk_id.' - '.$value->tanggal.' - '.$value->group.' - '.$value->tag_name.' - '.$value->child1.' - '.$value->child2.' - '.$value->value.'<br>';
                    $tr = DB::table('log_down')->insert(['isinya'	=> $logg, 'stat'	=> '1']);
                }
            }
        }
    }
    public function dataForTransfer()
    {
        $ret = DB::table('datas')
                    ->offset(0)
                    ->limit(20)
                    ->orderBy('tanggal', 'desc')
                    ->get();
        return $ret;
    }
    public function ujicoba()
    {
        $tr = DB::table('log_down')->insert(
            [
                'isinya'	=> date('Ymd H:i:s'),
                'stat'		=> '1'
            ]
        );
    }
    public function getdatasapOLD()
    {
        set_time_limit(600);
        $readdir = "/mnt/winnt/";
        $movedir = "/mnt/winnt/archive/";
        $arfile  = scandir($readdir);

        // satart download data mes
        $this->getDataMes();

        foreach ($arfile as $arsip) {
            if ($arsip!='.' && $arsip!='..') {
                $prefix=explode('_', $arsip);
                // $kode = array('Margin', 'margin', 'StockSO', 'CR', 'cr', 'WR', 'wr', 'hr', 'HR', 'HRPO', 'hrpo');
                $kode = array('margin','stockso','cr','wr','hr','hrpo','lc','cash','budget&actual');

                if ( in_array(strtolower($prefix[0]), $kode) ) {

                    if( strtolower($prefix[0]) == 'budget&actual'){
                        DB::table('laporanpk')->truncate();
                    }

                    $file_handle = fopen($readdir.$arsip, "rb");
                    $i = 1;

                    while (!feof($file_handle)) {
                        $line_of_text = fgets($file_handle);
                        if ($i>1) {
                            if (strlen($line_of_text)>0) {
                                $hsl = $this->tulisfile( strtolower($prefix[0]),$line_of_text, $prefix[1] );
                            }
                        }
                        $i++;
                    }
                    fclose($file_handle);

                    copy($readdir.$arsip, $movedir.$arsip);
                    $tr = DB::table('log_down')->insert(
                    [
                        'isinya'	=> 'Proses Download File '.$arsip,
                        'stat'		=> '1'
                    ]
                );
                    unlink($readdir.$arsip);
                }
            }
        }

        set_time_limit(30);
    }

    public function toNumber($teks)
    {
        $hsl	= str_replace(".", "", $teks);
        $ret	= str_replace(",", ".", $hsl);

        return $ret;
    }
    public function convert($value=NULL)
    {
      isset($value) ? $ret = trim($value) : $ret = NULL;
      if (substr($ret, -1)=='-') { 
        $ret = trim(substr($ret, -1)).trim(substr($ret, 0, strlen($ret)-1)); 
      }
      return $ret;
    }
    public function tulisfile($tabel, $teks, $lsupdate)
    {
        $now		    = strtotime(substr($lsupdate, 0, 8));
        $kemarin    = date("Y-m-d", strtotime('-1 day', $now));
        $lastupdate = $kemarin;
        $lastuptime = substr($lsupdate, 8, 2).':00:00';

        switch ($tabel) {
          //========================================= RELISASI FOH ===============================
          case 'zps7010':
              $delimiter = "|";
              $splitcontents = explode($delimiter, $teks);

              $val0 = $this->convert($splitcontents[0]);//PK
              $val1 = $this->convert($splitcontents[1]);//deskripsi
              $val2 = $this->convert($splitcontents[2]);//rekening
              $val3 = $this->convert($splitcontents[3]);//nama rekening
              $val4 = $this->convert($splitcontents[4]);//realisasi lama
              $val5 = $this->convert($splitcontents[5]);//rata-rata lama
              $val6 = $this->convert($splitcontents[6]);//realisasi januari
              $val7 = $this->convert($splitcontents[7]);//realisasi febuari
              $val8 = $this->convert($splitcontents[8]);//realisasi maret
              $val9 = $this->convert($splitcontents[9]);//realisasi april
              $val10 = $this->convert($splitcontents[10]);//realisasi mei

              $val11 = $this->convert($splitcontents[11]);//realisasi juni
              $val12 = $this->convert($splitcontents[12]);//real-smt-1 
              $val13 = $this->convert($splitcontents[13]);//realisasi juli
              $val14 = $this->convert($splitcontents[14]);//realisasi agustus
              $val15 = $this->convert($splitcontents[15]);//realisasi september
              $val16 = $this->convert($splitcontents[16]);//realisasi oktober
              $val17 = $this->convert($splitcontents[17]);//realisasi november
              $val18 = $this->convert($splitcontents[18]);//realisasi desember
              $val19 = $this->convert($splitcontents[19]);//real-q123
              $val20 = $this->convert($splitcontents[20]);//real jan-des

              $val21 = $this->convert($splitcontents[21]);//anggaran smt 1
              $val22 = $this->convert($splitcontents[22]);//anggaran per bulan
              $val23 = $this->convert($splitcontents[23]);//rkap 
              $val24 = $this->convert($splitcontents[24]);//anggaran jan-des
              $val25 = $this->convert($splitcontents[25]);//sisa anggaran

              DB::table('realisasi_foh')
                ->where('tahun', date('Y',$now) )
                ->where('pk', $val0 )
                ->where('rekening', $val2 )
                ->delete();

              DB::table('realisasi_foh')->insert([
                'tahun'=>date('Y',$now),
                'pk'=>$val0,
                'rekening'=>$val2,
                'deskripsi'=>$val1,
                'nama_rekening'=>$val3,
                'realisasi_lama'=>$this->toNumber($val4),
                'rata_rata_lama'=>$this->toNumber($val5),

                'realisasi_januari'=>$this->toNumber($val6),
                'realisasi_februari'=>$this->toNumber($val7),
                'realisasi_maret'=>$this->toNumber($val8),
                'realisasi_april'=>$this->toNumber($val9),
                'realisasi_mei'=>$this->toNumber($val10),
                'realisasi_juni'=>$this->toNumber($val11),

                'real_smt_1'=>$this->toNumber($val12),

                'realisasi_juli'=>$this->toNumber($val13),
                'realisasi_agustus'=>$this->toNumber($val14),
                'realisasi_september'=>$this->toNumber($val15),
                'realisasi_oktober'=>$this->toNumber($val16),
                'realisasi_november'=>$this->toNumber($val17),
                'realisasi_desember'=>$this->toNumber($val18),

                'real_q123'=>$this->toNumber($val19),
                'real_jan_des'=>$this->toNumber($val20),
                'anggaran_smt_1'=>$this->toNumber($val21),
                'anggaran_per_bulan'=>$this->toNumber($val22),
                'rkap'=>$this->toNumber($val23),
                'anggaran_jan_des'=>$this->toNumber($val24),
                'sisa_anggaran'=>$this->toNumber($val25),
                'datefile'=>date('Y-m-d',$now),
                'dateload'=>date('Y-m-d')
              ]);
              

            //   $sql = 'insert ignore into stock (
            //             `id`,
            //             `deskripsi_kode`,
            //             `material`,
            //             `plant`,
            //             `sloc`,
            //             `quantity`,
            //             `dateload`
            //         )values (
            //           NULL,
            //           "'.$val0.'",
            //           "'.$val1.'",
            //           "'.$val2.'",
            //           "'.$val3.'",
            //           "'.str_replace(",", ".", $val4).'",
            //           "'.date('Y-m-d',$now).date(' H:i:s').'"
            //         );';
            // $tr   = DB::insert($sql);
          break;
          //========================================= STOCK ===============================
          case 'stock':
              $delimiter = "|";
              $splitcontents = explode($delimiter, $teks);

              isset($splitcontents[0]) ? $val0 = trim($splitcontents[0]) : $val0 = 'null';
              isset($splitcontents[1]) ? $val1 = trim($splitcontents[1]) : $val1 = 'null';
              isset($splitcontents[2]) ? $val2 = trim($splitcontents[2]) : $val2 = 'null';
              isset($splitcontents[3]) ? $val3 = trim($splitcontents[3]) : $val3 = 'null';
              isset($splitcontents[4]) ? $val4 = trim($splitcontents[4]) : $val4 = 'null';

              if (substr($val0, -1)=='-') { $val0 = trim(substr($val0, -1)).trim(substr($val0, 0, strlen($val0)-1)); }
              if (substr($val1, -1)=='-') { $val1 = trim(substr($val1, -1)).trim(substr($val1, 0, strlen($val1)-1)); }
              if (substr($val2, -1)=='-') { $val2 = trim(substr($val2, -1)).trim(substr($val2, 0, strlen($val2)-1)); }
              if (substr($val3, -1)=='-') { $val3 = trim(substr($val3, -1)).trim(substr($val3, 0, strlen($val3)-1)); }
              if (substr($val4, -1)=='-') { $val4 = trim(substr($val4, -1)).trim(substr($val4, 0, strlen($val4)-1)); }

              $sql = 'insert ignore into stock (
                        `id`,
                        `deskripsi_kode`,
                        `material`,
                        `plant`,
                        `sloc`,
                        `quantity`,
                        `dateload`
                    )values (
                      NULL,
                      "'.$val0.'",
                      "'.$val1.'",
                      "'.$val2.'",
                      "'.$val3.'",
                      "'.$this->toNumber($val4).'",
                      "'.date('Y-m-d',$now).date(' H:i:s').'"
                    );';
            $tr   = DB::insert($sql);
          break;
          //========================================= HUTANG KMK ===============================
          case 'hutangkmk':
              $delimiter = "|";
              $splitcontents = explode($delimiter, $teks);

              isset($splitcontents[0]) ? $val0 = trim($splitcontents[0]) : $val0 = 'null';
              isset($splitcontents[1]) ? $val1 = trim($splitcontents[1]) : $val1 = 'null';
              isset($splitcontents[2]) ? $val2 = trim($splitcontents[2]) : $val2 = 'null';
              isset($splitcontents[3]) ? $val3 = trim($splitcontents[3]) : $val3 = 'null';
              isset($splitcontents[4]) ? $val4 = trim($splitcontents[4]) : $val4 = 'null';
              isset($splitcontents[5]) ? $val5 = trim($splitcontents[5]) : $val5 = 'null';
              isset($splitcontents[6]) ? $val6 = trim($splitcontents[6]) : $val6 = 'null';
              isset($splitcontents[7]) ? $val7 = trim($splitcontents[7]) : $val7 = 'null';

              if (substr($val0, -1)=='-') { $val0 = trim(substr($val0, -1)).trim(substr($val0, 0, strlen($val0)-1)); }
              if (substr($val1, -1)=='-') { $val1 = trim(substr($val1, -1)).trim(substr($val1, 0, strlen($val1)-1)); }
              if (substr($val2, -1)=='-') { $val2 = trim(substr($val2, -1)).trim(substr($val2, 0, strlen($val2)-1)); }
              if (substr($val3, -1)=='-') { $val3 = trim(substr($val3, -1)).trim(substr($val3, 0, strlen($val3)-1)); }
              if (substr($val4, -1)=='-') { $val4 = trim(substr($val4, -1)).trim(substr($val4, 0, strlen($val4)-1)); }
              if (substr($val5, -1)=='-') { $val5 = trim(substr($val5, -1)).trim(substr($val5, 0, strlen($val5)-1)); }
              if (substr($val6, -1)=='-') { $val6 = trim(substr($val6, -1)).trim(substr($val6, 0, strlen($val6)-1)); }
              if (substr($val7, -1)=='-') { $val7 = trim(substr($val7, -1)).trim(substr($val7, 0, strlen($val7)-1)); }

              $posting_date   = date('Y-m-d', strtotime(str_replace(".", "-", $val3)));
              $document_date  = date('Y-m-d', strtotime(str_replace(".", "-", $val4)));

              $sql = 'insert ignore into hutang_kmk (
                        `ID`,
                        `gl_account`,
                        `assignment`,
                        `document_number`,
                        `posting_date`,
                        `document_date`,
                        `amount`,
                        `currency`,
                        `text`,
                        `timeload`
                    )values (
                      NULL,
                      "'.$val0.'",
                      "'.$val1.'",
                      "'.$val2.'",
                      "'.$posting_date.'",
                      "'.$document_date.'",
                      "'.$this->toNumber($val5).'",
                      "'.$val6.'",
                      "'.$val7.'",
                      "'.date('Y-m-d',$now).date(' H:i:s').'"
                    );';


            $tr   = DB::insert($sql);
          break;
          //========================================= SO BANK ===============================
          case 'saldobank':
              $delimiter = "|";
              $splitcontents = explode($delimiter, $teks);

              isset($splitcontents[0]) ? $val0 = trim($splitcontents[0]) : $val0 = 'null';
              isset($splitcontents[1]) ? $val1 = trim($splitcontents[1]) : $val1 = 'null';
              isset($splitcontents[2]) ? $val2 = trim($splitcontents[2]) : $val2 = 'null';
              isset($splitcontents[3]) ? $val3 = trim($splitcontents[3]) : $val3 = 'null';
              isset($splitcontents[4]) ? $val4 = trim($splitcontents[4]) : $val4 = 'null';
              isset($splitcontents[5]) ? $val5 = trim($splitcontents[5]) : $val5 = 'null';

              if (substr($val0, -1)=='-') { $val0 = trim(substr($val0, -1)).trim(substr($val0, 0, strlen($val0)-1)); }
              if (substr($val1, -1)=='-') { $val1 = trim(substr($val1, -1)).trim(substr($val1, 0, strlen($val1)-1)); }
              if (substr($val2, -1)=='-') { $val2 = trim(substr($val2, -1)).trim(substr($val2, 0, strlen($val2)-1)); }
              if (substr($val3, -1)=='-') { $val3 = trim(substr($val3, -1)).trim(substr($val3, 0, strlen($val3)-1)); }
              if (substr($val4, -1)=='-') { $val4 = trim(substr($val4, -1)).trim(substr($val4, 0, strlen($val4)-1)); }
              if (substr($val5, -1)=='-') { $val5 = trim(substr($val5, -1)).trim(substr($val5, 0, strlen($val5)-1)); }

              $sql = 'insert ignore into saldo_bank (
                        `ID`,
                        `CURRENCY`,
                        `BANK_NAME`,
                        `BANK_KEY`,
                        `ACCOUNT_NUMBER`,
                        `STATEMENT_DATE`,
                        `ENDING_BALANCE`,
                        `DATEFILE`,
                        `TIMELOAD`
                    )values (
                      NULL,
                      "'.$val0.'",
                      "'.$val1.'",
                      "'.$val2.'",
                      "'.$val3.'",
                      "'.$val4.'",
                      "'.$val5.'",
                      "'.date('Y-m-d',$now).'",
                      "'.date('Y-m-d H:i:s').'"
                    );';

            $tr   = DB::insert($sql);
          //========================================= LAPORAN PK ===============================
          case 'budget&actual':
              $delimiter = "|";
              $splitcontents = explode($delimiter, $teks);

              isset($splitcontents[0]) ? $val0 = trim($splitcontents[0]) : $val0 = 'null';
              isset($splitcontents[1]) ? $val1 = trim($splitcontents[1]) : $val1 = 'null';
              isset($splitcontents[2]) ? $val2 = trim($splitcontents[2]) : $val2 = 'null';
              isset($splitcontents[3]) ? $val3 = trim($splitcontents[3]) : $val3 = 'null';
              isset($splitcontents[4]) ? $val4 = trim($splitcontents[4]) : $val4 = 'null';
              isset($splitcontents[5]) ? $val5 = trim($splitcontents[5]) : $val5 = 'null';
              isset($splitcontents[6]) ? $val6 = trim($splitcontents[6]) : $val6 = 'null';
              isset($splitcontents[7]) ? $val7 = trim($splitcontents[7]) : $val7 = 'null';
              isset($splitcontents[8]) ? $val8 = trim($splitcontents[8]) : $val8 = 'null';
              isset($splitcontents[9]) ? $val9 = trim($splitcontents[9]) : $val9 = 'null';
              isset($splitcontents[10]) ? $val10 = trim($splitcontents[10]) : $val10 = 'null';

              if (substr($val2, -1)=='-') { $val2 = trim(substr($val2, -1)).trim(substr($val2, 0, strlen($val2)-1)); }
              if (substr($val3, -1)=='-') { $val3 = trim(substr($val3, -1)).trim(substr($val3, 0, strlen($val3)-1)); }
              if (substr($val4, -1)=='-') { $val4 = trim(substr($val4, -1)).trim(substr($val4, 0, strlen($val4)-1)); }
              if (substr($val5, -1)=='-') { $val5 = trim(substr($val5, -1)).trim(substr($val5, 0, strlen($val5)-1)); }
              if (substr($val6, -1)=='-') { $val6 = trim(substr($val6, -1)).trim(substr($val6, 0, strlen($val6)-1)); }
              if (substr($val7, -1)=='-') { $val7 = trim(substr($val7, -1)).trim(substr($val7, 0, strlen($val7)-1)); }
              if (substr($val8, -1)=='-') { $val8 = trim(substr($val8, -1)).trim(substr($val8, 0, strlen($val8)-1)); }
              if (substr($val9, -1)=='-') { $val9 = trim(substr($val9, -1)).trim(substr($val9, 0, strlen($val9)-1)); }
              if (substr($val10, -1)=='-') { $val10 = trim(substr($val10, -1)).trim(substr($val10, 0, strlen($val10)-1)); }

              $sql = 'insert ignore into laporanpk (
                        `ID`,
                        `IM_POSITION`,
                        `DESCRIPTION`,
                        `APPROVAL_YEAR`,
                        `PROGRAM_PLAN`,
                        `PROGRAM_BUDGET`,
                        `APPR_REQ_PLAN`,
                        `MRA_AVAIL_BUDGET`,
                        `APPR_REQUEST`,
                        `AR_DESCRIPTION`,
                        `AR_VALUE`,
                        `ACTUAL`,
                        `DATELOAD`
                    )values (
                      NULL,
                      "'.$val0.'",
                      "'.$val1.'",
                      "'.$val2.'",
                      "'.$val3.'",
                      "'.$val4.'",
                      "'.$val5.'",
                      "'.$val6.'",
                      "'.$val7.'",
                      "'.$val8.'",
                      "'.$val9.'",
                      "'.$val10.'",
                      "'.date('Y-m-d',$now).date(' H:i:s').'"
                    );';
            $tr   = DB::insert($sql);
          break;
          //========================================= CASH ===============================
          case 'CASH':
          case 'cash':
              $delimiter = "|";
              $splitcontents = explode($delimiter, $teks);

              isset($splitcontents[0]) ? $val0 = trim($splitcontents[0]) : $val0 = 'null';
              isset($splitcontents[1]) ? $val1 = trim($splitcontents[1]) : $val1 = 'null';
              isset($splitcontents[2]) ? $val2 = trim($splitcontents[2]) : $val2 = 'null';
              isset($splitcontents[3]) ? $val3 = trim($splitcontents[3]) : $val3 = 'null';
              isset($splitcontents[4]) ? $val4 = trim($splitcontents[4]) : $val4 = 'null';
              isset($splitcontents[5]) ? $val5 = trim($splitcontents[5]) : $val5 = 'null';
              isset($splitcontents[6]) ? $val6 = trim($splitcontents[6]) : $val6 = 'null';
              isset($splitcontents[7]) ? $val7 = trim($splitcontents[7]) : $val7 = 'null';
              isset($splitcontents[8]) ? $val8 = trim($splitcontents[8]) : $val8 = 'null';

              if (substr($val2, -1)=='-') { $val2 = trim(substr($val2, -1)).trim(substr($val2, 0, strlen($val2)-1)); }
              if (substr($val3, -1)=='-') { $val3 = trim(substr($val3, -1)).trim(substr($val3, 0, strlen($val3)-1)); }
              if (substr($val4, -1)=='-') { $val4 = trim(substr($val4, -1)).trim(substr($val4, 0, strlen($val4)-1)); }
              if (substr($val5, -1)=='-') { $val5 = trim(substr($val5, -1)).trim(substr($val5, 0, strlen($val5)-1)); }
              if (substr($val6, -1)=='-') { $val6 = trim(substr($val6, -1)).trim(substr($val6, 0, strlen($val6)-1)); }
              if (substr($val7, -1)=='-') { $val7 = trim(substr($val7, -1)).trim(substr($val7, 0, strlen($val7)-1)); }
              if (substr($val8, -1)=='-') { $val8 = trim(substr($val8, -1)).trim(substr($val8, 0, strlen($val8)-1)); }

              $db = DB::table('cash')->where('BANK_DOC',$val5)->where('DATE', date("Y-m-d", strtotime($val6)) )->count();
              if( $db == 0 ){
                  $sql = "insert ignore into cash (
                          `ID`,
                          `COLLECTOR_CODE`,
                          `CUSTOMER`,
                          `CUSTOMER_NAME`,
                          `CURRENCY`,
                          `AMOUNT`,
                          `BANK_DOC`,
                          `DATE`,
                          `HOUSE_BANK`,
                          `PEMBAYARAN`,
                          `DATELOAD`
                      )values (
                        NULL,
                        '".$val0."',
                        '".$val1."',
                        '".$val2."',
                        '".$val3."',
                        '".($val4)."',
                        '".$val5."',
                        '".date("Y-m-d", strtotime($val6))."',
                        '".$val7."',
                        '".$val8."',
                        '".date('Y-m-d',$now).date(" H:i:s" )."'
                      );";
                $tr   = DB::insert($sql);
                echo "Insert <br>";
              }else{
                $db = DB::table('cash')->where('BANK_DOC',$val5)
                                      ->where('DATE', date("Y-m-d", strtotime($val6)) )
                                      ->update(['AMOUNT' => $val4 ]);
                echo "Update <br>";
              }
              
          break;
          //========================================= HUTANG LC ===============================
          case 'LC':
          case 'lc':
              $delimiter = "|";
              $splitcontents = explode($delimiter, $teks);

              isset($splitcontents[0]) ? $val0 = trim($splitcontents[0]) : $val0 = 'null';
              isset($splitcontents[1]) ? $val1 = trim($splitcontents[1]) : $val1 = 'null';
              isset($splitcontents[2]) ? $val2 = trim($splitcontents[2]) : $val2 = 'null';
              isset($splitcontents[3]) ? $val3 = trim($splitcontents[3]) : $val3 = 'null';
              isset($splitcontents[4]) ? $val4 = trim($splitcontents[4]) : $val4 = 'null';
              isset($splitcontents[5]) ? $val5 = trim($splitcontents[5]) : $val5 = 'null';
              isset($splitcontents[6]) ? $val6 = trim($splitcontents[6]) : $val6 = 'null';
              isset($splitcontents[7]) ? $val7 = trim($splitcontents[7]) : $val7 = 'null';
              isset($splitcontents[8]) ? $val8 = trim($splitcontents[8]) : $val8 = 'null';
              isset($splitcontents[9]) ? $val9 = trim($splitcontents[9]) : $val9 = 'null';
              isset($splitcontents[10]) ? $val10 = trim($splitcontents[10]) : $val10 = 'null';
              isset($splitcontents[11]) ? $val11 = trim($splitcontents[11]) : $val11 = 'null';
              isset($splitcontents[12]) ? $val12 = trim($splitcontents[12]) : $val12 = 'null';

              if (substr($val2, -1)=='-') { $val2 = trim(substr($val2, -1)).trim(substr($val2, 0, strlen($val2)-1)); }
              if (substr($val3, -1)=='-') { $val3 = trim(substr($val3, -1)).trim(substr($val3, 0, strlen($val3)-1)); }
              if (substr($val4, -1)=='-') { $val4 = trim(substr($val4, -1)).trim(substr($val4, 0, strlen($val4)-1)); }
              if (substr($val5, -1)=='-') { $val5 = trim(substr($val5, -1)).trim(substr($val5, 0, strlen($val5)-1)); }
              if (substr($val6, -1)=='-') { $val6 = trim(substr($val6, -1)).trim(substr($val6, 0, strlen($val6)-1)); }
              if (substr($val7, -1)=='-') { $val7 = trim(substr($val7, -1)).trim(substr($val7, 0, strlen($val7)-1)); }
              if (substr($val8, -1)=='-') { $val8 = trim(substr($val8, -1)).trim(substr($val8, 0, strlen($val8)-1)); }
              if (substr($val9, -1)=='-') { $val9 = trim(substr($val9, -1)).trim(substr($val9, 0, strlen($val9)-1)); }
              if (substr($val10, -1)=='-') { $val10 = trim(substr($val10, -1)).trim(substr($val10, 0, strlen($val10)-1)); }
              if (substr($val11, -1)=='-') { $val11 = trim(substr($val11, -1)).trim(substr($val11, 0, strlen($val11)-1)); }
              if (substr($val12, -1)=='-') { $val12 = trim(substr($val12, -1)).trim(substr($val12, 0, strlen($val12)-1)); }

              $sql = "insert ignore into hutang_lc (
                        `ID`,
                        `VENDOR`,
                        `VENDOR_NAME`,
                        `DOCUMENT_NUMBER`,
                        `GL_ACCOUNT`,
                        `POSTING_DATE`,
                        `DOCUMENT_DATE`,
                        `REFERENCE`,
                        `NET_DUE_DATE`,
                        `AMOUNT_IN_DOC_CURR`,
                        `DOCUMENT_CURRENCY`,
                        `LOCAL_CURRENCY`,
                        `LOCAL_CURRENCY2`,
                        `TEXT`,
                        `DATELOAD`
                    )values (
                      NULL,
                      '".$val0."',
                      '".$val1."',
                      '".$val2."',
                      '".$val3."',
                      '".date("Y-m-d", strtotime($val4))."',
                      '".date("Y-m-d", strtotime($val5))."',
                      '".$val6."',
                      '".date("Y-m-d", strtotime($val7))."',
                      '".$val8."',
                      '".$val9."',
                      '".$val10."',
                      '".$val11."',
                      '".$val12."',
                      '".date('Y-m-d',$now).date(" H:i:s" )."'
                    );";
            $tr   = DB::insert($sql);
          break;

          //========================================= MARGIN ===============================
          case 'Margin':
          case 'margin':
              $delimiter = "|";
              $splitcontents = explode($delimiter, $teks);

              isset($splitcontents[0]) ? $val0 = $splitcontents[0] : $val0 = 'null';
              isset($splitcontents[1]) ? $val1 = $splitcontents[1] : $val1 = 'null';
              isset($splitcontents[2]) ? $val2 = trim($splitcontents[2]) : $val2 = 'null';
              isset($splitcontents[3]) ? $val3 = trim($splitcontents[3]) : $val3 = 'null';
              isset($splitcontents[4]) ? $val4 = trim($splitcontents[4]) : $val4 = 'null';
              isset($splitcontents[5]) ? $val5 = trim($splitcontents[5]) : $val5 = 'null';
              isset($splitcontents[6]) ? $val6 = trim($splitcontents[6]) : $val6 = 'null';
              isset($splitcontents[7]) ? $val7 = trim($splitcontents[7]) : $val7 = 'null';
              isset($splitcontents[8]) ? $val8 = trim($splitcontents[8]) : $val8 = $lastupdate ;
              isset($splitcontents[9]) ? $val9 = trim($splitcontents[9]) : $val9 = '';
              isset($splitcontents[10]) ? $val10 = trim($splitcontents[10]) : $val10 = '';
              isset($splitcontents[11]) ? $val11 = trim($splitcontents[11]) : $val11 = '';
              isset($splitcontents[12]) ? $val12 = trim($splitcontents[12]) : $val12 = '';
              isset($splitcontents[13]) ? $val13 = trim($splitcontents[13]) : $val13 = '';

              if (substr($val2, -1)=='-') { $val2 = trim(substr($val2, -1)).trim(substr($val2, 0, strlen($val2)-1)); }
              if (substr($val3, -1)=='-') { $val3 = trim(substr($val3, -1)).trim(substr($val3, 0, strlen($val3)-1)); }
              if (substr($val4, -1)=='-') { $val4 = trim(substr($val4, -1)).trim(substr($val4, 0, strlen($val4)-1)); }
              if (substr($val5, -1)=='-') { $val5 = trim(substr($val5, -1)).trim(substr($val5, 0, strlen($val5)-1)); }
              if (substr($val6, -1)=='-') { $val6 = trim(substr($val6, -1)).trim(substr($val6, 0, strlen($val6)-1)); }
              if (substr($val7, -1)=='-') { $val7 = trim(substr($val7, -1)).trim(substr($val7, 0, strlen($val7)-1)); }
              if (substr($val8, -1)=='-') { $val8 = trim(substr($val8, -1)).trim(substr($val8, 0, strlen($val8)-1)); }
              if (substr($val9, -1)=='-') { $val9 = trim(substr($val9, -1)).trim(substr($val9, 0, strlen($val9)-1)); }
              if (substr($val10, -1)=='-') { $val10 = trim(substr($val10, -1)).trim(substr($val10, 0, strlen($val10)-1)); }
              if (substr($val11, -1)=='-') { $val11 = trim(substr($val11, -1)).trim(substr($val11, 0, strlen($val11)-1)); }
              if (substr($val12, -1)=='-') { $val12 = trim(substr($val12, -1)).trim(substr($val12, 0, strlen($val12)-1)); }
              if (substr($val13, -1)=='-') { $val13 = trim(substr($val13, -1)).trim(substr($val13, 0, strlen($val13)-1)); }

              $tanggal = date('Y-m-d', strtotime(str_replace(".", "-", $val8)));

              $sql = "insert ignore into kontribusi_margin (
                        `id`,
                        `tanggal`,
                        `matrial`,
                        `description`,
                        `sales_value_idr`,
                        `sales_value_usd`,
                        `calculated_value_idr`,
                        `calculated_value_usd`,
                        `value_idr`,
                        `value_usd`,
                        `billing_number`,
                        `billing_item`,
                        `quantity`,
                        `uom`,
                        `dist`,
                        `datefile`,
                        `dateload` )
                      values (
                        null,
                        '".$tanggal."',
                        '".$val0."',
                        '".$val1."',
                        '".($val2)."',
                        '".($val3)."',
                        '".($val4)."',
                        '".($val5)."',
                        '".($val6)."',
                        '".($val7)."',
                        '".$val9."',
                        '".$val10."',
                        '".($val11)."',
                        '".$val12."',
                        '".$val13."',
                        '".date('Y-m-d',$now).date(' H:i:s')."',
                        '".date('Y-m-d H:i:s')."'
                        );";
              $tr   = DB::insert($sql);
          break;

          //========================================= FINISH GOODS===============================
          case 'WR':
          case 'CR':
          case 'HR':
          case 'HRPO':
          case 'wr':
          case 'cr':
          case 'hr':
          case 'hrpo':
              $id='';
              if (($tabel=='HR') || ($tabel=='hr')) {
                  $id = '1';
              } elseif (($tabel=='CR')||($tabel=='cr')) {
                  $id = '2';
              } elseif (($tabel=='HRPO')||($tabel=='hrpo')) {
                  $id = '3';
              } elseif (($tabel=='WR')||($tabel=='wr')) {
                  $id = '4';
              }
              $delimiter = "|";
              $splitcontents = explode($delimiter, $teks);

              isset($splitcontents[0]) ? $val0 = $splitcontents[0] : $val0 = 'null';
              isset($splitcontents[1]) ? $val1 = $splitcontents[1] : $val1 = 'null';
              isset($splitcontents[2]) ? $val2 = $splitcontents[2] : $val2 = 'null';
              isset($splitcontents[3]) ? $val3 = $splitcontents[3] : $val3 = 'null';
              isset($splitcontents[4]) ? $val4 = $splitcontents[4] : $val4 = 'null';
              isset($splitcontents[5]) ? $val5 = $splitcontents[5] : $val5 = 'null';
              isset($splitcontents[6]) ? $val6 = $splitcontents[6] : $val6 = 'null';
              isset($splitcontents[7]) ? $val7 = $splitcontents[7] : $val7 = 'null';
              isset($splitcontents[8]) ? $val8 = $splitcontents[8] : $val8 = 'null';

              $sql = "insert ignore into finishgoods values (
                      '".$id."',
                      '".$lastupdate."',
                      '".$val0."',
                      '".$val1."',
                      '".($val2)."',
                      '".($val3)."',
                      '".($val4)."',
                      '".($val5)."',
                      '".($val6)."',
                      '".($val7)."',
                      '".($val8)."',
                      '".$lastuptime."'
                      )";

              $tr   = DB::insert($sql);
          break;

          //========================================= CARGO DAN RTS ===============================
          case 'StockSO':
          case 'stockso':
              $delimiter = "|";
              $splitcontents = explode($delimiter, $teks);
              $tgl = explode("/", $splitcontents[4]);
              isset($splitcontents[0]) ? $val0 = $splitcontents[0] : $val0 = 'null';
              isset($splitcontents[1]) ? $val1 = $splitcontents[1] : $val1 = 'null';
              isset($splitcontents[2]) ? $val2 = $splitcontents[2] : $val2 = 'null';
              isset($splitcontents[3]) ? $val3 = $splitcontents[3] : $val3 = 'null';
              isset($splitcontents[4]) ? $val4 = $splitcontents[4] : $val4 = 'null';
              isset($splitcontents[5]) ? $val5 = $splitcontents[5] : $val5 = 'null';
              isset($splitcontents[6]) ? $val6 = $splitcontents[6] : $val6 = 'null';
              isset($splitcontents[7]) ? $val7 = $splitcontents[7] : $val7 = 'null';
              isset($splitcontents[8]) ? $val8 = $splitcontents[8] : $val8 = 'null';
              isset($splitcontents[9]) ? $val9 = $splitcontents[9] : $val9 = 'null';
              isset($splitcontents[10]) ? $val10 = $splitcontents[10] : $val10 = 'null';

              if ($val4=='00000000') {
                  $val4='19010101';
              }
              if ($val7=='00000000') {
                  $val7='19010101';
              }
              $sql = "insert ignore into rtscargos values (
                      '".$val0."',
                      '".$val1."',
                      '".($val2)."',
                      '".$this->toNumber($val3)."',
                      '".($val4)."',
                      '".($val5)."',
                      '".($val6)."',
                      '".($val7)."',
                      '".($val8)."',
                      '".($val9)."',
                      '".($val10)."',
                      '".$lastupdate."',
                      '".$lastuptime."'
                      )";
              $tr   = DB::insert($sql);
          break;
        }
    }

    public function getshipment($tgl = null)
    {
        $dayofmonth = date('d');
        $dateofmonth = array();
        for ($i=0; $i < $dayofmonth; $i++) { 
          $dateof = strtotime( date('Y-m-').($i+1) );
          array_push($dateofmonth, date('Y-m-d',$dateof));
        }

        $date = isset($tgl)?$tgl:date('Y-m-d');
        $first_date = date("Y-m-01", strtotime($date));
        $last_date = date("Y-m-t", strtotime($date));

        $delete = DB::table('shipments')
                              ->where('shipment_date','>=',$first_date)
                              ->where('shipment_date','<=',$last_date)->delete();
                              
        foreach ($dateofmonth as $key => $value_date) {
          $eis_shipment = DB::connection('mysql_eis')->table('shipment')->where('shipment_date','=',$value_date);
          if( $eis_shipment->exists() ){
            foreach ($eis_shipment->get() as $key => $value) {
              DB::table('shipments')->insert(
                [
                    'shipment_date' => $value->shipment_date,
                    'hr_dom'        => $value->hr_dom,
                    'hrpo_dom'      => $value->hrpo_dom,
                    'cr_dom'        => $value->cr_dom,
                    'wr_dom'        => $value->wr_dom,
                    'bs_dom'        => $value->bs_dom,
                    'hr_exp'        => $value->hr_exp,
                    'hrpo_exp'      => $value->hrpo_exp,
                    'cr_exp'        => $value->cr_exp,
                    'wr_exp'        => $value->wr_exp,
                    'shipment_update' => $value->shipment_update
                ]
              );
            }
          }else{
            DB::table('shipments')->insert(
              [
                  'shipment_date' => $value_date,
                  'hr_dom'        => 0,
                  'hrpo_dom'      => 0,
                  'cr_dom'        => 0,
                  'wr_dom'        => 0,
                  'bs_dom'        => 0,
                  'hr_exp'        => 0,
                  'hrpo_exp'      => 0,
                  'cr_exp'        => 0,
                  'wr_exp'        => 0,
                  'shipment_update' => date('Y-m-d H:i:s')
              ]
            );
          }
        }

        $count = DB::table('shipments')
                      ->where('shipment_date','>=',$first_date)
                      ->where('shipment_date','<=',$last_date)->count();
        if($count){
            DB::table('log_down')->insert(
              [
                'tgl' => date('Y-m-d H:i:s'),
                'isinya' =>'Download Shipment EIS',
                'stat' => '1'
              ]
            );
        } 
        return $count;
    }

    public function getdatasap()
    {
        $nama;
        $tanggal;
        $readdir = './public/uploads/';
        // $movedir = "/mnt/winnt/archive/";
        $arfile  = scandir($readdir);

        foreach ($arfile as $arsip) {
            if ($arsip!='.' && $arsip!='..') {
                $prefix=explode('_', $arsip);
                // $kode = array('Margin', 'margin', 'StockSO', 'CR', 'cr', 'WR', 'wr', 'hr', 'HR', 'HRPO', 'hrpo');
                $kode = array('margin','stockso','cr','wr','hr','hrpo','lc','cash','budget&actual','saldobank','hutangkmk','stock','zps7010');

                if (in_array(strtolower($prefix[0]), $kode)) {
                    
                    $file_handle = fopen($readdir.$arsip, "rb");
                    $i = 1;

                    while (!feof($file_handle)) {
                        $line_of_text = fgets($file_handle);
                        if ($i>1) {
                            if (strlen($line_of_text)>0) {
                                if( strtolower($prefix[0]) == 'zps7010'){
                                  $hsl = $this->tulisfile(strtolower($prefix[0]), $line_of_text, $prefix[1]);
                                }
                            }
                        }
                        $i++;
                    }
                    fclose($file_handle);


                    //die
                    // copy($readdir.$arsip, $movedir.$arsip);
                    // $tr = DB::table('log_down')->insert(
                    //     [
                    //         'isinya'	=> 'Proses Download File '.$arsip,
                    //         'stat'		=> '1'
                    //     ]
                    // );
                    // unlink($readdir.$arsip);
                }
            }
        }

        set_time_limit(60);
        $this->kalkulasi_hurangLC();
        $this->kalkulasi_saldoBank();

    }

    public function kalkulasi_hurangLC()
    {
        $hutang_lc = DB::table('hutang_lc')
                    ->select( DB::RAW('DATE_FORMAT(DATELOAD,"%Y-%m-%d") AS TANGGAL'),
                              'DOCUMENT_CURRENCY',
                              DB::RAW('SUM(AMOUNT_IN_DOC_CURR) AS VALUE') )
                    ->groupBy('DOCUMENT_CURRENCY',DB::RAW('DATE_FORMAT(DATELOAD,"%Y-%m-%d")') )
                    ->get();

        foreach ($hutang_lc as $key => $value) {
            $daily_report = DB::table('daily_report')
                            ->where('TANGGAL',$value->TANGGAL)
                            ->where('TAG_NAME','HUTANG_LC_'.$value->DOCUMENT_CURRENCY)
                            ->count();
            if($daily_report == 0 ){
              DB::table('daily_report')->insert(
                  ['TANGGAL' => $value->TANGGAL,
                  'VALUE' => $value->VALUE,
                  'TAG_NAME' => 'HUTANG_LC_'.$value->DOCUMENT_CURRENCY,
                  'CREATOR'=>'SYSTEM']
              );
            }
        }
    }
    public function kalkulasi_cash()
    {
        $cash = DB::table('cash')
                    ->select( DB::RAW('@d:= DATE_FORMAT(DATELOAD,"%Y-%m-%d") AS TANGGAL'),
                              'CURRENCY',
                              DB::RAW('SUM(AMOUNT) AS `VALUE`') )
                    ->groupBy('CURRENCY',DB::RAW('@d'))
                    ->get();
        foreach ($cash as $key => $value) {
            $daily_report = DB::table('daily_report')
                            ->where('TANGGAL',$value->TANGGAL)
                            ->where('TAG_NAME','CASH_'.$value->CURRENCY)
                            ->count();
            if($daily_report == 0 ){
              DB::table('daily_report')->insert(
                  ['TANGGAL' => $value->TANGGAL,
                  'VALUE' => $value->VALUE,
                  'TAG_NAME' => 'CASH_'.$value->CURRENCY,
                  'CREATOR'=>'SYSTEM']
              );
            }
        }
    }
    public function kalkulasi_saldoBank()
    { 
        $data = DB::table('saldo_bank')
                      ->select( DB::RAW('SUM(ENDING_BALANCE) as ENDING_BALANCE'),'CURRENCY','BANK_NAME','DATEFILE' )
                      ->groupBy('CURRENCY','DATEFILE')
                      ->get();

        foreach ($data as $key => $value) {
            $saldo_bank = DB::table('daily_report')
                            ->where('TANGGAL',$value->DATEFILE)
                            ->where('TAG_NAME','SALDO_BANK_'.$value->CURRENCY)
                            ->count();

            if($saldo_bank == 0 ){
              DB::table('daily_report')->insert(
                  ['TANGGAL' => $value->DATEFILE,
                  'VALUE' => $value->ENDING_BALANCE,
                  'TAG_NAME' => 'SALDO_BANK_'.$value->CURRENCY,
                  'CREATOR'=>'SYSTEM']
              );
            }

        }
    }
    public function hutang_kmk()
    { 
        $data = DB::table('hutang_kmk')
                      ->select( DB::RAW('SUM(amount) as amount'),DB::RAW('DATE_FORMAT(timeload,"%Y-%m-%d") as tanggal'),'gl_account','assignment','document_number','posting_date','document_date','currency','text' )
                      ->groupBy('currency',DB::RAW('DATE_FORMAT(timeload,"%Y-%m-%d")') )
                      ->get();

        foreach ($data as $key => $value) {
            $saldo_bank = DB::table('daily_report')
                            ->where('TANGGAL',$value->tanggal)
                            ->where('TAG_NAME','HUTANG_KMK_'.$value->currency)
                            ->count();

            if($saldo_bank == 0 ){
              DB::table('daily_report')->insert(
                  ['TANGGAL' => $value->tanggal,
                  'VALUE' => $value->amount,
                  'TAG_NAME' => 'HUTANG_KMK_'.$value->currency,
                  'CREATOR'=>'SYSTEM']
              );
            }

        }
    }

    public function testMenu(Request $request)
    {
        return $request->data_group;
    }


}
