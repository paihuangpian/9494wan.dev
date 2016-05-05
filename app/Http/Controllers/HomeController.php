<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $user = \Auth::user();
        
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


        // 获取当前等级的下一个等级
        $level_current = \DB::table('levels')->find(\DB::table('user_levels')->where('user_id', $user->id)->orderBy('id', 'desc')->first()->level_id);
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
        @$need_experience = $next_level->experience - $user->experience;

        return view('home', [
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
}
