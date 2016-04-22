<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index(){
    	if(isset($_GET['name'])){
			$users = \DB::table('users')->where('name', 'like', '%' . $_GET['name'] . '%')->paginate(15);
			$key = $_GET['name'];
			$response = ['users' => $users, 'key' => $key];
		}else{
			$users = \DB::table('users')->paginate(15);
			$response = ['users' => $users];
		}
    	
    	return view('admin.user.index', $response);
    }

    public function addUser(){
    	$groups = \DB::table('groups')->where('status', 1)->get();
    	// $groups = \DB::table('groups')->whereStatusAndLevel(1, 2)->get();
    	$groups = GroupController::groups($groups);
    	return view('admin.user.addUser', ['groups' => $groups]);
    }

    public function postUser(Request $request){
    	$info = [
    		'name.required' => '姓名不能为空',
    		'name.unique' => '姓名重复了',
    		// 'username.required' => '用户名不能为空',
    		// 'username.unique' => '用户名重复了',
    		'role_id.required' => '角色不能为空'
    	];

	    $validator = \Validator::make($request->all(), [
        	'name' => 'required|unique:users',
        	// 'username' => 'required|unique:users',
        	'role_id' => 'required'
	    ], $info);

	    if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $insert = array_except($request->all(), ['_token']);
        $password = str_random(6);
        $insert['password'] = bcrypt($password);
        $insert['created_at'] = date('Y-m-d H:i:s');
    	\DB::table('users')->insert(
            $insert
		);

		return redirect()->back()->withErrors(['errors' => '刚才所添加的用户密码是：' . $password]);
    }
}
