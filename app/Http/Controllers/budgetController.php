<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\sys_user;
use App\sys_group;
use App\pmo_projectType;
use App\pmo_project;
use App\pmo_project_budget;
use App\pmo_kurs;

class budgetController extends Controller
{
    public function index(Request $request)
    {
        $data_group      = $request->get('data_group');
        $data_menu       = $request->get('data_menu');
        $pmo_projecttype = $this->pmo_projecttype();
        $pmo_kurs        = $this->pmo_kurs();
        return view('project.projectBudget',
                [
                    'data_group'        => $data_group, 
                    'data_menu'         => $data_menu,
                    'pmo_kurs'          => $pmo_kurs
                ]
        );
    }

    public function pmo_projecttype()
    {
        $data = new pmo_projectType();
        $ret = $data::all();

        return $ret;
    }
    
    public function pmo_kurs($thn = null)
    {
        $kurs = new pmo_kurs();
        if($thn == null){
            $thn = date('Y');
            $kurs_ret = $kurs::all();
        }else{
            $kurs_ret = $kurs::select('kurs_value')->where('kurs_tahun',$thn)->get();
        }
        
        return $kurs_ret;
    }
    public function pmo_project($projecttype_id,$thn)
    {   
        if($thn == null){
            $thn = date('Y');
        }

        $q= "SELECT distinct b.project_id, a.project_name, a.wbs, a.projecttype_id from pmo_project_budget b, pmo_project a 
            where a.projecttype_id='$projecttype_id' and a.project_pid=0 and b.rkap_year='$thn' 
            and a.project_id=b.project_id and b.status=1 order by a.sort";
        $ret = DB::select($q);

        return $ret;
    }
    public function budget_idr($project_id,$thn)
    {
        if($thn == null){
            $thn = date('Y');
        }

        $q= "SELECT * from pmo_project_budget 
            where rkap_year='$thn' and project_id='$project_id'
            and curr='IDR' and status=1 limit 0,1";
        $ret = DB::select($q);

        return $ret;
    }
    public function budget_usd($project_id,$thn)
    {
        if($thn == null){
            $thn = date('Y');
        }

        $q= "SELECT * from pmo_project_budget 
            where rkap_year='$thn' and project_id='$project_id'
            and curr='USD' and status=1 limit 0,1";
        $ret = DB::select($q);

        return $ret;
    }
    public function budget($thn = null)
    {   $now = date('Y');
        $label = array();
        $title = array();
        $value_anggaran_idr = array();
        $value_anggaran_usd = array();
        $value_realisasi_idr= array();
        $value_deviasi_idr  = array();
        // get type project
        $pmo_projectType     = new pmo_projectType();
        $pmo_projectType_val = $pmo_projectType::orderBy('sort')->get();
        
        //kurs
        $kurs = $this->pmo_kurs($thn); 

        //get list project
        foreach ($pmo_projectType_val as $key => $value) {            
            $project = $this->pmo_project($value->projecttype_id,$thn);

            foreach ($project as $key => $value_a) {
                $anggaran_idr = $this->budget_idr($value_a->project_id,$thn);
                $anggaran_usd = $this->budget_usd($value_a->project_id,$thn);

                //Ambil data realisasi RKAP TOTAL/SD
                if($value_a->wbs){
                    $pmo_anggaran = DB::select("SELECT * from pmo_anggaran 
                                                where wbs='$value_a->wbs' 
                                                and tahun = '$thn' 
                                                order by ts desc limit 0,1");

                    if($thn == $now){

                        $pmo_anggaranall =DB::select("SELECT * from pmo_anggaranall where wbs='$value_a->wbs' 
                                                      order by ts desc limit 0,1");
                        
                        foreach ($pmo_anggaranall as $key => $value_realisasiall) {
                            $realisasi_idr = $value_realisasiall->realisasiall_idr/1000;
                            $realisasi_usd = $value_realisasiall->realisasiall_usd/1000;
                        }

                    }else{

                        $realarray_idr =array();
                        $realarray_usd =array();

                        for($ii=2011;$ii<=$thn;$ii++){

                           $pmo_anggaran = DB::select("SELECT * from pmo_anggaran 
                                                        where wbs='$value_a->wbs' 
                                                        and tahun = '$ii' 
                                                        order by ts desc limit 0,1");

                           foreach ($pmo_anggaran as $key => $value_realisasi) {
                                $realarray_idr[]=$value_realisasi->realisasi_idr;
                                $realarray_usd[]=$value_realisasi->realisasi_usd;
                            }

                        }

                        $realisasi_idr = array_sum($realarray_idr)/1000;
                        $realisasi_usd = array_sum($realarray_usd)/1000;

                        $realarray_idr='';
                        $realarray_usd='';

                    }
                }else{

                    foreach ($anggaran_idr as $key => $value_realisasi) {
                       $realisasi_idr = $value_realisasi->realisasi_value/1000;
                    }
                    foreach ($anggaran_usd as $key => $value_realisasi) {
                       $realisasi_usd = $value_realisasi->realisasi_value/1000;
                    }

                }
                
                //ambil data angaran RKAP TOTAL/SD
                if($thn == "2011" || $thn == "2012" || $thn == "2013"){
                    foreach ($anggaran_idr as $key => $valueb) {
                        $anggaran_idr = $valueb->rkap;
                        $anggaran_usd = $valueb->rkap/$kurs[0]->kurs_value/1000;

                        $anggaran_idr = ($anggaran_idr);
                        $anggaran_usd = ($anggaran_usd);
                    }
                }else{
                    foreach ($anggaran_usd as $key => $valueb) {
                        $anggaran_usd = $valueb->rkap/1000;
                        $anggaran_idr = $valueb->rkap*$kurs[0]->kurs_value/1000;

                        $anggaran_usd = ($anggaran_usd);
                        $anggaran_idr = ($anggaran_idr);
                    }
                }

                array_push($label, [
                    "projecttype_id" => $value_a->projecttype_id,
                    "label" => $value_a->project_name."-".$value_a->wbs
                ]); 
                
                array_push($value_anggaran_idr, [
                    "projecttype_id" => $value_a->projecttype_id,
                    "value" => $anggaran_idr
                ]); 
                array_push($value_anggaran_usd, [
                    "projecttype_id" => $value_a->projecttype_id,
                    "value" => $anggaran_usd
                ]);
                array_push($title, [
                    "projecttype_id" => $value->projecttype_id,
                    "title" => $value->projecttype_name
                ]);
                array_push($value_realisasi_idr, [
                    "projecttype_id" => $value->projecttype_id,
                    "value" => $realisasi_idr
                ]);
                array_push($value_deviasi_idr, [
                    "projecttype_id" => $value->projecttype_id,
                    "value" => (int)$anggaran_idr-(int)$realisasi_idr
                ]);               
            }       

            $return         = array();
            $ang_idr        = array(); 
            $ang_usd        = array();
            $real_idr       = array();
            $type           = array();
            $deviasi_idr    = array();  

            foreach ( $label as $value ) {
                $return[$value['projecttype_id']][] = $value;
            }
            foreach ( $value_anggaran_idr as $value_a ) {
                $ang_idr[$value_a['projecttype_id']][] = $value_a;
            }
            foreach ( $value_anggaran_usd as $value_b ) {
                $ang_usd[$value_b['projecttype_id']][] = $value_b;
            }
            foreach ( $title as $value_c ) {
                $type[$value_c['projecttype_id']][] = $value_c;
            }
            foreach ( $value_realisasi_idr as $value_d ) {
                $real_idr[$value_d['projecttype_id']][] = $value_d;
            }
            foreach ( $value_deviasi_idr as $value_e ) {
                $deviasi_idr[$value_e['projecttype_id']][] = $value_e;
            }
        }

        $ret = 
        [
            "label"             =>$return,
            "title"             =>$type,
            "anggaran_idr"      => $ang_idr,
            "anggaran_usd"      => $ang_usd,
            "realisasi_idr"     => $real_idr,
            "deviasi_idr"       => $deviasi_idr,
        ];
        return $ret;
        
    }
}
