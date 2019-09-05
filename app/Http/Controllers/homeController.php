<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\sys_user;
use App\sys_group;
use App\produk;
use App\data;
use App\wip_child1;
use Sinergi\BrowserDetector\Browser;

class homeController extends Controller
{
    public function __construct ()
    {
        date_default_timezone_set('Asia/Jakarta');
        $browser = new Browser();

        if ($browser->getName() === Browser::IE) {
            echo '
             <body style="background-color:powderblue;font-family: Tahoma;">
                <center>
                   <h1 style="margin-top: 200px"> Silahkan menggunakan browser<br> <i style="color : red">Mozilla Firefox</i> atau <i style="color : red">Google Chrome</i><br> untuk kenyamanan menggunakan aplikasi Dashboard ini </h1>
                </center>
             </body>
            ';
            die();
        }
    }
    public function index(Request $request)
    {
        $produk     = new produk;
        $produk_ret = $produk::all();

        $data_group = $request->get('data_group');
        $data_menu  = $request->get('data_menu');
        $tanggal    = date('Y/m/d');
        $now        = strtotime(date("Y-m-d"));
        $kemarin    = date("Y-m-d",strtotime('-1 day', $now) );
        $help       = $this->help();
        
        return view('home',['data_group'=>$data_group,
            'data_menu' => $data_menu,
            'produk' => $produk_ret,
            'tanggal' => $tanggal,
            'kemarin' => $kemarin,
            'help'  => $help,
        ]);
    }
    // public function sigin(Request $request)
    // {
    //     $user_name  = $request->input('username');
    //     $pwd        = $request->input('password');

    //     $sys_user = new sys_user();
    //     $data = $sys_user::where('username',$user_name)->get();
    //     $user = NULL;
    //     foreach ($data as $key => $value) {
    //         $user = $value->username;
    //         $name = $value->name;
    //         $jabatan = $value->jabatan;
    //         $level = $value->level;
    //         $nik = $value->nik;
    //     }
    //     if($user){
    //         session([
    //             'nik'=> $nik,
    //             'username'=> $user,
    //             'name'=> $name,
    //             'jabatan'=> $jabatan,
    //             'level'=> $level
    //         ]);
    //         $session = $request->session()->get('username');
    //         $this->pengunjung($session);
    //         if($session){
    //             return redirect('/');
    //         }
    //     }else{
    //         return redirect('/');
    //     }

    // }
    // ------ LOGIN FROM SSO
    public function sigin(Request $request,$nik = null)
    {
        $sys_user = new sys_user();
        $data = $sys_user::where('nik',$nik)->get();
        $user = NULL;
        foreach ($data as $key => $value) {
            $user = $value->username;
            $name = $value->name;
            $jabatan = $value->jabatan;
            $level = $value->level;
        }
        if($user){
            session([
                'username'=> $user,
                'name'=> $name,
                'jabatan'=> $jabatan,

                'level'=> $level
            ]);
            $session = $request->session()->get('username');
            if($session){
                return redirect('/');
            }
        }else{
            $request->session()->flush();
            return redirect('https://sso.krakatausteel.com');
        }

    }
    // ------ LOGIN FROM SSO

    public function pengunjung($user_name)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');
        DB::table('sys_pengunjung')->insert(['USER_NAME' => $user_name,'TANGGAL' =>  $date]);
    }

    public function login(Request $request)
    {
        $session = $request->session()->exists('username');
        if(!$session){
            return view('auth.login');
        }else{
            return redirect('/');
        }
    }
    public function logout(Request $request)
    {
        $request->session()->forget('username');
        $session = $request->session()->exists('username');
        if(!$session){
            return redirect('/');
        }
    }
    public function chart(Request $request)
    {
        $now        = strtotime(date("Y-m-d"));
        $kemarin    = date("Y-m-d",strtotime('-1 day', $now) );
        $firstDate  = date("Y-m-01", strtotime($kemarin) );

        $group      = $request->group;
        $produk_nama= $request->produk;
        $produk     = new produk;
        $produk_id  = $produk::where('produk',$produk_nama)->get();

        $chart      = new data;
        $chart_ret  = $chart::select('tanggal as label','sum as value')
                                ->where('tanggal','>=',$firstDate)
                                ->where('tanggal','<=',$kemarin)
                                ->where('group',$group)
                                ->where('produk_id',$produk_id[0]->id)
                                ->get();

        $sum    = $chart::where('group',$group)
                            ->where('produk_id',$produk_id[0]->id)
                            ->where('tanggal','>=',$firstDate)
                            ->where('tanggal','<=',$kemarin)
                            ->sum('sum');

        $count  = $chart::where('group',$group)
                        ->where('tanggal','>=',$firstDate)
                        ->where('tanggal','<=',$kemarin)
                        ->where('produk_id',$produk_id[0]->id)
                        ->count();
        $avg    = $sum/$count;

        $return = ['chart' => $chart_ret, 'avg' => $avg];
        return $return;
    }
    public function coba(Request $request)
    {
        $data = $request->get('data_menu');
        foreach ($data as $key => $value) {
            echo $value;
        }
    }
    public function shipprod($tgl = null,$produk = "HR")
    {
        $date       = strtotime($tgl);
        $m          = isset($tgl)?date("m",$date):date("m");
        $y          = isset($tgl)?date("Y",$date):date("Y");
        $ttlhr      = cal_days_in_month(CAL_GREGORIAN, $m, $y);

        $cate       ='';
        $arr        = array();

        for ($i=1;$i<=$ttlhr;$i++){
            $cate = array ( 'label'=>"$i", 'stepSkipped'=>false, 'appliedSmartLabel'=> true );
            array_push($arr,$cate );
        }

        $kate['category']   = $arr;
        $kat ['categories'] = array($kate);

        //get dataset

        $lap        = $produk;


        switch ($lap){
            case 'TTL' :
                $col = "(hr_dom + hrpo_dom + cr_dom + wr_dom + hr_exp + hrpo_exp + cr_exp + wr_exp) ";
                break;
            case 'DMS' :
                $col = "(hr_dom + hrpo_dom + cr_dom + wr_dom)";
                break;
            case 'EKS' :
                $col = "(hr_exp + hrpo_exp + cr_exp + wr_exp)";
                break;
            case 'HR' :
                $col = "(hr_dom + hr_exp )";
                break;
            case 'PO' :
                $col = "(hrpo_dom + hrpo_exp)";
                break;
            case 'CR' :
                $col = "(cr_dom + cr_exp)";
                break;
            case 'WR' :
                $col = "(wr_dom + wr_exp)";
                break;
            case 'BLT' :
                $col = " 0 ";
                break;
        }
        $sql        = "select ".$col." / 1000 as value  from shipments
                        where month(shipment_date)=".(int)$m." and YEAR(shipment_date)=".$y;
        //dd($sql);
        $sqlt       = "select ".$col." as value  from shipment_targets
                        where month(target_date)=".(int)$m." and YEAR(target_date)=".$y;
        //dd($sqlt);
        $sqlc       = " SELECT * FROM
                         (SELECT @running_count := @running_count + ".$col." / 1000  AS value
                        FROM shipments, (SELECT @running_count := 0) AS T1
                        WHERE month(shipment_date)=".(int)$m." and YEAR(shipment_date)=".$y."
                        ORDER BY shipment_date) AS TableCount ";

        $sqlct      = " SELECT * FROM
                         (SELECT @running_count := @running_count + ".$col."  AS value
                        FROM shipment_targets, (SELECT @running_count := 0) AS T1
                        WHERE month(target_date)=".(int)$m." and YEAR(target_date)=".$y."
                        ORDER BY target_date) AS TableCount ";

        $shipment   = DB::select($sql);
        $target     = DB::select($sqlt);

        $accu       = DB::select($sqlc);
        $acclt      = DB::select($sqlct);

        $sip ['seriesname']     = 'Shipment';
        $sip ['showValues']     = '0';
        $sip ['placevaluesInside'] = "0";

        $sip ['data']           = $shipment;

        $trgt ['seriesname']    = 'Target';
        $trgt ['data']          = $target;
        //accumulated
        $accu ['seriesname']    = 'Shipment';
        $accu ['data']          = $accu;

        $acct ['seriesname']    = 'Target';
        $acct ['color']         = 'CC3300';
        $acct ['renderas']      = 'Line';
        $acct ['showValues']    = '0';
        $acct ['data']          = $acclt;

        $hsl                    = [ $sip, $trgt];
        $hslt                   = [ $accu, $acct];

        $return['categories']   = array($kate);
        $return['dataset']      = $hsl;

        $return['categoriesa']  = array($kate);
        $return['dataseta']     = $hslt;

        //$dttable []= '';
        $dttable = array();
        $attable = array();
        $jml = sizeof($shipment)-1;
        for ($i=0;$i<=$jml;$i++){
            $k = $i;
            $k++;
            isset($shipment[$i]) ? $sp = $shipment[$i]->value : $sp = 0;
            isset($target[$i])   ? $tg = $target[$i]->value : $tg = 0;
            //$dt = array($k,$shipment[$i]->value,$target[$i]->value);
            $dt = array($k,$sp,$tg);
            array_push($dttable, $dt);

            isset($accu[$i]) ? $ac = $accu[$i]->value : $ac = 0;
            isset($acclt[$i])   ? $ct = $acclt[$i]->value : $ct = 0;

            //$at = array($k,$accu[$i]->value,$acclt[$i]->value);
            $at = array($k,$ac,$ct);
            array_push($attable, $at);
        }

        //dd($dttable);
        $return['dtable'] = $dttable;
        $return['atable'] = $attable;
        return $return ;
    }
    public function margin($tanggal,$produk)
    {
        $retrun = DB::table('data_pl_vd')
                        ->where('produk',$produk)
                        ->where('tanggal',$tanggal)
                        ->get();
        return $retrun;
    }
    public function Stock_FG($produk,$tanggal)
    {
        $stock_FG = DB::select('SELECT fn_stock_fg("'.$tanggal.'","'.$produk.'") AS current_value');
        foreach ($stock_FG as $key => $value) {
            $retrun = $value->current_value;
        }
        return $retrun;
    }
    public function cargo($produk,$tanggal)
    {
        $cargo = DB::select('SELECT fn_cargo("'.$tanggal.'","'.$produk.'") AS current_value');
        foreach ($cargo as $key => $value) {
            $retrun = $value->current_value;
        }
        return $retrun;
    }
    public function fd_memo($produk,$tanggal)
    {
        $fd_memo = DB::select('SELECT fn_fd_memodinas("'.$tanggal.'","'.$produk.'") AS current_value');
        foreach ($fd_memo as $key => $value) {
            $retrun = $value->current_value;
        }
        return $retrun;
    }
    public function full_pay($produk,$tanggal)
    {
        $full_pay = DB::select('SELECT fn_full_pay("'.$tanggal.'","'.$produk.'") AS current_value');
        foreach ($full_pay as $key => $value) {
            $retrun = $value->current_value;
        }
        return $retrun;
    }
    public function lcso($produk,$tanggal)
    {
        $lcso = DB::select('SELECT fn_lcso("'.$tanggal.'","'.$produk.'") AS current_value');
        foreach ($lcso as $key => $value) {
            $retrun = $value->current_value;
        }
        return $retrun;
    }
    public function hold($produk,$tanggal)
    {
        $hold = DB::select('SELECT fn_hold("'.$tanggal.'","'.$produk.'") AS current_value');
        foreach ($hold as $key => $value) {
            $retrun = $value->current_value;
        }
        return $retrun;
    }
    public function rts($produk,$tanggal)
    {
        $rts = DB::select('SELECT fn_rts("'.$tanggal.'","'.$produk.'") AS current_value');
        foreach ($rts as $key => $value) {
            $retrun = $value->current_value;
        }
        return $retrun;
    }
    public function cir($produk,$tanggal)
    {
        $cir = DB::select('SELECT fn_cir("'.$tanggal.'","'.$produk.'") AS current_value');
        foreach ($cir as $key => $value) {
            $retrun = $value->current_value;
        }
        return $retrun;
    }
    public function im($produk,$tanggal)
    {
        $im = DB::select('SELECT fn_im("'.$tanggal.'","'.$produk.'") AS current_value');
        foreach ($im as $key => $value) {
            $retrun = $value->current_value;
        }
        return $retrun;
    }
    public function ip($produk,$tanggal)
    {
        $ip = DB::select('SELECT fn_ip("'.$tanggal.'","'.$produk.'") AS current_value');
        foreach ($ip as $key => $value) {
            $retrun = $value->current_value;
        }
        return $retrun;
    }
    public function is($produk,$tanggal)
    {
        $is = DB::select('SELECT fn_is("'.$tanggal.'","'.$produk.'") AS current_value');
        foreach ($is as $key => $value) {
            $retrun = $value->current_value;
        }
        return $retrun;
    }
    public function totalShipemnt($tanggal)
    {
        //akumulasi shipment all prod
        $y = $this->shipprod($tanggal,"TTL");
        $shipmenta = $y['atable'];
        $ttlShipemnt = "";
        $shipments_tanggal = date('d',strtotime($tanggal) );
        foreach ($shipmenta as $key => $value) {
             if($value[0] == $shipments_tanggal){
                $ttlShipemnt = $value[1];
             }
        }
        return $ttlShipemnt;
    }
    public function totalRevenue($tanggal)
    {
        $f = date('Y-m-01',strtotime($tanggal));
        $ret = DB::table('data_pl_vd')
                    ->where('tanggal','>=',$f)
                    ->where('tanggal','<=',$tanggal)
                    ->sum('sales_value_usd');
        return $ret;
    }
    public function data_produk(Request $request)
    {
        $now                = strtotime($request->tanggal);
        $kemarin            = date("Y-m-d",strtotime('-1 day', $now) );
        $produk_nama        = $request->produk;

        $produk             = new produk;
        $produk_id          = $produk::where('produk',$produk_nama)->get();
        $produk_ret         = $produk::find($produk_id[0]->id)->data()->where('tanggal',$kemarin)->get();

        $produk             = new data;
        $produk_child1      = $produk->view_wipChild1($produk_id[0]->id,$kemarin);
        $produk_child2      = $produk->view_wipChild2($produk_id[0]->id,$kemarin);
        $data_total         = $produk->data_total($produk_id[0]->id,$kemarin);

        $margin             = $this->margin($kemarin,$produk_nama);
        $kontribusi_margin  = isset($margin[0]->sum_value_idr)?number_format($margin[0]->sum_value_idr):'0';
        $revenue            = isset($margin[0]->sales_value_usd)?number_format($margin[0]->sales_value_usd,2):'0';

        //IM IP IS
        $im = $this->im($produk_id[0]->id,$kemarin);
        $ip = $this->ip($produk_id[0]->id,$kemarin);
        $is = $this->is($produk_id[0]->id,$kemarin);

        //cir
        $cir = $this->cir($produk_id[0]->id,$kemarin);

        //Stock FG
        $stock_FG = $this->Stock_FG($produk_id[0]->id,$kemarin);

        //cargo FG
        $cargo    = $this->cargo($produk_id[0]->id,$kemarin);

        //RTS
        $rts      = $this->rts($produk_id[0]->id,$kemarin);

        //cargo FG
        $fd_memo  = $this->fd_memo($produk_id[0]->id,$kemarin);

        //full pay
        $full_pay = $this->full_pay($produk_id[0]->id,$kemarin);

        //LC/SO
        $lcso     = $this->lcso($produk_id[0]->id,$kemarin);

        //hold
        $hold     = $this->hold($produk_id[0]->id,$kemarin);

        //total shipment
        $ttlship = $this->totalShipemnt($request->tanggal);

        // total revenue
        $ttlrevenue = $this->totalRevenue($kemarin);

        $return = [
                    'produk'            => $produk_ret,
                    'child1'            => $produk_child1,
                    'child2'            => $produk_child2,
                    'data_total'        => $data_total,
                    'kontribusi_margin' => $kontribusi_margin,
                    'revenue'           => '$'.$revenue,
                    'last_update'       => $kemarin,

                    'im'                => $im,
                    'ip'                => $ip,
                    'is'                => $is,
                    'cir'               => $cir,
                    'stockFG_val'       => $stock_FG,
                    'cargo_val'         => $cargo,
                    'rts'               => $rts,
                    'fd_memo'           => $fd_memo,
                    'full_pay'          => $full_pay,
                    'lcso'              => $lcso,
                    'hold'              => $hold,
                    'ttl_shipment'      => $ttlship,
                    'ttl_revenue'       => $ttlrevenue,
                ];

        foreach ($produk_ret as $key => $value) {
            if($value->group == 4){
                $produk_ret[$key] = "";
            }
        }

        $x = $this->shipprod($request->tanggal,$produk_nama);

        $shipmenta = $x['atable'];
        $shipmentd = $x['dtable'];

        $shipments_akumulasi = '';
        $shipments_daily = '';
        $shipments_tanggal = date('d',$now);

        foreach ($shipmenta as $key => $value) {
             if($value[0] == $shipments_tanggal){
                $shipments_akumulasi = $value[1];
             }
        }

        foreach ($shipmentd as $key => $value) {
             if($value[0] == $shipments_tanggal){
                $shipments_daily = $value[1];
             }
        }

        //Shipment today
        $produk_ret[] = [
            "tanggal"=>date("Y-m-d"),
            "produk_id"=>$produk_id[0]->id,
            "group"=> 4,
            "tag_name" =>"Shipment",
            "sum" => number_format( $shipments_daily !=''?$shipments_daily:"0" )
        ];

        //Shipment akumulasi
        $data_total[] = [
            "tanggal"=>date("Y-m-d"),
            "produk_id"=>$produk_id[0]->id,
            "group"=> 4,
            "tag_name" =>"Shipment",
            "current_value" => number_format( $shipments_akumulasi != ''?$shipments_akumulasi:"0" )
        ];


        return $return ;
    }
    public function help()
    {
        try {
            $dir = '../html_loc/public/img/help/dashboard';
            $a = scandir($dir);
        } catch (\Throwable $th) {
            $a = [];
        }

        $data = array();
        foreach ($a as $key => $value) {
            if( $value != "." and $value != ".."){
                array_push($data, $value);
            }
        }
        return $data;
    }
}
