<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class GroupController extends Controller
{   

    static public function groups($array, $pid = 0){
        $arr = [];
        foreach($array as $v){
            
            if($v->pid == $pid){
                $v->child = self::groups($array, $v->id);
                $arr = $v;
            }
        }
        return $arr;
    }

    public function index(){
        // \DB::setFetchMode(\PDO::FETCH_ASSOC);
    	$groups = \DB::table('groups')->get();
        $groups =  self::groups($groups);
        dd($groups);

    	return view('admin.group.index', ['groups' => $groups]);
    }

    public function addGroup(){
    	$groups = \DB::table('groups')->get();
    	return view('admin.group.addGroup', ['groups' => $groups]);
    }

    public function postGroup(Request $request){
        $info = [
    		'name.required' => '名称一定要填写',
    		'name.unique' => '名称重复了'
    	];

	    $validator = \Validator::make($request->all(), [
        	'name' => 'required|unique:groups'
	    ], $info);

	    if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $insert = array_except($request->all(), ['_token']);

    	\DB::table('groups')->insert(
            $insert
		);

		return redirect()->back();
    }
}
