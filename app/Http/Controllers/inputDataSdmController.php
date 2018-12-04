<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class inputDataSdmController extends Controller
{
    public function __construct ()
    {
       date_default_timezone_set('Asia/Jakarta');
    }
    public function index(Request $request)
    {
        
        $data_group = $request->get('data_group');
        $data_menu  = $request->get('data_menu');
        $data       = [ 
                        'demografi' => 'Demografi',
                        'mhl'       => 'Man Hour Loss',
                        'kpi'       => 'Pencapaian KPI'
                      ];
        return view('sdm.inputDataSdm',
            [
                'data_group' =>$data_group,
                'data_menu'  => $data_menu,
                'data'  => $data,
            ]
        );
    }
    public function upload(Request $request)
    {

        if($request->data !== 'mhl'){
            $rules = [
                'file' => 'required|file|max:1000|mimes:xlsx,XLSX', // ukuran dihitung dalam KB
                'data' => 'required',
                'tahun' => 'required',
                'berdasarkan' => 'required',
            ];
        }else{
            $rules = [
                'file' => 'required|file|max:1000|mimes:xlsx,XLSX', // ukuran dihitung dalam KB
                'data' => 'required',
                'tahun' => 'required',
            ];
        }

        $customMessages = [
            'max' => 'Ukuran File Lebih dari :max KB',
            'required' => ':attribute Tidak Boleh Kosong.',
            'mimes' => 'File yang di upload harus memiliki tipe xlsx. ',
        ];

        $this->validate($request, $rules, $customMessages);
        
        $uploadedFile = $request->file('file');        
        $path = $uploadedFile->storeAs('public/files/sdm/'.$request->data.'/'.$request->tahun.'/'.$request->berdasarkan, date('Ym').'.xlsx' );

        return $this->store($request->data, $request->tahun, $request->berdasarkan);
    }

    public function store($data,$tahun,$status)
    {
        $inputFileName  = './public/storage/files/sdm/'.$data.'/'.$tahun.'/'.$status.'/'.date('Ym').'.xlsx';
        $spreadsheet    = IOFactory::load($inputFileName);
        $sheetData      = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        
        switch ($data) {
            case 'demografi':
                $msg = $this->demografi($sheetData,$tahun,$status);
                break;

            case 'mhl':
                $msg = $this->mhl($sheetData,$tahun,$status);
                break;
            
            default:
                # code...
                break;
        }
        return redirect()->back()->with('message',$msg);
    }

    public function mhl($sheetData,$tahun,$status)
    {
        $msg = '';
        foreach ($sheetData as $key => $value) {
            if($key > 3){
                $count = DB::table('mhl')->where('tahun',$tahun)->where('kode',$value['A'])->count();
                if( $count == 0){
                    DB::table('mhl')->insert(
                        [ 
                            'kode' => $value['A'],
                            'tahun' => $tahun,
                            'namaunit' => htmlentities($value['B']),
                            'jan_hari_krj' => $value['C'],
                            'jan_jml_kry' => $value['D'],
                            'jan_lost_menit' => $value['E'],
                            'jan_lost_hari' => $value['F'],
                            'feb_hari_krj' => $value['G'],
                            'feb_jml_kry' => $value['H'],
                            'feb_lost_menit' => $value['I'],
                            'feb_lost_hari' => $value['J'],
                            'mar_hari_krj' => $value['K'],
                            'mar_jml_kry' => $value['L'],
                            'mar_lost_menit' => $value['M'],
                            'mar_lost_hari' => $value['N'],
                            'apr_hari_krj' => $value['O'],
                            'apr_jml_kry' => $value['P'],
                            'apr_lost_menit' => $value['Q'],
                            'apr_lost_hari' => $value['R'],
                            'mei_hari_krj' => $value['S'],
                            'mei_jml_kry' => $value['T'],
                            'mei_lost_menit' => $value['U'],
                            'mei_lost_hari' => $value['V'],
                            'jun_hari_krj' => $value['W'],
                            'jun_jml_kry' => $value['X'],
                            'jun_lost_menit' => $value['Y'],
                            'jun_lost_hari' => $value['Z'],
                            'jul_hari_krj' => $value['AA'],
                            'jul_jml_kry' => $value['AB'],
                            'jul_lost_menit' => $value['AC'],
                            'jul_lost_hari' => $value['AD'],
                            'agu_hari_krj' => $value['AE'],
                            'agu_jml_kry' => $value['AF'],
                            'agu_lost_menit' => $value['AG'],
                            'agu_lost_hari' => $value['AH'],
                            'sep_hari_krj' => $value['AI'],
                            'sep_jml_kry' => $value['AJ'],
                            'sep_lost_menit' => $value['AK'],
                            'sep_lost_hari' => $value['AL'],
                            'okt_hari_krj' => $value['AM'],
                            'okt_jml_kry' => $value['AN'],
                            'okt_lost_menit' => $value['AO'],
                            'okt_lost_hari' => $value['AP'],
                            'nov_hari_krj' => $value['AQ'],
                            'nov_jml_kry' => $value['AR'],
                            'nov_lost_menit' => $value['AS'],
                            'nov_lost_hari' => $value['AT'],
                            'des_hari_krj' => $value['AU'],
                            'des_jml_kry' => $value['AV'],
                            'des_lost_menit' => $value['AW'],
                            'des_lost_hari' => $value['AX'],
                            'unit_aktif' => $value['AY'],
                        ]
                    );
                    $msg = "Data berhasil di tambahkan";
                }else{
                    DB::table('MHL')->where('tahun',$tahun)->where('kode',$value['A'])
                    ->update(
                        [ 
                            'namaunit' => htmlentities($value['B']),
                            'jan_hari_krj' => $value['C'],
                            'jan_jml_kry' => $value['D'],
                            'jan_lost_menit' => $value['E'],
                            'jan_lost_hari' => $value['F'],
                            'feb_hari_krj' => $value['G'],
                            'feb_jml_kry' => $value['H'],
                            'feb_lost_menit' => $value['I'],
                            'feb_lost_hari' => $value['J'],
                            'mar_hari_krj' => $value['K'],
                            'mar_jml_kry' => $value['L'],
                            'mar_lost_menit' => $value['M'],
                            'mar_lost_hari' => $value['N'],
                            'apr_hari_krj' => $value['O'],
                            'apr_jml_kry' => $value['P'],
                            'apr_lost_menit' => $value['Q'],
                            'apr_lost_hari' => $value['R'],
                            'mei_hari_krj' => $value['S'],
                            'mei_jml_kry' => $value['T'],
                            'mei_lost_menit' => $value['U'],
                            'mei_lost_hari' => $value['V'],
                            'jun_hari_krj' => $value['W'],
                            'jun_jml_kry' => $value['X'],
                            'jun_lost_menit' => $value['Y'],
                            'jun_lost_hari' => $value['Z'],
                            'jul_hari_krj' => $value['AA'],
                            'jul_jml_kry' => $value['AB'],
                            'jul_lost_menit' => $value['AC'],
                            'jul_lost_hari' => $value['AD'],
                            'agu_hari_krj' => $value['AE'],
                            'agu_jml_kry' => $value['AF'],
                            'agu_lost_menit' => $value['AG'],
                            'agu_lost_hari' => $value['AH'],
                            'sep_hari_krj' => $value['AI'],
                            'sep_jml_kry' => $value['AJ'],
                            'sep_lost_menit' => $value['AK'],
                            'sep_lost_hari' => $value['AL'],
                            'okt_hari_krj' => $value['AM'],
                            'okt_jml_kry' => $value['AN'],
                            'okt_lost_menit' => $value['AO'],
                            'okt_lost_hari' => $value['AP'],
                            'nov_hari_krj' => $value['AQ'],
                            'nov_jml_kry' => $value['AR'],
                            'nov_lost_menit' => $value['AS'],
                            'nov_lost_hari' => $value['AT'],
                            'des_hari_krj' => $value['AU'],
                            'des_jml_kry' => $value['AV'],
                            'des_lost_menit' => $value['AW'],
                            'des_lost_hari' => $value['AX'],
                            'unit_aktif' => $value['AY'],
                        ]
                    );
                    $msg = "Data berhasil di update";
                }
                
            }
        }
        return $msg;
    }
    public function demografi($sheetData,$tahun,$status)
    {
        switch ($status) {
            case 'status':
            case 'golongan':
            case 'pendidikan':
                $msg = $this->demografiGps($sheetData,$tahun,$status);
                break;

            case 'usia':
                $msg = $this->demografiUsia($sheetData,$tahun,$status);
                break;
            
            default:
                # code...
                break;
        }
    }
    // fungsi unttuk input data demografi berdasarkan usia
    public function demografiUsia($sheetData,$tahun,$status)
    {
        $msg = '';
        foreach ($sheetData as $key => $value) {
            if($key > 2){
                $count = DB::table('demografi_usia')->where('tahun',$tahun)->where('id',$value['A'])->count();
                if( $count == 0){
                    DB::table('demografi_usia')->insert(
                        [ 
                            'id' => $value['A'],
                            'tahun' => $tahun,
                            'inti' => $value['B'],
                            'range_usia' => htmlentities( $value['C'] ),
                            'gol_a' => $value['D'],
                            'gol_b' => $value['E'],
                            'gol_c' => $value['F'],
                            'gol_d' => $value['G'],
                            'gol_e' => $value['H'],
                            'gol_f' => $value['I'],
                        ]
                    );
                    $msg = "Data berhasil di tambahkan";
                }else{
                    DB::table('demografi_usia')->where('tahun',$tahun)->where('id',$value['A'])
                    ->update(
                        [ 
                            'inti' => $value['B'],
                            'range_usia' => htmlentities( $value['C'] ),
                            'gol_a' => $value['D'],
                            'gol_b' => $value['E'],
                            'gol_c' => $value['F'],
                            'gol_d' => $value['G'],
                            'gol_e' => $value['H'],
                            'gol_f' => $value['I'],
                        ]
                    );
                    $msg = "Data berhasil di update";
                }
                
            }
        }
        return $msg;
    }

    // fungsi untuk input data demografi berdasarkan golongan/pendidikan/status
    public function demografiGps($sheetData,$tahun,$status)
    {
        $msg = '';
        foreach ($sheetData as $key => $value) {
            if($key > 2){
                $count = DB::table('demografi')->where('tahun',$tahun)->where('part',$status)->where('id',$value['A'])->count();
                
                if($count > 0){
                    // echo $value['A'];
                    DB::table('demografi')->where('tahun',$tahun)->where('part',$status)->where('id',$value['A'])
                    ->update(
                        [ 
                            'deskripsi'=>$value['B'],
                            'des_lama'=>$value['C'],

                            'januari'=>$value['D'],
                            'februari'=>$value['E'],
                            'maret'=>$value['F'],
                            'april'=>$value['G'],
                            'mei'=>$value['H'],

                            'juni'=>$value['I'],
                            'juli'=>$value['J'],
                            'agustus'=>$value['K'],
                            'september'=>$value['L'],
                            'oktober'=>$value['M'],

                            'november'=>$value['N'],
                            'desember'=>$value['O'],
                        ]
                    );
                    $msg = "Data berhasil di update";
                }else{
                    DB::table('demografi')->insert(
                        [ 
                            'id'=>$value['A'],
                            'tahun'=>$tahun,
                            'part'=>$status,
                            'deskripsi'=>$value['B'],
                            'des_lama'=>$value['C'],

                            'januari'=>$value['D'],
                            'februari'=>$value['E'],
                            'maret'=>$value['F'],
                            'april'=>$value['G'],
                            'mei'=>$value['H'],

                            'juni'=>$value['I'],
                            'juli'=>$value['J'],
                            'agustus'=>$value['K'],
                            'september'=>$value['L'],
                            'oktober'=>$value['M'],

                            'november'=>$value['N'],
                            'desember'=>$value['O'],
                        ]
                    );
                    $msg = "Data berhasil di tambahkan";
                }

            }
            
        }
        return $msg;
    }
    
    public function berdasarkan($data = null)
    {
        $ret = '';
        switch ($data) {
            case 'demografi':
                    $ret = ['results'=>
                        [
                            ['id'=>'status','text'=>'Status'],
                            ['id'=>'golongan','text'=>'Golongan'],
                            ['id'=>'pendidikan','text'=>'Pendidikan'],
                            ['id'=>'usia','text'=>'Usia'],
                        ]
                    ];
                break;
            
            case 'kpi':
                    $ret = ['results'=>
                        [
                            ['id'=>'kpi','text'=>'PENCAPAIAN KPI PERUSAHAAN'],
                            ['id'=>'sdm&pu','text'=>'DIREKTORAT SDM & PU'],
                            ['id'=>'shcm','text'=>'SUBDIT HUMAN CAPITAL MANAGEMENT'],
                            ['id'=>'dpm&c','text'=>'DIVISI PERFORMANCE MGT & CORPORATE CULTURE'],
                        ]
                    ];
                break;
            
            default:
                # code...
                break;
        }
        return $ret;
    }
}
