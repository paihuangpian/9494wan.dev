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
    	$groups = GroupController::groups($groups);
    	return view('admin.user.addUser', ['groups' => $groups]);
    }

    public function postUser(Request $request){
    	$info = [
    		'name.required' => '姓名不能为空',
    		'name.unique' => '姓名重复了',
    		'role_id.required' => '角色不能为空',
    	];

	    $validator = \Validator::make($request->all(), [
        	'name' => 'required|unique:users',
        	'role_id' => 'required',
	    ], $info);

	    if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $insert = array_except($request->all(), ['_token']);
        $password = str_random(6);
        $insert['password'] = bcrypt($password);
        $insert['random'] = $password;
        $insert['created_at'] = date('Y-m-d H:i:s');

        // 判断用户经验值，确定等级
        $experience = $request->input('experience');
        $level = \DB::select("select * from levels where " . $experience . " >= experience and " . $experience . " <= experience_max");

        $insert['level_id'] = $level[0]->id;

    	$user_id = \DB::table('users')->insertGetId(
            $insert
		);

		return redirect()->back()->withErrors(['errors' => '刚才所添加的用户密码是：' . $password]);
    }

    public function editUser(){
        $groups = \DB::table('groups')->where('status', 1)->get();
        $groups = GroupController::groups($groups);
        $user = \DB::table('users')->find($_GET['id']);
        return view('admin.user.edit', ['user' => $user, 'groups' => $groups]);
    }

    public function updateUser(Request $request){
        $info = [
            'name.required' => '姓名不能为空',
        ];

        $validator = \Validator::make($request->all(), [
            'name' => 'required',
        ], $info);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $update = array_except($request->all(), ['_token']);
        
        $update['updated_at'] = date('Y-m-d H:i:s');

        // 判断用户经验值，确定等级
        $experience = $request->input('experience');
        $level = \DB::select("select * from levels where " . $experience . " >= experience and " . $experience . " <= experience_max");

        $update['level_id'] = $level[0]->id;
        

        \DB::table('users')->where('id', $request->input('id'))->update(
            $update
        );

        return redirect()->back();
    }

    public function delUser(Request $request){
        \DB::table('user_levels')->where('user_id', $request->input('id'))->delete();
        \DB::table('records')->where('user_id', $request->input('id'))->delete();
        \DB::table('users')->delete($request->input('id'));
        return redirect()->back();
    }

    public function getExperience(Request $request){
        $user = \DB::table('users')->find($request->route('user_id'));

        // 排行
        $rank_array = \DB::select("select *, (@i := @i + 1) rank from users,(SELECT @i:=0) AS it order by experience desc");

        foreach ($rank_array as $key => $value) {
            if($value->id == $user->id){
                $rank = $value->rank;
            }
        }

        \DB::table('users')->where('id', $user->id)->update(['rank' => $rank]);
        $yesterday_time = date('Y-m-d', (time() - 3600 * 24));
        $total = \DB::table('records')->where('user_id', $user->id)->sum('recharge');
        $records = \DB::table('records')->where('user_id', $user->id)->limit(10)->orderBy('id', 'aesc')->get();
        $today = \DB::table('records')->whereUser_idAndCreated_at($user->id, date('Y-m-d'))->sum('recharge');
        $yesterday = \DB::table('records')->whereUser_idAndCreated_at($user->id, $yesterday_time)->sum('recharge');
        $current_month = \DB::select("select sum(recharge) as total from records where date_format(created_at,'%Y-%m')=date_format(now(),'%Y-%m') and user_id = " . $user->id);
        $last_month = \DB::select("select sum(recharge) as total from records where date_format(created_at,'%Y-%m')=date_format(DATE_SUB(curdate(), INTERVAL 1 MONTH),'%Y-%m')and user_id = " . $user->id);

        if($user->level_id){
            // 获取当前等级的下一个等级
            $level_current = \DB::table('levels')->find($user->level_id);
            $levels = \DB::table('levels')->get();

            $next_levels = [];
            foreach ($levels as $key => $level) {
                if($level->experience > $level_current->experience){
                    $next_levels[] = $level;
                }
            }
            $next_level = array_first($next_levels, function($key, $value){
                return $value;
            });
        }
        @$need_experience = $next_level->experience - $user->experience;
        
        return view('admin.user.getExperience', [
            'user' => $user, 
            'rank' => $rank,
            'total' => $total,
            'records' => $records,
            'today' => $today,
            'yesterday' => $yesterday,
            'current_month' => $current_month,
            'last_month' => $last_month,
            'need_experience' => $need_experience
            ]);
    }

    public function delExperience(Request $request){
        \DB::table('records')->delete($request->input('id'));
        return redirect()->back();
    }
}
