@extends('layouts.master')

@section('content')
    
    <h2>小组</h2>
    <p>
        今日战绩：{{ $today }}<span class="sep">/</span>
        昨日战绩：{{ $yesterday }}<span class="sep">/</span>
        本月战绩：{{ $current_month[0]->total }}<span class="sep">/</span>
        上月战绩：{{ $last_month[0]->total }}<span class="sep">/</span>
        小组排行：{{ $rank }}<span class="sep">/</span>
        小组总战绩：{{ $total }}
    </p>
    
    <h2>组员</h2>
    <p> 
        @foreach($users as $key => $user)
            <a href="">{{ $key + 1 }}-{{ $user->name }} <span class="red">↓</span></a>
        @endforeach
    </p>
    <h2>战绩
        <a href="{{ route('addRecord') }}" style="position:absolute;margin-top:6px;font-size: 14px;margin-left: 10px;background-color: #e7e77e;border:solid 1px #c5c55c;padding: 2px 4px;color:#333">+ 记战功</a>
    </h2>
    <p>
        <table>
            <tr><th>组员</th><th>战绩</th><th>时间</th></tr>
            @foreach($records as $record)
                <tr>
                    <td>{{ \DB::table('users')->find($record->user_id)->name }}</td>
                    <td>{{ $record->recharge }}</td>
                    <td>{{ date('Y-m-d', time($record->created_at)) }}</td>
                </tr>
            @endforeach
        </table>
    </p>
   
@endsection
