<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class strukturOrganisasiController extends Controller
{

	public function __construct ()
    {
        date_default_timezone_set('Asia/Jakarta');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	$data_group      = $request->get('data_group');
        $data_menu       = $request->get('data_menu');
        $data 			 = ['data_group' => $data_group, 'data_menu' => $data_menu ];
        return view('sdm.strukturOrganisasi',$data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
    	$id = isset($request->id)?$request->id:NULL;
    	$ret = $this->showParent($id);
     	return $ret;
    }
    public function showParent($id)
    {
    	$orgArray = array();

        //jika id yg dikirim saat klik tree grid null maka tampilkan org krakatausteel
    	if($id == NULL){
            //memasukan ke array
    		array_push($orgArray, '50000950');
    	}else{
            //megambil org anakan sesuai id yang dikirim ketika klik tree grid
    		$orgunit = DB::table('orgunit')
    			->select('ObjectID')
    			->where('IDrelatedobject',$id)
    			->where('EndDate', '>' ,date('Y-m-d') )
    			->get();

	    	//memasukan ke array
	    	foreach ($orgunit as $key => $value) {
	    		array_push($orgArray,  $value->ObjectID);
	    	}
    	}

        // mengambil org anakan dari table org_text
    	$db = DB::table('org_text')
    			->whereIn('ObjectID',$orgArray)
    			->where('EndDate', '>' ,date('Y-m-d') )
    			->orderBy('Objectabbr','ASC')
    			->limit(10)
    			->get();

    	$array = array();		
    	foreach ($db as $key => $value) {
            // mencari apakah data org tersebut masih mempunyai anakan apa tidak
    		$count = DB::table('orgunit')
    				->where('IDrelatedobject',$value->ObjectID)
    				->where('EndDate','>',date('Y-m-d') )
    				->count();

            //memformat menjadi array org yang mau ditampilkan
            if( substr($value->Objectname, 0,3) == 'KRA' ){
                array_push($array, 
                    array(
                        'id'           => $value->ObjectID,
                        'OBJ'          => $value->ObjectID,
                        'parentId'     => $id?$id:0,
                        'state'        => $count == 0?'':'closed',
                        'count'        => $count,
                        'organisasi'   => $value->Objectname,
                        'name'         => NULL
                    )
                );
            }else if( substr($value->Objectname, 0,3) == 'Dir'){
                array_push($array, 
                    array(
                        'id'           => $value->ObjectID,
                        'OBJ'          => $value->ObjectID,
                        'parentId'     => $id?$id:0,
                        'state'        => $count == 0?'':'closed',
                        'count'        => $count,
                        'organisasi'   => $value->Objectname,
                        'name'         => $this->getDireksi($value->Objectabbr),
                    )
                );
            }else if( substr($value->Objectname, 0,3) == 'Sub' || substr($value->Objectname, 0,3) == 'Int'){
                array_push($array, 
                    array(
                        'id'           => $value->ObjectID,
                        'OBJ'          => $value->ObjectID,
                        'parentId'     => $id?$id:0,
                        'state'        => $count == 0?'':'closed',
                        'count'        => $count,
                        'organisasi'   => $value->Objectname,
                        'name'         => $this->getEmpForOrg($value->ObjectID,'Sub','name'),
                        'gol'          => $this->getEmpForOrg($value->ObjectID,'Sub','gol'),
                    )
                );
            }else if( substr($value->Objectname, 0,3) == 'Div'){
                array_push($array, 
                    array(
                        'id'           => $value->ObjectID,
                        'OBJ'          => $value->ObjectID,
                        'parentId'     => $id?$id:0,
                        'state'        => '',
                        'count'        => $count,
                        'organisasi'   => $value->Objectname,
                        'name'         => $this->getEmpForOrg($value->ObjectID,'Div','name'),
                        'gol'          => $this->getEmpForOrg($value->ObjectID,'Div','gol'),
                    )
                );
            }
    		
    	}
    	$ret = $array;

     	return $ret;
    }
    public function getDireksi($dirnik)
    {
        $ret = DB::table('structdireksi')
            ->where('dirnik', $dirnik)
            ->limit(1);
        $ret = $ret->count() > 0 ? $ret->get()[0]->empname:NULL;
        return $ret;
    }
    public function getEmpForOrg($org,$abre=NULL,$pil)
    {   
        $ret = '';
        if($abre == 'Sub'){
            $ret = DB::table('structdisp')
                    ->where('emporid', $org)
                    ->whereRaw("RIGHT(emp_hrp1000_s_short,8) = '00000000'")
                    ->orderBy('emppersk','asc')
                    ->limit(1);
        }

        if($abre == 'Div'){
            $ret = DB::table('structdisp')
                    ->where('emporid', $org)
                    ->whereRaw("RIGHT(emp_hrp1000_s_short,7) = '0000000'")
                    ->orderBy('emppersk','asc')
                    ->limit(1);
        }
        
        if($pil == 'name'){
            $ret = $ret->count() > 0 ? $ret->get()[0]->empname:NULL;
        }
        if($pil == 'gol'){
            $ret = $ret->count() > 0 ? $ret->get()[0]->emppersk:NULL;
        }
        
        return $ret;
    }
    
    public function getOrgTxt()
    {
        $DB_HCI   = DB::connection('mysql_hci');
        $org_text = $DB_HCI->table('org_text')->get();

        // clear tabel orgunit di databse dashboard
        $DB_DOE_ORGUNIT_truncate = DB::table('org_text')->truncate();

        foreach ($org_text as $key => $value) {
            $DB_DOE_ORGTXT = DB::table('org_text')->insert(
                [
                    'PV'=>$value->PV,
                    'OT'=>$value->OT,
                    'ObjectID'=>$value->ObjectID,
                    'Objectname'=>$value->Objectname,
                    'Objectabbr'=>$value->Objectabbr,
                    'Startdate'=>$value->Startdate,
                    'EndDate'=>$value->EndDate,
                    'IT'=>$value->IT,
                    'LSTUPDT'=>$value->LSTUPDT,
                ]
            );
        }

    }
    public function getOrgUnit()
    {
        $DB_HCI   = DB::connection('mysql_hci');
        $orgUnit  = $DB_HCI->table('orgunit')->get();

        // clear tabel orgunit di databse dashboard
        $DB_DOE_ORGUNIT_truncate = DB::table('orgunit')->truncate();

        foreach ($orgUnit as $key => $value) {
            $DB_DOE_ORGUNIT = DB::table('orgunit')->insert(
                [
                    'OT'=>$value->OT,
                    'ObjectID'=>$value->ObjectID,
                    'S'=>$value->S,
                    'Rel'=>$value->Rel,
                    'Startdate'=>$value->Startdate,
                    'EndDate'=>$value->EndDate,
                    'RO'=>$value->RO,
                    'IDrelatedobject'=>$value->IDrelatedobject,
                    'LSTUPDT'=>$value->LSTUPDT
                ]
            );
        }

    }
    public function getStrkturDisp()
    {
        $DB_HCI     = DB::connection('mysql_hci');
        $structdisp = $DB_HCI->table('structdisp')->where('no','1')->get();

        // clear tabel orgunit di databse dashboard
        $DB_DOE_STRUKTURDISP_truncate = DB::table('structdisp')->truncate();

        foreach ($structdisp as $key => $value) {
            $DB_DOE_STRUKTURDISP = DB::table('structdisp')->insert(
                [
                    'no'=>$value->no,
                    'empnik'=>$value->empnik,
                    'empname'=>$value->empname,
                    'empposid'=>$value->empposid,
                    'emp_hrp1000_s_short'=>$value->emp_hrp1000_s_short,
                    'emppostx'=>$value->emppostx,
                    'emporid'=>$value->emporid,
                    'emportx'=>$value->emportx,
                    'emp_hrp1000_o_short'=>$value->emp_hrp1000_o_short,
                    'empjobid'=>$value->empjobid,
                    'empjobstext'=>$value->empjobstext,
                    'emppersk'=>$value->emppersk,
                    'emp_t503t_ptext'=>$value->emp_t503t_ptext,
                    'empkostl'=>$value->empkostl,
                    'emp_cskt_ltext'=>$value->emp_cskt_ltext,
                    'dirnik'=>$value->dirnik,
                    'dirname'=>$value->dirname,
                    'LSTUPDT'=>$value->LSTUPDT
                ]
            );
        }
    }
    
}
