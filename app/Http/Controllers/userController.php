<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Facades\Datatables;

use App\sys_user;
use App\sys_group;

class userController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Jakarta');
    }
    public function index(Request $request)
    {
        $data_group 	= $request->get('data_group');
        $data_menu      = $request->get('data_menu');
        $userList 		= $this->show();

        return view('data_master.user', [
                    'data_group'=> $data_group,
                    'data_menu'	=> $data_menu,
                    'userList' => $userList,
        ]);
    }

    public function show()
    {
        $data = DB::table('sys_users');
        return Datatables::of($data)->make(true);
    }
    public function save(Request $request)
    {
        $error = "";
        isset($request->nik)?$request->nik: $error .= " Nik is Empty<br>";
        isset($request->name)?$request->name: $error .= " Name is Empty<br>";
        Isset($request->jabatan)?$request->jabatan: $error .= " Position is Empty<br>";
        isset($request->email)?$request->email: $error .= " Email is Empty<br>";
        // isset($request->pk)?$request->pk: $error .= " Pk is Empty<br>";

        if($error == ""){
            $count = DB::table('sys_users')->where("nik",$request->nik)->count();
            if($count == 0){
                $username = explode('@', $request->email);
                $insert = DB::table('sys_users')->insert(
                    ['nik' => $request->nik, 'username' => $username[0], 'name' => $request->name, 
                    'jabatan' => $request->jabatan, 'pk' => $request->pk, 'email' => $request->email]
                );
                if($insert){
                    return array("msg"=> "success");
                }
            }else{
                return array("msg"=> "Duplicat Data");
            }
        }else{
            return array("msg"=> $error);
        }
        
    }
    public function update(Request $request)
    {
        $error = "";
        isset($request->nik)?$request->nik: $error .= " Nik is Empty<br>";
        isset($request->name)?$request->name: $error .= " Name is Empty<br>";
        Isset($request->jabatan)?$request->jabatan: $error .= " Position is Empty<br>";
        isset($request->email)?$request->email: $error .= " Email is Empty<br>";
        // isset($request->pk)?$request->pk: $error .= " Pk is Empty<br>";

        if($error == ""){
            $count = DB::table('sys_users')->where("nik",$request->nik)->where("nik","<>",$request->nik_hide)->count();
            if($count == 0){
                $username = explode('@', $request->email);
                $insert = DB::table('sys_users')
                            ->where("nik","=",$request->nik_hide)
                            ->update([
                                'nik' => $request->nik, 'name' => $request->name , 
                                'jabatan' => $request->jabatan, 'email' => $request->email, 
                                "pk" => $request->pk, "username"=>$username[0] 
                            ]);
                if($insert){
                    return array("msg"=> "success");
                }
            }else{
                return array("msg"=> "Duplicat Data");
            }
        }else{
            return array("msg"=> $error);
        }
        
    }
    public function delete(Request $request)
    {
        $delete = DB::table('sys_users')->where('nik',$request->nik)->delete();
        if($delete){
            return array("msg"=> "success");
        }
    }
    public function get(Request $request)
    {
        $data = DB::table('sys_users')->where('nik',$request->nik)->get();
        return $data;
    }
    public function update_useraccess(Request $request)
    {
        
        //list menu yang akrif
        $msg = "";
        $arrMenu = array();
        $menu = DB::table('sys_menus')->where('status','Y')->get();
        foreach ($menu as $key => $value) {
            array_push($arrMenu, $value->node_group.$value->node_menu);
        }

        //menambahkan access user ke menu yang di pilih
        foreach ($request->MENU as $key => $value) {
            //mencari menu sesuai request yg dikirim dan nik access tidak ada
            $select = DB::table('sys_menus')
                        ->where('status','Y')
                        ->where( DB::RAW('CONCAT(node_group,node_menu)'), $value)
                        ->where('nik_access','NOT REGEXP','[[:<:]]'.$request->nik.'[[:>:]]')
                        ->get();
            //jika ada data maka tambahkan nik access
            if($select){
                foreach ($select as $key => $valmenu) {
                    $valNIK = $valmenu->nik_access?$valmenu->nik_access.",":"";
                    $upd = DB::table('sys_menus')
                                ->where( DB::RAW('CONCAT(node_group,node_menu)'), $value)
                                ->update(['nik_access' => $valNIK.$request->nik]);
                    $upd?$msg .= " Update Menu ".$valmenu->menu." Success...\n":$msg .= " Update Menu ".$valmenu->menu." Error...\n";
                }
            }
        }

        //menghapus access menu sesuai nik yg dikirim
        foreach ($arrMenu as $key => $valArrMenu) {
            //bandingkan menu yang dipilih sama menu yang ada di DB
            //ambil yang tidak ada
           if(!in_array($valArrMenu, $request->MENU)){
                $unSelect = DB::table('sys_menus')->where('status','Y')
                                ->where( DB::RAW('CONCAT(node_group,node_menu)'), $valArrMenu)
                                ->get();
                //mengambil nik access dari DB
                foreach ($unSelect as $key => $valunSelect) {
                    //hapus nik access yang ada di Db sesuai dengan $request->nik
                    $nik_access = array_diff(explode(",", $valunSelect->nik_access), array($request->nik) );
                    //format ulang nik access
                    $setNik = "";
                    foreach ($nik_access as $key => $nik) {
                        $setNik .= $nik.",";
                    }
                    //update nik access yang ada di DB
                    $upd= DB::table('sys_menus')
                            ->where( DB::RAW('CONCAT(node_group,node_menu)'), $valArrMenu)
                            ->update(['nik_access' => rtrim($setNik,",") ]);
                    $upd?$msg .="Remove Menu Success...\n":$msg .="Remove Menu Error...\n";
                }
           }

        }


        return array($msg);
    }

    public function listMenu($nik)
    {
        $group          = DB::table('sys_groups')->get();
        $menu           = DB::table('sys_menus')->where('status','Y')->get();
        $checked        = '';
        
        echo '<input name="nik" value="'.$nik.'" type="hidden"/>';
        echo '<div class="list-group"><a href="#" class="list-group-item active">Menu</a>';
        foreach ($group as $key => $valgroup) {
            echo '<a href="#" class="list-group-item">';
                echo ' <li class="'.$valgroup->icon.'" style=" margin-right:10px"></li>';
                echo $valgroup->group.'<br>';

                foreach($menu as $key => $valmenu){
                    if($valmenu->node_group == $valgroup->node_group){

                        if(in_array( $nik, explode(",", $valmenu->nik_access) ) ){
                            $checked = 'checked';
                        }else{
                            $checked = '';
                        }
                        echo '<span style=" margin-right:25px"></span><label class="checkbox-inline">';
                            echo '<input type="checkbox" '.$checked.' name="MENU[]" value="'.$valmenu->node_group.$valmenu->node_menu.'">';
                            echo $valmenu->menu;
                        echo '</label><br>';

                    }
                }

            echo '</a>';
        }
        echo '</div>';
    }
}
