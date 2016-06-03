<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{	
    public function index(){
        $yesterday_time = date('Y-m-d', (time() - 3600 * 24));
    	$current_month = \DB::select("select sum(recharge) as total from records where date_format(created_at,'%Y-%m')=date_format(now(),'%Y-%m')");
    	$last_month = \DB::select("select sum(recharge) as total from records where date_format(created_at,'%Y-%m')=date_format(DATE_SUB(curdate(), INTERVAL 1 MONTH),'%Y-%m')");

    	$persons = \DB::select("select *, (@i := @i + 1) rank from users,(SELECT @i:=0) AS it order by experience desc");
        $groups = \DB::select("select group_id, sum(recharge) as total, (@i := @i + 1) rank from records,(SELECT @i:=0) AS it group by group_id order by total desc limit 0, 10");

        $records = \DB::table('records')->limit(10)->get();

        $yesterday_persons = \DB::select("select *, sum(recharge) as total from records where created_at = '" . $yesterday_time . "' group by user_id order by total desc limit 0, 10");
        $yesterday_groups = \DB::select("select *, sum(recharge) as total from records where created_at = '" . $yesterday_time . "' group by group_id order by total desc");

        $last_month_persons = \DB::select("select *, sum(recharge) as total from records where date_format(created_at,'%Y-%m')=date_format(DATE_SUB(curdate(), INTERVAL 1 MONTH),'%Y-%m') group by user_id order by total desc");
        $last_month_groups = \DB::select("select *, sum(recharge) as total from records where date_format(created_at,'%Y-%m')=date_format(DATE_SUB(curdate(), INTERVAL 1 MONTH),'%Y-%m') group by group_id order by total desc");

        $todays = \DB::select("select *, sum(recharge) as total from records where created_at = '" . date('Y-m-d', time()) . "' group by user_id order by total desc limit 0, 10");
        $today_groups = \DB::select("select *, sum(recharge) as total from records where created_at = '" . date('Y-m-d', time()) . "' group by group_id order by total desc");

    	return view('admin.dashboard.index', [
    		'current_month' => $current_month,
    		'last_month' => $last_month,
    		'persons' => $persons,
    		'groups' => $groups,
            'records' => $records,
            'yesterday_persons' => $yesterday_persons,
            'yesterday_groups' => $yesterday_groups,
            'last_month_persons' => $last_month_persons,
            'last_month_groups' => $last_month_groups,
            'todays' => $todays,
            'today_groups' => $today_groups
    	]);
    }
}
