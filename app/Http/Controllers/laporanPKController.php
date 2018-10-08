<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Datatables;

class laporanPKController extends Controller
{
   public function __construct ()
	{
	   date_default_timezone_set('Asia/Jakarta');
    }
    public function index(Request $request)
    {
        $data_group 	= $request->get('data_group');
        $data_menu      = $request->get('data_menu');
        $lastUpdate 	= $this->lastUpdate();
      	return view('finance.laporanPK',[
  		    		'data_group'=> $data_group,
  		    		'data_menu'	=> $data_menu,
                    'last_update' => $lastUpdate
      	]);
    }
    public function show()
    {
    	$ret = DB::table('laporanpk')->get();
    	return Datatables::of($ret)->make(true);
    }
    public function treeGridBaseOnCC(Request $request)
    {
        $id = $request->input('id');
        $ret = '';
        $row = array();
        if(!$id){
            $data = DB::table('laporanpk')
                        ->select( DB::RAW('MID(IM_POSITION,1,6) as COST_CENTER'),
                                  DB::RAW('sum(PROGRAM_PLAN) as SUM_PROGRAM_PLAN'),
                                  DB::RAW('sum(PROGRAM_BUDGET) as SUM_PROGRAM_BUDGET'),
                                  DB::RAW('sum(APPR_REQ_PLAN) as SUM_APPR_REQ_PLAN'),
                                  DB::RAW('sum(MRA_AVAIL_BUDGET) as SUM_MRA_AVAIL_BUDGET'),
                                  DB::RAW('sum(ACTUAL) as SUM_ACTUAL'),
                                  DB::RAW('(sum(ACTUAL)/sum(PROGRAM_PLAN)*100) as PERSEN'),
                                  'ID','DESCRIPTION','PROGRAM_PLAN','APPROVAL_YEAR',
                                  'PROGRAM_BUDGET','APPR_REQ_PLAN','MRA_AVAIL_BUDGET','ACTUAL'
                                )
                        ->where( DB::RAW('LENGTH(IM_POSITION)' ),'=',19)
                        ->groupBy( DB::RAW('MID( IM_POSITION, 1,6 )') )->get();

            foreach ($data as $key => $value) {
                array_push(
                  $row, array(  'id' => $value->COST_CENTER,
                                'parentId' => 0,
                                'PK' => $value->COST_CENTER,
                                'DESCRIPTION' => $this->deskripsi('CC',$value->COST_CENTER),
                                'APPROVAL_YEAR' => $value->APPROVAL_YEAR,
                                'PROGRAM_PLAN' => number_format($value->SUM_PROGRAM_PLAN),
                                'PROGRAM_BUDGET' =>  number_format($value->SUM_PROGRAM_BUDGET),
                                'APPR_REQ_PLAN' =>  number_format($value->SUM_APPR_REQ_PLAN),
                                'MRA_AVAIL_BUDGET' =>  number_format($value->SUM_MRA_AVAIL_BUDGET),
                                'ACTUAL' =>  number_format($value->SUM_ACTUAL),
                                'PERSEN' =>  number_format($value->PERSEN,2).' %',
                                "state"=> "closed"
                              )
                );
            }
            $ret = $row;
        }else if( strlen($id) == 6){
            $data = $this->treegridChild1CC($id);
            foreach ($data as $key => $value) {
                array_push(
                  $row, array(  'id'        => $value->CC_PK,
                                'parentId'  => $id,
                                'PK'  => $value->PK,
                                'DESCRIPTION' => '<span style="margin-left:20px"></span>'.$this->deskripsi('PK',$value->PK),
                                'PROGRAM_PLAN' => number_format($value->SUM_PROGRAM_PLAN),
                                'PROGRAM_BUDGET' =>  number_format($value->SUM_PROGRAM_BUDGET),
                                'APPR_REQ_PLAN' =>  number_format($value->SUM_APPR_REQ_PLAN),
                                'MRA_AVAIL_BUDGET' =>  number_format($value->SUM_MRA_AVAIL_BUDGET),
                                'ACTUAL' =>  number_format($value->SUM_ACTUAL),
                                "state"     => "closed"
                              )
                );
            }
            $ret = $row;
        }else if( strlen($id) == 11){

            $data = $this->treegridChild2CC($id);
            $count = 0;
            foreach ($data as $key => $value) {
                array_push(
                  $row, array(  'id' => $value->IM_POSITION,
                                'parentId' => $id,
                                'PK' => $value->IM_POSITION,
                                'DESCRIPTION' => '<span style="margin-left:30px"></span>'.$value->DESCRIPTION,
                                'PROGRAM_PLAN' => number_format($value->PROGRAM_PLAN),
                                'AR_DESCRIPTION' => $this->ar_deskripsi($value->IM_POSITION),
                                'PROGRAM_BUDGET' =>  number_format($value->PROGRAM_BUDGET),
                                'APPR_REQ_PLAN' =>  number_format($value->APPR_REQ_PLAN),
                                'MRA_AVAIL_BUDGET' =>  number_format($value->MRA_AVAIL_BUDGET),
                                'ACTUAL' =>  number_format($value->ACTUAL)
                              )
                );
                $count =$count+1;
            }
            $ret = $row;

        }

        return $ret;
    }
    public function treegridChild1CC($COST_CENTER = '111001')
    {
        $data = DB::table('laporanpk')
                    ->select( DB::RAW('MID( IM_POSITION, 1, 6 ) AS COST_CENTER' ),
                              DB::RAW('MID( IM_POSITION, 8, 4 ) AS PK' ),
                              DB::RAW('MID( IM_POSITION, 1, 11 ) AS CC_PK' ),
                              DB::RAW('sum(PROGRAM_PLAN) as SUM_PROGRAM_PLAN'),
                              DB::RAW('sum(PROGRAM_BUDGET) as SUM_PROGRAM_BUDGET'),
                              DB::RAW('sum(APPR_REQ_PLAN) as SUM_APPR_REQ_PLAN'),
                              DB::RAW('sum(MRA_AVAIL_BUDGET) as SUM_MRA_AVAIL_BUDGET'),
                              DB::RAW('sum(ACTUAL) as SUM_ACTUAL'),
                              'ID','DESCRIPTION','PROGRAM_PLAN','APPROVAL_YEAR',
                              'PROGRAM_BUDGET','APPR_REQ_PLAN','MRA_AVAIL_BUDGET','ACTUAL'
                            )
                    ->where( DB::RAW('MID( IM_POSITION, 1, 6 )' ),$COST_CENTER)
                    ->where( DB::RAW('MID( IM_POSITION, 8, 4 )' ),'<>','')
                    ->where( DB::RAW('LENGTH(IM_POSITION)' ),'=',19)
                    ->groupBy( DB::RAW('MID( IM_POSITION, 8, 4 )') )->get();
        return $data;
    }
    public function treegridChild2CC($PK)
    {
        $data = DB::table('laporanpk')
                ->where( DB::RAW('MID(IM_POSITION, 1, 11)'),$PK)
                ->where( DB::RAW('LENGTH(IM_POSITION)'),'>=',19 )
                ->where( 'APPROVAL_YEAR','<>','0000')
                ->where( 'APPROVAL_YEAR','<>','0')
                ->orderBy('IM_POSITION','ASC')
                ->get();
        return $data;
    }

    public function treegrid(Request $request)
    {
        $id = $request->input('id');
        $ret = '';
        $row = array();

        if(!$id){
            $data = DB::table('laporanpk')
                        ->select( DB::RAW('MID(IM_POSITION,8,4) as PK' ),
                                  DB::RAW('MID(IM_POSITION,1,11) as COST_CENTER'),
                                  DB::RAW('sum(PROGRAM_PLAN) as SUM_PROGRAM_PLAN'),
                                  DB::RAW('sum(PROGRAM_BUDGET) as SUM_PROGRAM_BUDGET'),
                                  DB::RAW('sum(APPR_REQ_PLAN) as SUM_APPR_REQ_PLAN'),
                                  DB::RAW('sum(MRA_AVAIL_BUDGET) as SUM_MRA_AVAIL_BUDGET'),
                                  DB::RAW('sum(ACTUAL) as SUM_ACTUAL'),
                                  DB::RAW('(sum(ACTUAL)/sum(PROGRAM_PLAN)*100) as PERSEN'),
                                  'ID','DESCRIPTION','PROGRAM_PLAN','APPROVAL_YEAR',
                                  'PROGRAM_BUDGET','APPR_REQ_PLAN','MRA_AVAIL_BUDGET','ACTUAL'
                                )
                        ->where( DB::RAW('MID(IM_POSITION,8,4)' ),'<>','')
                        ->where( DB::RAW('MID(IM_POSITION,8,4)' ),'<>','0')
                        ->where( DB::RAW('LENGTH(IM_POSITION)' ),'=',19)
                        ->groupBy( DB::RAW('MID( IM_POSITION, 8, 4 )') )->get();
                        // echo $data;
                        // die();
            foreach ($data as $key => $value) {
                array_push(
                  $row, array(  'id' => $value->PK,
                                'parentId' => 0,
                                'PK' => $value->PK,
                                'DESCRIPTION' => $this->deskripsi('PK',$value->PK),
                                'APPROVAL_YEAR' => $value->APPROVAL_YEAR,
                                'PROGRAM_PLAN' => number_format($value->SUM_PROGRAM_PLAN),
                                'PROGRAM_BUDGET' =>  number_format($value->SUM_PROGRAM_BUDGET),
                                'APPR_REQ_PLAN' =>  number_format($value->SUM_APPR_REQ_PLAN),
                                'MRA_AVAIL_BUDGET' =>  number_format($value->SUM_MRA_AVAIL_BUDGET),
                                'ACTUAL' =>  number_format($value->SUM_ACTUAL),
                                'PERSEN' =>  number_format($value->PERSEN,2).' %',
                                "state"=> "closed"
                              )
                );
            }
            $ret = $row;
        }else if( strlen($id) == 4){
            $data = $this->treegridChild1($id);
            foreach ($data as $key => $value) {
                array_push(
                  $row, array(  'id'        => $value->PK_CE,
                                'parentId'  => $id,
                                'PK'        => $value->CE,
                                'DESCRIPTION' => '<span style="margin-left:20px"></span>'.$value->DESCRIPTION,
                                'PROGRAM_PLAN' => number_format($value->SUM_PROGRAM_PLAN),
                                'PROGRAM_BUDGET' =>  number_format($value->SUM_PROGRAM_BUDGET),
                                'APPR_REQ_PLAN' =>  number_format($value->SUM_APPR_REQ_PLAN),
                                'MRA_AVAIL_BUDGET' =>  number_format($value->SUM_MRA_AVAIL_BUDGET),
                                'ACTUAL' =>  number_format($value->SUM_ACTUAL),
                                "state"     => "closed"
                              )
                );
            }
            $ret = $row;
        }else if( strlen($id) == 12){

            $data = $this->treegridChild2($id);
            $count = 0;
            foreach ($data as $key => $value) {
                array_push(
                  $row, array(  'id' => $value->IM_POSITION,
                                'parentId' => $id,
                                'PK' => $value->IM_POSITION,
                                'DESCRIPTION' => '<span style="margin-left:30px"></span>'.$value->DESCRIPTION,
                                'AR_DESCRIPTION' => $this->ar_deskripsi($value->IM_POSITION),
                                'PROGRAM_PLAN' => number_format($value->PROGRAM_PLAN),
                                'PROGRAM_BUDGET' =>  number_format($value->PROGRAM_BUDGET),
                                'APPR_REQ_PLAN' =>  number_format($value->APPR_REQ_PLAN),
                                'MRA_AVAIL_BUDGET' =>  number_format($value->MRA_AVAIL_BUDGET),
                                'ACTUAL' =>  number_format($value->ACTUAL)
                              )
                );
                $count =$count+1;
            }
            $ret = $row;

        }
        return $ret;
    }
    public function treegridChild1($PK = 'PK01')
    {
        $data = DB::table('laporanpk')
                    ->select( DB::RAW('MID( IM_POSITION, 8, 4 ) AS PK' ),
                              DB::RAW('MID( IM_POSITION, 13, 7 ) AS CE'),
                              DB::RAW('MID( IM_POSITION, 8, 12 ) AS PK_CE'),
                              DB::RAW('sum(PROGRAM_PLAN) as SUM_PROGRAM_PLAN'),
                              DB::RAW('sum(PROGRAM_BUDGET) as SUM_PROGRAM_BUDGET'),
                              DB::RAW('sum(APPR_REQ_PLAN) as SUM_APPR_REQ_PLAN'),
                              DB::RAW('sum(MRA_AVAIL_BUDGET) as SUM_MRA_AVAIL_BUDGET'),
                              DB::RAW('sum(ACTUAL) as SUM_ACTUAL'),
                              'ID','DESCRIPTION','PROGRAM_PLAN','APPROVAL_YEAR',
                              'PROGRAM_BUDGET','APPR_REQ_PLAN','MRA_AVAIL_BUDGET','ACTUAL'
                            )
                    ->where( DB::RAW('MID( IM_POSITION, 8, 4 )' ),$PK)
                    ->where( DB::RAW('MID( IM_POSITION, 14, 7 )' ),'<>','')
                    ->where( DB::RAW('LENGTH(IM_POSITION)' ),'=',19)
                    ->groupBy( DB::RAW('MID( IM_POSITION, 8, 12 )') )->get();
        return $data;
    }
    public function treegridChild2($PK_CE)
    {
        $data = DB::table('laporanpk')
                ->where( DB::RAW('MID(IM_POSITION, 8, 12)'),$PK_CE)
                ->where( DB::RAW('LENGTH(IM_POSITION)'),'>=',19 )
                ->where( 'APPROVAL_YEAR','<>','0000')
                ->where( 'APPROVAL_YEAR','<>','0')
                ->orderBy('IM_POSITION','ASC')
                ->get();
        return $data;
    }

    public function ar_deskripsi($IM_POSITION)
    {
        $data = DB::table('laporanpk')
                    ->where('IM_POSITION',$IM_POSITION)
                    ->orderBy('AR_DESCRIPTION','DESC')
                    ->limit(1)->get();
        return $data[0]->AR_DESCRIPTION;
    }
    public function deskripsi($de = 'PK', $key = 'PK01')
    {   
        if($de == 'PK'){
            $data = DB::table('laporanpk')
                    ->where( DB::RAW('LENGTH(IM_POSITION)'),'11' )
                    ->where( DB::RAW('MID( IM_POSITION, 8, 4 )'),$key )
                    ->groupBy( DB::RAW('MID( IM_POSITION, 8, 4 )') )->get();
        }else if($de == 'CC'){
            $data = DB::table('laporanpk')
                    ->where( DB::RAW('LENGTH(IM_POSITION)'),'6' )
                    ->where( DB::RAW('MID( IM_POSITION, 1, 6 )'),$key )
                    ->groupBy( DB::RAW('MID( IM_POSITION, 1, 6 )') )->get();
        }
        return $data[0]->DESCRIPTION;
    }
    public function lastUpdate()
    {
        $data = DB::table('laporanpk')->limit(1)->get();
        foreach ($data as $key => $data) {
            $lastUpdate = $data->DATELOAD;
        }
        $dateToTime = strtotime($lastUpdate);
        $date = date('d-m-Y H:i:s', $dateToTime);
        return $date;
    }
}
