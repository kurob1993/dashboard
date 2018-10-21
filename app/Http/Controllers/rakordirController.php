<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Facades\Datatables;
use Validator;

class rakordirController extends Controller
{
   public function __construct ()
    {
       date_default_timezone_set('Asia/Jakarta');
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
                    'judul'     => $request->judul,
                    'agenda_no' => $request->agenda_no,
                    'no_dokument' => $request->no_dokument,
                    'presenter' => $request->presenter,
                ]
            );
        if($save){

            $uploadedFile  = $request->file('file'); 
            $path          = $uploadedFile->store( 'public/files/rakordir/'.$username.'/'.date('Y-m-d') );
            $realName      = $request->file->getClientOriginalName();

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
        $data = DB::table('rakordir')->where('username',$username);
        return Datatables::of($data)->make(true);
    }
    
    //menu materi rakordir
    public function file(Request $request,$tanggal=null)
    {

        // return DB::table('rakordir')->groupBy(DB::RAW("date_format(date,'%Y-%m')") )->get()->dd();
        // die();
        $data_group     = $request->get('data_group');
        $data_menu      = $request->get('data_menu');
        $tanggalx       = null;
        $perbulan       = false;
        $pertanggal     = false;

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
            if($request->cari){
                $tanggalx  = $request->cari;
                $data = null;
            }else{
                $data = DB::table('rakordir')->groupBy(DB::RAW("date_format(date,'%Y-%m')") )->paginate(12);
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

            ]
        );

    }
    public function showMateri(Request $request,$tanggal = null)
    {
        $data = [];
        if(true === strtotime($tanggal) && $request->cari){
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
        
        return Datatables::of($data)->make(true);
    }
}
