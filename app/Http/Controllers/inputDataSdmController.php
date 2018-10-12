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
        $path = $uploadedFile->storeAs('public/files/sdm/demografi/'.$request->tahun.'/'.$request->berdasarkan, date('Ym').'.xlsx' );

        return redirect('/sdm/input_data_sdm/store/'.$request->data.'/'.$request->tahun.'/'.$request->berdasarkan);
    }

    public function store($data,$tahun,$status)
    {
        $inputFileName  = './public/storage/files/sdm/'.$data.'/'.$tahun.'/'.$status.'/'.date('Ym').'.xlsx';
        $spreadsheet    = IOFactory::load($inputFileName);
        $sheetData      = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        
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
        return redirect()->back()->with('message',$msg);
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
