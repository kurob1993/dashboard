<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Facades\Datatables;
use Validator;
use Carbon\Carbon;

class rakordirController extends Controller
{
   public function __construct ()
    {
       date_default_timezone_set('Asia/Jakarta');
       setlocale(LC_ALL, 'IND');
    }
    //menu input rakordir
    public function index(Request $request)
    {
        $data_group     = $request->get('data_group');
        $data_menu      = $request->get('data_menu');
        return view('rakordir.inputFile',
            [
                'data_group'    =>$data_group,
                'data_menu'     =>$data_menu
            ]
        );
    }
    public function backdrop(Request $request)
    {
        $data_group     = $request->get('data_group');
        $data_menu      = $request->get('data_menu');
        $lastDate       = DB::table('rakordir')->orderBy('date','desc')->take(1)->get();
        $lastDate       = isset($lastDate[0]->date) ? $lastDate[0]->date : NULL;
        $data           = DB::table('rakordir')->where('date',$lastDate)->orderBy('mulai','asc')->get();
        return view('rakordir.backDrop',
            [
                'data_group'    =>$data_group,
                'data_menu'     =>$data_menu,
                'data'          =>$data,
                'lastDate'      => strftime("%A, %d %B %Y",strtotime($lastDate))
            ]
        );
    }
    public function formInput(Request $request)
    {
        $data_group     = $request->get('data_group');
        $data_menu      = $request->get('data_menu');
        return view('rakordir.inputFileForm',
            [
                'data_group'    =>$data_group,
                'data_menu'     =>$data_menu
            ]
        );
    }
    public function upload(Request $request)
    {
        $request->validate([
            // 'file' => 'required|mimes:pdf,PDF|max:5120',
            'file' => 'required',
            'tanggal' => 'required|unique:rakordir,date,null,id,agenda_no,'.$request->agenda_no,
            'no_dokument' => 'required',
            'agenda_no' => 'required|unique:rakordir,agenda_no,null,id,date,'.$request->tanggal,
            'judul' => 'required',
            'presenter' => 'required',
        ]);

        $username      = $request->session()->get('username'); 
        $save = DB::table('rakordir')
            ->insert(
                [
                    'username'  => $username,
                    'date'      => $request->tanggal,
                    'mulai'     => $request->jam_mulai .":". $request->menit_mulai,
                    'keluar'    => $request->jam_keluar .":". $request->menit_keluar,
                    'judul'     => $request->judul,
                    'agenda_no' => $request->agenda_no,
                    'no_dokument' => $request->no_dokument,
                    'presenter' => $request->presenter,
                ]
            );
        if($save){
            $path = NULL;
            $realName = NUll;
            foreach ($request->file as $key => $value) {            
                $uploadedFile  = $value; 
                $path          = $uploadedFile->store( 'public/files/rakordir/'.$username.'/'. $request->tanggal .'/'.$request->agenda_no ) . ";" .$path;
                $realName      = $value->getClientOriginalName() . ";" .$realName;
            }
            $update = DB::table('rakordir')
            ->where('date',$request->tanggal)
            ->where('agenda_no',$request->agenda_no)
            ->update(
                [
                    'file_name' => $realName,
                    'file_path' => str_replace("public/","",$path),
                ]
            );
            return redirect('/rakordir/input_file');
        }
        return Redirect::back()->withErrors(['msg', 'Error']);
        
    }
    public function showUpload(Request $request)
    {
        $username      = $request->session()->get('username');
        $data = DB::table('rakordir')->where('username',$username)->get();
        $ret = [];
        foreach ($data as $key => $value) {
            array_push($ret,[
                'username'=>$value->username,
                'file_name'=>$value->file_name,
                'file_path'=>explode(';',$value->file_path),
                'date'=>date('d-m-Y',strtotime($value->date)) . " <br> ".$value->mulai. " - " . $value->keluar,
                'mulai'=>$value->mulai,
                'keluar'=>$value->keluar,
                'tempat'=>$value->tempat,
                'judul'=>$value->judul,
                'no_dokument'=>$value->no_dokument,
                'agenda_no'=>$value->agenda_no,
                'presenter'=>$value->presenter,
            ]);
        }
        $data = collect($ret);
        return Datatables::of($data)->make(true);
    }
    
    //menu materi rakordir
    public function file(Request $request,$tanggal=null)
    {
        $data_group     = $request->get('data_group');
        $data_menu      = $request->get('data_menu');
        $tanggalx       = null;
        $perbulan       = false;
        $pertanggal     = false;
        $selecTahun     = DB::table('rakordir')
                            ->orderBy('date','desc')
                            ->groupBy(DB::RAW("date_format(date,'%Y')") )->get();
        $tahun          = isset($request->tahun) ? $request->tahun : date('Y');

        if($tanggal){
            if( strlen($tanggal) > 7 ){
                $tanggalx  = $tanggal;
                $data = null;
            }else{
                $data = DB::table('rakordir')->whereRaw("date_format(date,'%m-%Y') = '".$tanggal."'")
                ->groupBy(DB::RAW("date_format(date,'%Y-%m-%d')") )->paginate(12);
                $pertanggal = true;
            }
        }else{
            if(isset($request->cari)){
                $tanggalx  = $request->cari;
                $data = null;
            }else if($tahun){
                $data = DB::table('rakordir')->whereRaw("date_format(date,'%Y') = '".$tahun."'")
                ->groupBy(DB::RAW("date_format(date,'%Y-%m')") )->paginate(12);
                $perbulan = true;
            }
            
        }
        
        // die($data);
        return view('rakordir.materi',
            [
                'data_group' => $data_group,
                'data_menu'  => $data_menu,
                'data'       => $data,
                'tanggal'    => $tanggalx,
                'pertanggal'    => $pertanggal,
                'perbulan'    => $perbulan,
                'selecTahun'    => $selecTahun,
                'tahun'     => $tahun,

            ]
        );

    }
    public function showMateri(Request $request,$tanggal = null)
    {
        
        $data = [];
        $ret  = [];
        if(false === strtotime($tanggal) || $request->cari){
            $data = DB::table('rakordir')
                    ->where('date','like',"%{$request->cari}%")
                    ->orWhere('judul','like',"%{$request->cari}%")
                    ->orWhere('presenter','like',"%{$request->cari}%")
                    ->orWhere('no_dokument','like',"%{$request->cari}%")
                    ->get();
        }else{
            $data = DB::table('rakordir')
                    ->where('date',date('Y-m-d',strtotime($tanggal)) )->get();
        }

        foreach ($data as $key => $value) {
            array_push($ret,[
                'username'=>$value->username,
                'file_name'=>$value->file_name,
                'file_path'=>explode(';',$value->file_path),
                'date'=>date('d-m-Y',strtotime($value->date)) . " <br> ".$value->mulai. " - " . $value->keluar,
                'mulai'=>$value->mulai,
                'keluar'=>$value->keluar,
                'tempat'=>$value->tempat,
                'judul'=>$value->judul,
                'no_dokument'=>$value->no_dokument,
                'agenda_no'=>$value->agenda_no,
                'presenter'=>$value->presenter,
            ]);
        }
        $data = collect($ret);
        return Datatables::of($data)->make(true);

    }
}
