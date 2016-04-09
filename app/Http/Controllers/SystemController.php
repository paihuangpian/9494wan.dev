<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class SystemController extends Controller
{
    public function index(){
        $menus = \DB::table('menus')->where('status', 1)->get();
        return view('admin.system.index', ['menus' => $menus]);
    }

    public function addMenu(){
        $menus = \DB::table('menus')->where('status', 1)->get();
        return view('admin.system.addMenu', ['menus' => $menus]);
    }

    public function postMenu(Request $request){
        $info = [
    		'name.required' => '菜名一定要填写',
    		'name.unique' => '菜名重复了'
    	];

	    $validator = \Validator::make($request->all(), [
        	'name' => 'required|unique:menus'
	    ], $info);

	    if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $insert = array_except($request->all(), ['_token']);

    	\DB::table('menus')->insert(
            $insert
		);

		return redirect()->back();
    }
}
