<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\sys_user;
use App\sys_group;
use App\pmo_projectType;
use App\pmo_project;
use App\pmo_projectPlan;

class projectongoController extends Controller
{
   public function __construct ()
	{
	   date_default_timezone_set('Asia/Jakarta');
    }
    public function index(Request $request)
    {   
        $data_group     = $request->get('data_group');
        $data_menu      = $request->get('data_menu');
        $project_type   = $this->pmo_projectType();
        $project        = $this->pmo_project();
        $project_plan   = $this->pmo_projectPlan();
        $pmo_projectChild   = $this->pmo_projectChild();
        $pmo_projectPlanChild   = $this->pmo_projectPlanChild();
    	return view('project.projectOnGo',[ 'data_group'    =>$data_group, 
                                    'data_menu'     =>$data_menu,
                                    'project_type'  =>$project_type,
                                    'project'       =>$project,
                                    'project_plan'  =>$project_plan,
                                    'pmo_projectChild'      => $pmo_projectChild,
                                    'pmo_projectPlanChild'  => $pmo_projectPlanChild
                                ]);
    }
    public function pmo_projectType()
    {
        $data = new  pmo_projectType();
        return $data::orderBy('sort', 'asc')->get();
    }
    public function pmo_project()
    {
        $data = new  pmo_project();
        $return = $data::where('summary',1)
                    ->where('project_pid',0)
                    ->where('status',1)
                    ->orderBy('sort', 'asc')->get();
        return $return;
    }
    public function pmo_projectChild()
    {   
        $data = new  pmo_project();
        $pmo_project = $this->pmo_project();
        $ret = array();
        foreach ($pmo_project as $key => $value) {
            $return = $data::where('summary',1)
                    ->where('project_pid',$value->project_id)
                    ->orderBy('sort', 'asc')->get();
            array_push($ret, $return );
        }
        return $ret;
    }
    public function pmo_projectPlan()
    {
        $data = new  pmo_projectPlan();
        
        $ret = array();
        $pmo_project = $this->pmo_project();

        foreach ($pmo_project as $key => $value) {
            $return = $data::where('plan_actual','>=',0.01)
                                ->where('project_id',$value->project_id)
                                ->orderBy('plan_date','desc')->skip(0)->take(1)
                                ->get();
            array_push($ret, $return );
        }
        return $ret;
    }
    public function pmo_projectPlanChild()
    {
        $data = new  pmo_projectPlan();

        $ret = array();
        $pmo_projectChild = $this->pmo_projectChild();

        foreach ($pmo_projectChild as $key => $value) {
            foreach ($value as $key => $valdata) {
                $return = $data::where('plan_actual','>=',0.01)
                                ->where('project_id',$valdata->project_id)
                                ->orderBy('plan_date','desc')->skip(0)->take(1)
                                ->get();
                array_push($ret, $return );
            }
        }
        return $ret;
    }

    public function projectChart($project_id)
    {
        $data           = new  pmo_projectPlan();
        $label          = array();
        $plan_data      = array();
        $plan_actual    = array();
        $maxDate        = array();
        $val            = "";

        //count data
        $count = $data::where('project_id', $project_id)->get()->count();

        //get max date
        $plan_date = $data::select( DB::raw('max(plan_date) as label') )
                        ->where('project_id', $project_id)
                        ->groupBy(DB::raw('date_format(plan_date,"%Y-%m")') )
                        ->get();
        foreach ($plan_date as $key => $value) {
            array_push($maxDate,$value->label);
        }

        if($count >= 30){
            $chart = $data::select('plan_date as label','plan_data','plan_actual')
                        ->where('project_id', $project_id)
                        ->whereIn('plan_date', $maxDate)
                        ->orderBy('plan_date','asc')
                        ->get();
        }else{
            $chart = $data::select('plan_date as label','plan_data','plan_actual')
                        ->where('project_id', $project_id)
                        ->orderBy('plan_date','asc')
                        ->get();
        }

        
        foreach ($chart as $key => $value) {
            array_push($label,array('label' => date("d-M-Y",strtotime($value->label)) ) );
            array_push($plan_data,array('value' =>$value->plan_data) );
            if($value->plan_actual != '0.00' ){
                array_push($plan_actual,array('value' =>$value->plan_actual) );
            }
        }
        $ret =  [
                    ['category'     => $label ],
                    ['plan_data'    => $plan_data ],
                    ['plan_actual'  => $plan_actual ],
                    ['title'        => 'Full S-Curve Physical']  
                ];

        return $ret;
    }
}