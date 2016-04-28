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

    	// foreach($users as $user){
    	// 	$total += \DB::table('records')->where('user_id', $user->id)->sum('recharge');
    	// 	$today += \DB::table('records')->whereUser_idAndCreated_at($user->id, date('Y-m-d'))->sum('recharge');
    	// 	$yesterday += \DB::table('records')->whereUser_idAndCreated_at($user->id, $yesterday_time)->sum('recharge');
    	// 	$records = array_merge(\DB::table('records')->where('user_id', $user->id)->limit(10)->get(), $records);
    	// }

    	$total = \DB::table('records')->where('group_id', $group_id)->sum('recharge');
    	$records = \DB::table('records')->where('group_id', $group_id)->limit(10)->get();
    	$today = \DB::table('records')->whereGroup_idAndCreated_at($group_id, date('Y-m-d'))->sum('recharge');
    	$current_month = \DB::select("select sum(recharge) as total from records where date_format(created_at,'%Y-%m')=date_format(now(),'%Y-%m') and group_id = " . $group_id);
    	$last_month = \DB::select("select sum(recharge) as total from records where date_format(created_at,'%Y-%m')=date_format(DATE_SUB(curdate(), INTERVAL 1 MONTH),'%Y-%m')and group_id = " . $group_id);

    	$rank_array = \DB::select("select group_id, sum(recharge) as total, (@i := @i + 1) rank from records,(SELECT @i:=0) AS it where group_id = " . $group_id ." group by group_id order by total");

    	$rank = $rank_array[0]->rank;

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

		return redirect()->back();
    }
}
