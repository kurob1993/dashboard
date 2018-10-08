<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\rkap;
class rkapController extends Controller
{
	public function __construct ()
	{
		
	}
	public function index(Request $request)
	{
		$data_group = $request->get('data_group');
        $data_menu = $request->get('data_menu');
		return view('rkap',['data_group'=>$data_group, 'data_menu'=>$data_menu]);
	}
	public function save(Request $request)
	{
		$rkap = new rkap;
		$rkap->tahun = $request->tahun;
		$rkap->target = $request->target;
		$res = $rkap->save();
		if($res){
			return redirect()->back();
		}
	}
	public function upload(Request $request)
	{
		$file = $request->file('file');

		//Display File Name
		echo 'File Name: '.$file->getClientOriginalName();
		echo '<br>';

		//Display File Extension
		echo 'File Extension: '.$file->getClientOriginalExtension();
		echo '<br>';

		//Display File Real Path
		echo 'File Real Path: '.$file->getRealPath();
		echo '<br>';

		//Display File Size
		echo 'File Size: '.$file->getSize();
		echo '<br>';

		//Display File Mime Type
		echo 'File Mime Type: '.$file->getMimeType();

		//Move Uploaded File
		$destinationPath = 'uploads';
		$file->move($destinationPath,$file->getClientOriginalName());
	}
}
