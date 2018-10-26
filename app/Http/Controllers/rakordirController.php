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
    //back drop rakordir
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
    // form input
    public function formInput(Request $request)
    {
        $data_group     = $request->get('data_group');
        $data_menu      = $request->get('data_menu');
        $dateLastInput  = session()->get('dateLastInput') !== NULL ? session()->get('dateLastInput') : NULL ;
        return view('rakordir.inputFileForm',
            [
                'data_group'    => $data_group,
                'data_menu'     => $data_menu,
                'dateLastInput'  => $dateLastInput
            ]
        );
    }
    //menu materi rakordir
    public function file(Request $request,$tanggal=null,$backdrop=null)
    {
        $data_group     = $request->get('data_group');
        $data_menu      = $request->get('data_menu');
        $tanggalx       = null;
        $cari           = null;
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
                $cari  = $request->cari;
                $tanggalx  = '-';
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
                'backdrop' => $backdrop,
                'cari'       =>$cari

            ]
        );

    }
    // form edit data rakordir
    public function formEdit(Request $request,$tanggal = NULL, $agenda = NULL)
    {
        $ret  = [];
        $data = DB::table('rakordir')->where('date',$tanggal)->where('agenda_no',$agenda)->get();
        foreach ($data as $key => $value) {
            array_push($ret,[
                'username'=>$value->username,
                'file_name'=>$this->getFileName($value->date,$value->agenda_no),
                'file_path'=>$this->getFilePath($value->date,$value->agenda_no),
                'date'=>$value->date,
                'mulai'=>explode(':',$value->mulai),
                'keluar'=>explode(':',$value->keluar),
                'tempat'=>$value->tempat,
                'judul'=>$value->judul,
                'no_dokument'=>$value->no_dokument,
                'agenda_no'=>$value->agenda_no,
                'presenter'=>$value->presenter,
            ]);
        }
        $ret = collect($ret);
        $data_group     = $request->get('data_group');
        $data_menu      = $request->get('data_menu');
        return view('rakordir.editFileForm',
            [
                'data_group'    => $data_group,
                'data_menu'     => $data_menu,
                'data'          => $ret
            ]
        );
    }
    public function upload(Request $request)
    {
        $request->validate([
            // 'file' => 'required|mimes:pdf,PDF|max:5120',
            // 'file' => 'required',
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
            if($request->file){
                foreach ($request->file as $key => $value) {            
                    $uploadedFile  = $value; 
                    $path          = $uploadedFile->store( 'public/files/rakordir/'.$username.'/'. $request->tanggal .'/'.$request->agenda_no );
                    $realName      = $value->getClientOriginalName();
                    $update = DB::table('rakordir_file')
                        ->insert(
                            [
                                'date'      => $request->tanggal,
                                'agenda_no' => $request->agenda_no,
                                'file_name' => $realName,
                                'file_path' => str_replace("public/","",$path),
                            ]
                        );
                }
            }
            session(['dateLastInput' => $request->tanggal]);
            return redirect('/rakordir/input_file');
        }
        return Redirect::back()->withErrors(['msg', 'Error']);
        
    }
    public function getFilePath($date,$agenda_no)
    {
        $data = DB::table('rakordir_file')
            ->where('date',$date)
            ->where('agenda_no',$agenda_no)
            ->get();
        $file = [];
        foreach ($data as $key => $value) {
            array_push($file,$value->file_path);
        }
        return $file;
    }
    public function getFileName($date,$agenda_no)
    {
        $data = DB::table('rakordir_file')
            ->where('date',$date)
            ->where('agenda_no',$agenda_no)
            ->get();
        $file = [];
        foreach ($data as $key => $value) {
            array_push($file,$value->file_name);
        }
        return $file;
    }
    public function showUpload(Request $request)
    {
        $username   = $request->session()->get('username');
        $data       = DB::table('rakordir')->where('username',$username)->get();
        $ret        = [];
        foreach ($data as $key => $value) {
            array_push($ret,[
                'username'=>$value->username,
                'file_name'=>$value->file_name,
                'file_path'=>$this->getFilePath($value->date,$value->agenda_no),
                'date'=>date('d-m-Y',strtotime($value->date)) . " <br> ".$value->mulai. " - " . $value->keluar,
                'tanggal'=>$value->date,
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

    public function showMateri(Request $request,$tanggal = null)
    {
        $data = [];
        $ret  = [];
        if(false === strtotime($tanggal) && $request->cari){
            $data = DB::table('rakordir')
                    ->where(DB::RAW("date_format(date,'%d-%m-%Y')"),"like","%{$request->cari}%")
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
                'file_path'=>$this->getFilePath($value->date,$value->agenda_no),
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
    
    public function remove_element($array,$value) {
        if(($key = array_search($value,$array)) !== false) {
              unset($array[$key]);
        }    
    }
    public function edit(Request $request)
    {
        $username      = $request->session()->get('username'); 

        $save = DB::table('rakordir')
        ->where('agenda_no',$request->agenda_no_val)
        ->where('date',$request->tanggal_val)
        ->update(
            [
                'username'      => $username,
                'date'          => $request->tanggal,
                'mulai'         => $request->jam_mulai .":". $request->menit_mulai,
                'keluar'        => $request->jam_keluar .":". $request->menit_keluar,
                'judul'         => $request->judul,
                'agenda_no'     => $request->agenda_no,
                'no_dokument'   => $request->no_dokument,
                'presenter'     => $request->presenter,
            ]
        );
        if(isset($request->oldNameFile) && isset($request->file)){
            foreach ($request->file as $key => $value) {            
                $uploadedFile  = $value; 
                $path          = $uploadedFile->store( 'public/files/rakordir/'.$username.'/'. $request->tanggal .'/'.$request->agenda_no );
                $realName      = $value->getClientOriginalName();
                $nameFile      = $request->oldNameFile[$key];
                $update = DB::table('rakordir_file')
                ->where('agenda_no',$request->agenda_no_val)
                ->where('date',$request->tanggal_val)
                ->where('file_name',$nameFile)
                ->update(
                    [
                        'date'      => $request->tanggal_val,
                        'agenda_no' => $request->agenda_no_val,
                        'file_name' => $realName,
                        'file_path' => str_replace("public/","",$path),
                    ]
                );
            }
        }
        return redirect('/rakordir/input_file');
    }
    public function hapus($tanggal = NULL, $agenda = NULL)
    {
        $data1 = DB::table('rakordir')
        ->where('agenda_no',$agenda)
        ->where('date',$tanggal)
        ->delete();

        $data2 = DB::table('rakordir_file')
        ->where('agenda_no',$agenda)
        ->where('date',$tanggal)
        ->delete();
        if($data1 && $data2){
            return ['msg' => 'success'];
        }
    }
}
