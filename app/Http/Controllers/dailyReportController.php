<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class dailyReportController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }
    public function index(Request $request)
    {
        $data_group = $request->get('data_group');
        $data_menu  = $request->get('data_menu');
        $now        = strtotime(date('Y-m-d'));
        $tanggal    = date('d/m/Y',strtotime('-1 day',$now));
        $showKurs   = $this->showKurs();
        return view(
            'finance.dailyReport',
            [   'data_group'=>$data_group,
                'data_menu'=>$data_menu,
                'tanggal'=>$tanggal,
                'kurs'  => $showKurs,
            ]
        );
    }
    public function show($TANGGAL = NULL )
    {
        $now  = strtotime(date('Y-m-d'));
        $kode = array('HUTANG_LC_IDR','HUTANG_LC_USD','HUTANG_KMK_USD','HUTANG_KMK_IDR',
                      'SALDO_BANK_IDR','SALDO_BANK_USD','SALDO_BANK_EUR'
                    );
        $ret  = array();
        $TANGGAL_VAL = '';
        $TANGGAL_X = '';
        $FISRT_DATE = '';

        foreach ($kode as $key => $value) {

          if($value == 'SALDO_BANK_IDR' || $value == 'SALDO_BANK_USD'|| $value == 'SALDO_BANK_EUR'){

            if($TANGGAL == NULL){
                $TANGGAL_X = date('Y-m-d');
            }else{
                $TANGGAL_X = $TANGGAL;
            }
            $kurs_usd = $this->cekKurs('USD',$TANGGAL_X);
            $kurs_eur = $this->cekKurs('EUR',$TANGGAL_X);

            $data = DB::table('daily_report')
                        ->where('TANGGAL',$TANGGAL_X)
                        ->where('TAG_NAME',$value);

          }else{
            if($TANGGAL == NULL){
                //kurangi satu hari dari tanggal sekarang
                $TANGGAL_VAL = date("Y-m-d",strtotime('-1 day', $now ) );
            }else{
                //kurangi satu hari dari tanggal yang dipilih
                $xtime = strtotime($TANGGAL);
                $TANGGAL_VAL = date("Y-m-d",strtotime('-1 day', $xtime ) );
            }
            $kurs_usd = $this->cekKurs('USD',$TANGGAL_VAL);
            $kurs_eur = $this->cekKurs('EUR',$TANGGAL_VAL);

            $data = DB::table('daily_report')
                        ->where('TANGGAL',$TANGGAL_VAL)
                        ->where('TAG_NAME',$value);
          }

          // cek data jika lebih dari nol
          if($data->count() > 0 ){

              foreach ($data->get() as $key => $valData) {
                array_push($ret, array(
                    'TANGGAL'=> $valData->TANGGAL,
                    'TAG_NAME'=> $valData->TAG_NAME,
                    'VALUE'=> $valData->VALUE,
                    'KURS_USD' => $kurs_usd,
                    'KURS_EUR' => $kurs_eur
                    )
                );
              }

          }else{
            //jika data pada tanggal yg dipilih kosong maka tampilka data terahir
            if($value == 'SALDO_BANK_IDR' || $value == 'SALDO_BANK_USD'|| $value == 'SALDO_BANK_EUR'){
              $TAG = 'SALDO_BANK';
            }else if($value == 'HUTANG_LC_IDR' || $value == 'HUTANG_LC_USD'){
              $TAG = 'HUTANG_LC';
            }else if($value == 'HUTANG_KMK_IDR' || $value == 'HUTANG_KMK_USD'){
              $TAG = 'HUTANG_KMK';
            }

            $data = DB::table('daily_report')->where('TAG_NAME','LIKE','%'.$TAG.'%')->orderBy('TANGGAL','DESC')->limit(1);
            foreach ($data->get() as $key => $valData) {
              $TAG_TGL = $valData->TANGGAL;        
            }

            $datax = DB::table('daily_report')
                          ->where('TANGGAL',$TAG_TGL)
                          ->where('TAG_NAME',$value);

            if($datax->count() > 0 ){
                foreach ($datax->get() as $key => $valDatax) {
                  array_push($ret, array(
                      'TANGGAL'=> $valDatax->TANGGAL,
                      'TAG_NAME'=> $valDatax->TAG_NAME,
                      'VALUE'=> $valDatax->VALUE,
                      'KURS_USD' => $kurs_usd,
                      'KURS_EUR' => $kurs_eur
                      )
                  );
                }
            }else{
              array_push($ret, array(
                  'TANGGAL'=> $TAG_TGL,
                  'TAG_NAME'=> $value,
                  'VALUE'=> 0,
                  'KURS_USD' => 1,
                  'KURS_EUR' => 1
                  )
              );
            }
            
          }

        }
        return $ret;
    }
    public function showCash($TANGGAL)
    {
      $ret    = array();
      $date   = strtotime($TANGGAL);
      $fisrt  = date("Y-m-01",$date);
      $last   = date("Y-m-d",strtotime('-1 day',$date));

      $nilUSD = '';
      $nilIDR = '';
      $nilEUR = '';

      $data   = DB::table('cash')
                    ->select('CURRENCY',DB::RAW('SUM(AMOUNT) AS AMOUNT'),'DATE')
                    ->whereBetween('date', [$fisrt, $last])
                    ->groupBy('CURRENCY');

      if($data->count() > 0){
          $val_data = $data;
      }else{
        // jika pada tanggal sekarang tidak ada data, maka cari data pada bulan kemarin
        $fisrt  = date("Y-m-01",strtotime('-1 month',$date) );
        $last   = date("Y-m-t",strtotime('-1 month',$date) );
        $val_data = DB::table('cash')
                        ->select('CURRENCY',DB::RAW('SUM(AMOUNT) AS AMOUNT'),'DATE')
                        ->whereBetween('date', [$fisrt, $last])
                        ->groupBy('CURRENCY');
      }

      foreach ($val_data->get() as $key => $value) {

        if($value->CURRENCY == 'USD'){
          $nilUSD = $value->AMOUNT;
        }
        if($value->CURRENCY == 'IDR'){
          $nilIDR = $value->AMOUNT;
        }
        if($value->CURRENCY == 'EUR'){
          $nilEUR = $value->AMOUNT;
        }

      }

      //equavalen kan
      $CASH_IDR = $nilIDR ? $nilIDR+( (int)$nilUSD*$this->cekKurs('USD',$last) )+( (int)$nilEUR*$this->cekKurs('EUR',$last) ):0;
      $CASH_USD = $CASH_IDR ? $CASH_IDR / $this->cekKurs('USD',$last): 0 ;
      $CASH_EUR = $CASH_IDR ? $CASH_IDR / $this->cekKurs('EUR',$last): 0 ;

      array_push($ret, 
          array(
            'TANGGAL'=> $last,
            'TAG_NAME'=> 'CASH_IDR',
            'VALUE'=> $CASH_IDR
            ),
          array(
            'TANGGAL'=> $last,
            'TAG_NAME'=> 'CASH_USD',
            'VALUE'=> $CASH_USD
          ),
          array(
            'TANGGAL'=> $last,
            'TAG_NAME'=> 'CASH_EUR',
            'VALUE'=> $CASH_EUR
          )
      );

      return $ret;
    }
    public function cekKurs($mata_uang = 'USD',$tanggal = null ) 
    {
      $tanggal = $tanggal?$tanggal:date('Y-m-d');
      $ret = DB::table('kurs_bi')->where('MATA_UANG',$mata_uang)->where('TANGGAL',$tanggal);

      if( $ret->count() > 0 ){
        $ret = $ret->get();
        $ret = json_decode($ret);
        $ret = $ret[0]->KURS_TENGAH;
      }else{
        $xtime = strtotime($tanggal);
        $tanggal = date("Y-m-d",strtotime('-1 day', $xtime ) );
        $ret = $this->cekKurs($mata_uang,$tanggal);
      }
      return $ret;
    }
    public function halo()
    {
      $halo = $this->cekKurs('USD','2018-05-30');
      return $halo;
    }
    public function showKurs()
    {
      $ret = DB::table('kurs_bi')->whereIn('MATA_UANG',['USD','EUR'])->orderBy('TANGGAL','DESC')->limit('4')->get();
      return $ret;
    }
    public function getkurs()
    {
        $agent     = 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:17.0) Gecko/20100101 Firefox/17.0';
        $client    =  new \GuzzleHttp\Client();
        $res       =  $client->request('GET', 'https://www.bi.go.id/id/moneter/informasi-kurs/transaksi-bi/Default.aspx',[
                          'headers' => [
                              'User-Agent' => $agent
                          ]
                      ]);
        $result    = $res->getBody();
        
        $data_table = explode('<div id="right-cell">', $result);

        $data_table = explode ('<table class="table1" cellspacing="0" rules="all" border="1" id="ctl00_PlaceHolderMain_biWebKursTransaksiBI_GridView1" style="border-collapse:collapse;">',$data_table[1]);
        
        $data_table = explode ('</table>', $data_table[1]);

        $dom = new \DOMDocument();
        $html = $data_table[0];
        @$dom->loadHTML( $html );
        $rows = $dom->getElementsByTagName('tr');
        $counter = 0;

        // Loop each rows
        foreach( $rows as $row ) {
            if( !empty( $row->nodeValue ) ) {
              // Loop each columns
                foreach( $row->childNodes as $column ) {
                  if ( !empty($column->nodeValue) ) {
                    $data_kurs[$counter][] = $column->nodeValue;
                  }
                }
                $counter++;
            }
        }

        //get date kurs bi
        $data_date  = explode('<span id="ctl00_PlaceHolderMain_biWebKursTransaksiBI_lblUpdate">', $result);
        $data_date  = explode ('</span>', $data_date[1]);
        $date       = str_replace(' ','-',$data_date[0]);
        $arr        = explode('-',$date);
        $lastUpdate ='';
        
        switch ($arr[1]) {
        case 'Januari':
          $lastUpdate = $arr[2].'-01-'.$arr[0];
          break;
        case 'Februari':
          $lastUpdate = $arr[2].'-02-'.$arr[0];
          break;
        case 'Maret':
          $lastUpdate = $arr[2].'-03-'.$arr[0];
          break;
        case 'April':
          $lastUpdate = $arr[2].'-04-'.$arr[0];
          break;
        case 'Mei':
          $lastUpdate = $arr[2].'-05-'.$arr[0];
          break;
        case 'Juni':
            $lastUpdate = $arr[2].'-06-'.$arr[0];
          break;
        case 'Juli':
          $lastUpdate = $arr[2].'-07-'.$arr[0];
          break;
        case 'Agustus':
          $lastUpdate = $arr[2].'-08-'.$arr[0];
          break;
        case 'September':
          $lastUpdate = $arr[2].'-09-'.$arr[0];
          break;
        case 'Oktober':
          $lastUpdate = $arr[2].'-10-'.$arr[0];
          break;
        case 'November':
          $lastUpdate = $arr[2].'-11-'.$arr[0];
          break;
        case 'Desember':
          $lastUpdate = $arr[2].'-012-'.$arr[0];
          break;
        }

        //insert to table kurs_bi
        $count = DB::table('kurs_bi')->where('TANGGAL',$lastUpdate)->count();

        if($count == 0){
            foreach ($data_kurs as $key => $value) {
                if($key <> 0){
                    DB::table('kurs_bi')->insert(
                        [
                          'TANGGAL'   => $lastUpdate,
                          'MATA_UANG' => $value[1],
                          'NILAI'     => $this->toNumber($value[2]),
                          'KURS_JULA' => $this->toNumber($value[3]),
                          'KURS_BELI' => $this->toNumber($value[4]),
                          'KURS_TENGAH' => ( $this->toNumber($value[3])+$this->toNumber($value[4]) )/2
                        ]
                    );
                }
            }
            echo "INSERT KURS FROM https://www.bi.go.id/id/moneter/informasi-kurs/transaksi-bi";
        }

    }
    public function toNumber($teks)
    {
        $hsl  = str_replace(",", "", $teks);
        // $hsl = str_replace(".", ",", $hsl);
        return $hsl;
    }
    public function chartKurs()
    {
        $category = array();
        $usd = array();
        $eur = array();

        $data = DB::table('kurs_bi')->where('MATA_UANG','USD')->orWhere('MATA_UANG','EUR')->limit(30)->get();
        foreach ($data as $key => $value) {
          if($value->MATA_UANG == 'USD'){
            array_push($category, array('label'=>date('d',strtotime($value->TANGGAL) ) ) );
            array_push($usd, array('value'=>$value->KURS_TENGAH,'displayValue'=>number_format($value->KURS_TENGAH,2)) );
          }
          if($value->MATA_UANG == 'EUR'){
            array_push($eur, array('value'=>$value->KURS_TENGAH,'displayValue'=>number_format($value->KURS_TENGAH,2)) );
          }
          
        }
        $return = array(
          'caption' => "Month : ".date('F')." - Year : ".date('Y'),
          'category' => $category,
          'dataset' => array(

            array(
              'title'=> 'USD',
              'tickWidth'=> '10',
              'numberPrefix'=> 'Rp. ',
              'divlineDashed'=> '1',
              'dataset'=>array('seriesname' => 'USD','lineThickness'=>'2','data' => $usd)
            ),
            array(
              'title'=> 'EUR',
              'axisOnLeft'=> '0',
              'numDivlines'=> '8',
              'numberPrefix'=> 'Rp. ',
              'tickWidth'=> '10',
              'divlineDashed'=> '1',
              'dataset'=>array('seriesname' => 'EUR','data' => $eur)
            )

          )
        );
        return $return;
    }
    public function chartSaldoBank($tgl)
    {
        $category = array();
        $usd = array();
        $idr = array();
        $eur = array();
        $dateArr = array();

        $x        = strtotime($tgl);
        $day      = date('t',$x)*1;
        $month    = date('Y-m-',$x);

        
        for ($i=0; $i < $day ; $i++) { 
          $date   = $month.($i+1);
          $datex  = strtotime($date);
          array_push($category, array('label'=>date('d',$datex) ) );
          array_push($dateArr, array('label'=>date('Y-m-d',$datex) ) );
        }
        
        foreach ($dateArr as $key => $valueC) {
            $data = DB::table('daily_report')->where('TAG_NAME','SALDO_BANK_IDR')->where('TANGGAL',$valueC['label']);
            if($data->count() != 0){
              foreach ($data->get() as $key => $value) {
                array_push($idr, array('value'=>$value->VALUE,'displayValue'=>number_format($value->VALUE,2)) );
              }
            }else{
              array_push($idr, array('value'=>0,'displayValue'=>number_format(0,2)) );
            }
        }
        foreach ($dateArr as $key => $valueC) {
            $data = DB::table('daily_report')->where('TAG_NAME','SALDO_BANK_USD')->where('TANGGAL',$valueC['label']);
            if($data->count() != 0){
              foreach ($data->get() as $key => $value) {
                array_push($usd, array('value'=>$value->VALUE,'displayValue'=>number_format($value->VALUE,2)) );
              }
            }else{
              array_push($usd, array('value'=>0,'displayValue'=>number_format(0,2)) );
            }
        }
        foreach ($dateArr as $key => $valueC) {
            $data = DB::table('daily_report')->where('TAG_NAME','SALDO_BANK_EUR')->where('TANGGAL',$valueC['label']);
            if($data->count() != 0){
              foreach ($data->get() as $key => $value) {
                array_push($eur, array('value'=>$value->VALUE,'displayValue'=>number_format($value->VALUE,2)) );
              }
            }else{
              array_push($eur, array('value'=>0,'displayValue'=>number_format(0,2)) );
            }
        }

        $return = array(
          'caption' => "Month : ".date('F')." - Year : ".date('Y'),
          'category' => $category,
          'dataset' => array(

            array(
              'title'=> 'SALDO_BANK_IDR',
              'tickWidth'=> '10',
              'numberPrefix'=> 'Rp. ',
              'divlineDashed'=> '1',
              'dataset'=>array('seriesname' => 'SALDO_BANK_IDR','lineThickness'=>'3','data' => $idr)
            ),
            array(
              'title'=> 'SALDO_BANK_USD',
              'axisOnLeft'=> '0',
              'numDivlines'=> '8',
              'numberPrefix'=> '$. ',
              'tickWidth'=> '10',
              'divlineDashed'=> '1',
              'dataset'=>array('seriesname' => 'SALDO_BANK_USD','data' => $usd)
            ),
            array(
              'title'=> 'SALDO_BANK_EUR',
              'axisOnLeft'=> '0',
              'numDivlines'=> '5',
              'numberPrefix'=> '€. ',
              'tickWidth'=> '10',
              'divlineDashed'=> '1',
              'dataset'=>array('seriesname' => 'SALDO_BANK_EUR','data' => $eur)
            )

          )
        );
        return $return;
    }
    public function chartCash($tgl)
    {
        $category = array();
        $usd = array();
        $idr = array();
        $eur = array();
        $dateArr = array();

        $x        = strtotime($tgl);
        $day      = date('t',$x)*1;
        $month    = date('Y-m-',$x);

        
        for ($i=0; $i < $day ; $i++) { 
          $date   = $month.($i+1);
          $datex  = strtotime($date);
          array_push($category, array('label'=>date('d',$datex) ) );
          array_push($dateArr, array('label'=>date('Y-m-d',$datex) ) );
        }
        
        foreach ($dateArr as $key => $valueC) {
            // $data = DB::table('daily_report')->where('TAG_NAME','CASH_IDR')
            //                                 ->where(DB::RAW('DATE_SUB(TANGGAL, INTERVAL 1 DAY) '),$valueC['label']);
            $data = DB::table('daily_report')->where('TAG_NAME','CASH_IDR')->where('TANGGAL',$valueC['label']);
            if($data->count() != 0){
              foreach ($data->get() as $key => $value) {
                array_push($idr, array('value'=>$value->VALUE,'displayValue'=>number_format($value->VALUE,2)) );
              }
            }else{
              array_push($idr, array('value'=>0,'displayValue'=>number_format(0,2)) );
            }
        }
        foreach ($dateArr as $key => $valueC) {
            $data = DB::table('daily_report')->where('TAG_NAME','CASH_USD')->where('TANGGAL',$valueC['label']);
            if($data->count() != 0){
              foreach ($data->get() as $key => $value) {
                array_push($usd, array('value'=>$value->VALUE,'displayValue'=>number_format($value->VALUE,2)) );
              }
            }else{
              array_push($usd, array('value'=>0,'displayValue'=>number_format(0,2)) );
            }
        }
        foreach ($dateArr as $key => $valueC) {
            $data = DB::table('daily_report')->where('TAG_NAME','CASH_EUR')->where('TANGGAL',$valueC['label']);
            if($data->count() != 0){
              foreach ($data->get() as $key => $value) {
                array_push($eur, array('value'=>$value->VALUE,'displayValue'=>number_format($value->VALUE,2)) );
              }
            }else{
              array_push($eur, array('value'=>0,'displayValue'=>number_format(0,2)) );
            }
        }

        $return = array(
          'caption' => "Month : ".date('F')." - Year : ".date('Y'),
          'category' => $category,
          'dataset' => array(

            array(
              'title'=> 'CASH_IDR',
              'tickWidth'=> '10',
              'numberPrefix'=> 'Rp. ',
              'divlineDashed'=> '1',
              'dataset'=>array('seriesname' => 'CASH_IDR','lineThickness'=>'3','data' => $idr)
            ),
            array(
              'title'=> 'CASH_USD',
              'axisOnLeft'=> '0',
              'numDivlines'=> '8',
              'numberPrefix'=> '$. ',
              'tickWidth'=> '10',
              'divlineDashed'=> '1',
              'dataset'=>array('seriesname' => 'CASH_USD','data' => $usd)
            ),
            array(
              'title'=> 'CASH_EUR',
              'axisOnLeft'=> '0',
              'numDivlines'=> '5',
              'numberPrefix'=> '€. ',
              'tickWidth'=> '10',
              'divlineDashed'=> '1',
              'dataset'=>array('seriesname' => 'CASH_EUR','data' => $eur)
            )

          )
        );
        return $return;
    }
    public function chartHutangLc($tgl)
    {
        $category = array();
        $usd      = array();
        $xusd     = array();
        $idr      = array();
        $xidr     = array();
        $eur      = array();
        $dateArr  = array();

        $x        = strtotime($tgl);
        $day      = date('t',$x)*1;
        $month    = date('Y-m-',$x);
        $kurs_usd = '';

        
        for ($i=0; $i < $day ; $i++) { 
          $date   = $month.($i+1);
          $datex  = strtotime($date);
          array_push($category, array('label'=>date('d',$datex) ) );
          array_push($dateArr, array('label'=>date('Y-m-d',$datex) ) );
        }

        foreach ($dateArr as $key => $valueC) {
            $data = DB::table('daily_report')->where('TAG_NAME','HUTANG_LC_IDR')->where('TANGGAL',$valueC['label']);
            if($data->count() != 0){
              foreach ($data->get() as $key => $value) {
                array_push($idr, array('value'=>$value->VALUE,'tanggal'=>$value->TANGGAL ));
              }
            }else{
              array_push($idr, array('value'=>0,'tanggal'=>$value->TANGGAL ));
            }
        }
        foreach ($dateArr as $key => $valueC) {
            $data = DB::table('daily_report')->where('TAG_NAME','HUTANG_LC_USD')->where('TANGGAL',$valueC['label']);
            if($data->count() != 0){
              foreach ($data->get() as $key => $value) {
                array_push($usd, array('value'=>$value->VALUE,'tanggal'=>$value->TANGGAL ));
              }
            }else{
              array_push($usd, array('value'=>0,'tanggal'=>$value->TANGGAL ));
            }
        }

        // format equivalent
        $eusd      = array();
        $eidr      = array();
        foreach ($idr as $key => $value) {
          $kurs_usd = $this->cekKurs('USD', $value['tanggal'] );
          $xidr = $value['value'] + $usd[$key]['value']*$kurs_usd;
          $xusd = $xidr/$kurs_usd;
          array_push($eidr, array('value'=>$xidr,'displayValue'=>number_format($xidr,2)) );
          array_push($eusd, array('value'=>$xusd,'displayValue'=>number_format($xusd,2)) );
        }
        $return = array(
          'caption' => "Month : ".date('F')." - Year : ".date('Y'),
          'category' => $category,
          'dataset' => array(

            array(
              'title'=> 'HUTANG_LC_IDR',
              'tickWidth'=> '10',
              'numberPrefix'=> 'Rp. ',
              'divlineDashed'=> '1',
              'dataset'=>array('seriesname' => 'HUTANG_LC_IDR','lineThickness'=>'2','data' => $eidr)
            ),
            array(
              'title'=> 'HUTANG_LC_USD',
              'axisOnLeft'=> '0',
              'numDivlines'=> '8',
              'numberPrefix'=> '$. ',
              'tickWidth'=> '10',
              'divlineDashed'=> '1',
              'dataset'=>array('seriesname' => 'HUTANG_LC_USD','data' => $eusd)
            )

          )
        );
        return $return;

    }
    public function realisasi_foh(Request $request)
    {
      $data_group = $request->get('data_group');
      $data_menu  = $request->get('data_menu');
      return view(
            'finance.realisasi_foh',
            [   'data_group'=>$data_group,
                'data_menu'=>$data_menu
            ]
        );
    }
}
