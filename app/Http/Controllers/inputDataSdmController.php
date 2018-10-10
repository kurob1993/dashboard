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
        $data       = ['demografi'=>'Demografi','mhl'=>'Man Hour loss','kpi'=>'Pencapaian KPI'];
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
        $path = $uploadedFile->storeAs('public/files/sdm/'.date('Y').'/'.$request->status, date('Ym').'.xlsx' );

        return redirect('/sdm/input_demografi/store/'.$request->tahun.'/'.$request->status);
    }

    // fungsi untuk input data demografi berdasarkan golongan/pendidikan/status
    public function gps($sheetData,$tahun,$status)
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
                            // 'id'=>$value['A'],
                            // 'tahun'=>$tahun,
                            // 'part'=>$status,
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
    public function store($tahun,$status)
    {
        $inputFileName  = './public/storage/files/sdm/'.date('Y').'/'.$status.'/'.date('Ym').'.xlsx';
        $spreadsheet    = IOFactory::load($inputFileName);
        $sheetData      = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        
        // fungsi untuk input data demografi berdasarkan golongan/pendidikan/status
        

        switch ($status) {
            case 'status':
            case 'golongan':
            case 'pendidikan':
                $msg = $this->gps($sheetData,$tahun,$status);
                break;

            case 'usia':
                $msg = $this->gps($sheetData,$tahun,$status);
                break;
            
            default:
                # code...
                break;
        }
        
        return redirect()->back()->with('message', $msg);
    }
    public function berdasarkan($data = null)
    {
        $ret = '';
        switch ($data) {
            case 'demografi':
                    $ret = ['results'=>
                        [
                            ['id'=>1,'text'=>'status'],
                            ['id'=>2,'text'=>'golongan'],
                            ['id'=>3,'text'=>'pendidikan'],
                            ['id'=>4,'text'=>'usia'],
                        ]
                    ];
                break;
            
            case 'kpi':
                    $ret = ['results'=>
                        [
                            ['id'=>1,'text'=>'PENCAPAIAN KPI PERUSAHAAN'],
                            ['id'=>2,'text'=>'DIREKTORAT SDM & PU'],
                            ['id'=>3,'text'=>'SUBDIT HUMAN CAPITAL MANAGEMENT'],
                            ['id'=>4,'text'=>'DIVISI PERFORMANCE MGT & CORPORATE CULTURE'],
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
