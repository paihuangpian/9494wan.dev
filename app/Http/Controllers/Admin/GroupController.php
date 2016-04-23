<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class GroupController extends Controller
{   
    // 递归
    static public function groups($array, $pid = 0){
        $arr = [];
        foreach($array as $v){
            if($v->pid == $pid){
                $v->child = self::groups($array, $v->id);
                $arr[] = $v;
            }
        }
        return $arr;
    }

    public function index(){
        // \DB::setFetchMode(\PDO::FETCH_ASSOC);
    	$groups = \DB::table('groups')->get();
        $groups =  self::groups($groups);
        // dd($groups);

    	return view('admin.group.index', ['groups' => $groups]);
    }

    public function addGroup(){
    	$groups = \DB::table('groups')->where('level', 1)->get();
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
        $insert['created_at'] = date('Y-m-d H:i:s');
    	\DB::table('groups')->insert(
            $insert
		);

		return redirect()->back();
    }
    public function editGroup(){
        $groups = \DB::table('groups')->where('level', 1)->get();
        $group = \DB::table('groups')->find($_GET['id']);
        return view('admin.group.edit', ['group' => $group, 'groups' => $groups]);
    }

    public function updateGroup(Request $request){

        $info = [
            'name.required' => '名称一定要填写',
        ];

        $validator = \Validator::make($request->all(), [
            'name' => 'required'
        ], $info);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $update = array_except($request->all(), ['_token']);
        $update['created_at'] = date('Y-m-d H:i:s');
        \DB::table('groups')->where('id', $request->input('id'))->update(
            $update
        );

        return redirect()->back();
    }

    public function delGroup(Request $request){
        // 判断小组性质
        $group = \DB::table('groups')->find($request->input('id'));
        if($group->level == 1){
            $groups = \DB::table('groups')->where('pid', $request->input('id'))->get();
            if($groups){
                foreach($groups as $group){
                    \DB::table('groups')->delete($group->id);
                    // 清除该小组所有成员的关系
                    $users = \DB::table('users')->where('group_id', $group->id)->get();
                    if($users){
                        foreach($users as $user){
                            \DB::table('users')->where('id', $user->id)->update(
                                ['group_id' => null]
                            );
                        }
                    }

                }
            }
        }else{
            // 清除该小组所有成员的关系
            $users = \DB::table('users')->where('group_id', $request->input('id'))->get();
            if($users){
                foreach($users as $user){
                    \DB::table('users')->where('id', $user->id)->update(
                        ['group_id' => null]
                    );
                }
            }
        }

        \DB::table('groups')->delete($request->input('id'));
        return redirect()->back();
    }

    public function getUsers(){
        $users = \DB::table('users')->get();
        return response()->json($users);
    }

     public function searchUsers(Request $request){
        $users = \DB::table('users')->where('name', 'like', '%' . $request->input('name') . '%')->get();
        if(!$users){
            $users = [
                'name' => '没有此员工'
            ];
        }
        return response()->json($users);
    }
}
