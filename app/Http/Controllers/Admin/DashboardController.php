<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{	
    public function index(){
    	$current_month = \DB::select("select sum(recharge) as total from records where date_format(created_at,'%Y-%m')=date_format(now(),'%Y-%m')");
    	$last_month = \DB::select("select sum(recharge) as total from records where date_format(created_at,'%Y-%m')=date_format(DATE_SUB(curdate(), INTERVAL 1 MONTH),'%Y-%m')");

    	$persons = \DB::select("select *, (@i := @i + 1) rank from users,(SELECT @i:=0) AS it order by experience desc");
        $groups = \DB::select("select group_id, sum(recharge) as total, (@i := @i + 1) rank from records,(SELECT @i:=0) AS it group by group_id order by total desc");

    	return view('admin.dashboard.index', [
    		'current_month' => $current_month,
    		'last_month' => $last_month,
    		'persons' => $persons,
    		'groups' => $groups
    	]);
    }
}
