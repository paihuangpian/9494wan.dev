<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class GroupAdminController extends Controller
{
    public function index(){

    	$group_id = \Auth::user()->group_id;

    	$users = \DB::table('users')->where('group_id', $group_id)->orderBy('experience')->get();
    	$total = 0;
    	$today = 0;
    	$yesterday = 0;
    	$records = [];
    	$yesterday_time = date('Y-m-d', (time() - 3600 * 24));
    	$current_month = \DB::select("select * from records where date_format(created_at,'%Y-%m')=date_format(now(),'%Y-%m')");
    	$last_month = \DB::select("select * from records where date_format(created_at,'%Y-%m')=date_format(DATE_SUB(curdate(), INTERVAL 1 MONTH),'%Y-%m')");

    	$total = \DB::table('records')->where('group_id', $group_id)->sum('recharge');
    	$records = \DB::table('records')->where('group_id', $group_id)->limit(10)->orderBy('id', 'aesc')->get();
    	$today = \DB::table('records')->whereGroup_idAndCreated_at($group_id, date('Y-m-d'))->sum('recharge');
    	$yesterday = \DB::table('records')->whereGroup_idAndCreated_at($group_id, $yesterday_time)->sum('recharge');
    	$current_month = \DB::select("select sum(recharge) as total from records where date_format(created_at,'%Y-%m')=date_format(now(),'%Y-%m') and group_id = " . $group_id);
    	$last_month = \DB::select("select sum(recharge) as total from records where date_format(created_at,'%Y-%m')=date_format(DATE_SUB(curdate(), INTERVAL 1 MONTH),'%Y-%m')and group_id = " . $group_id);

        // 排行
        $rank_array = \DB::select("select group_id, sum(recharge) as total, (@i := @i + 1) rank from records,(SELECT @i:=0) AS it group by group_id order by total");
        $rank = 0;
        
        foreach ($rank_array as $key => $value) {
             if($value->group_id == $group_id){
                     $rank = $value->rank;
             }
        }
    	return view('groupAdmin', [
    		'users' => $users, 
    		'total' => $total,
    		'today' => $today,
    		'records' => $records, 
    		'yesterday' => $yesterday,
    		'current_month' => $current_month,
    		'last_month' => $last_month,
            'rank' => $rank
    	]);
    }

    public function addRecord(){
    	$group_id = \Auth::user()->group_id;
		$group_users = \DB::table('users')->where('group_id', $group_id)->get();
    	return view('addRecord', ['group_users' => $group_users]);
    }

    public function postRecord(Request $request){
        $info = [
    		'recharge.required' => '战绩一定要填写',
    	];

	    $validator = \Validator::make($request->all(), [
        	'recharge' => 'required'
	    ], $info);

	    if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $insert = array_except($request->all(), ['_token']);
        $insert['created_at'] = date('Y-m-d');
        $insert['group_id'] = \Auth::user()->group_id;
    	\DB::table('records')->insert(
            $insert
		);

    	// 更新经验值和积分
    	\DB::table('users')->where('id', $request->input('user_id'))->increment('experience', $request->input('recharge'));
    	\DB::table('users')->where('id', $request->input('user_id'))->increment('scores', $request->input('recharge'));

        $experience = \DB::table('users')->find($request->input('user_id'))->experience;

        $level = \DB::select("select * from levels where " . $experience . " >= experience and " . $experience . " <= experience_max");
        if($level){
            \DB::table('users')->where('id', $request->input('user_id'))->update(['level_id' => $level[0]->id]);
        }

		return redirect()->back();
    }

    public function getUser(Request $request){
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

    	return view('getUser', [
            'user' => $user, 
            'rank' => $rank,
            'total' => $total,
            'records' => $records,
            'today' => $today,
            'yesterday' => $yesterday,
            'current_month' => $current_month,
            'last_month' => $last_month,
            ]);
    }

    public function addUser(){
        
        $users = \DB::table('users')->where('group_id', 0)->get();
        return view('addUser', ['users' => $users]);
    }

    public function postAddUser(Request $request){
        $group_id = \Auth::user()->group_id;
        $info = [
            'user_id.required' => '一定要选择一个兵',
        ];

        $validator = \Validator::make($request->all(), [
            'user_id' => 'required'
        ], $info);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
      
        \DB::table('users')->where('id', $request->input('user_id'))->update(['group_id' => $group_id]);

        return redirect()->back();
    }
}
