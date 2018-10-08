<?php

namespace App\Http\Middleware;

use Closure;
use App\sys_group;
use App\sys_menu;

class checkMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $level = $request->session()->get('level');
        $nik = $request->session()->get('nik');
        $group_menu = new sys_group();
        $data_group = $group_menu::orderBy('group', 'ASC')->get();

        $menu = new sys_menu();
        $data_menu = $menu::where('nik_access','REGEXP', '[[:<:]]'.$nik.'[[:>:]]')->where('status','Y')->get();
        // $data_menu = $menu::where('level','like', '%'.$level.'%')->get();

        foreach ($data_group as $key => $value) {
            $jumlah_menu = $menu::where('node_group',$value->node_group)
                                ->where('status','Y')
                                ->where('nik_access','REGEXP', '[[:<:]]'.$nik.'[[:>:]]')
                                ->count();
            $data_group[$key]['count'] = $jumlah_menu;
        }

        $request->merge(['data_group'=>$data_group, 'data_menu'=>$data_menu]);
        return $next($request);
    }
}
