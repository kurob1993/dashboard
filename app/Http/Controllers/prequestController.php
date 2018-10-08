<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use App\produk;
use App\prequest;
//use App\data;
class prequestController extends Controller
{
	public function __construct ()
	{

	}
	public function index(Request $request)
	{
		//$produk         = new produk;
        //$produk_ret = $produk::all();

        $data_group = $request->get('data_group');
        $data_menu = $request->get('data_menu');
    	return view('logistik/prequest',['data_group'=>$data_group, 'data_menu'=>$data_menu]);
	}

	public function preqbln(Request $request)
    {
		$bln 	= '9';//date('m');
		$thn	= '2017';
		//$db 	= new Database();
		$sqlb	= ("call prformbrg(".$bln.",".$thn.");");
		$sqlj	= ("call prformjs(".$bln.",".$thn.");");
		
		$prb	= DB::select($sqlb);
		$prj	= DB::select($sqlj);
		
		$sqlbb	= ("call prperiodeb(".$thn.");");
		$sqlbj	= ("call prperiodeb(".$thn.");");
		
		$prbb	= DB::select($sqlbb);
		$prbj	= DB::select($sqlbj);
		
		$return['br'] 	= $prb;
		$return['js'] 	= $prj;
		$return['bbr'] 	= $prbb;
		$return['bjs'] 	= $prbj;
        return $return ;
    }
}
