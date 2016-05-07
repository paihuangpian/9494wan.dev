@extends('layouts.master')

@section('content')
    
    <h2>小组</h2>
    <p>
        今日战绩：<span class="origin">{{ $today }}</span><span class="sep"></span>
        昨日战绩：<span class="origin">{{ $yesterday }}</span><span class="sep"></span>
        本月战绩：<span class="origin">{{ $current_month[0]->total }}</span><span class="sep"></span>
        上月战绩：<span class="origin">@if($last_month[0]->total) {{ $last_month[0]->total }} @else 暂无 @endif</span><span class="sep"></span>
        小组排行：<span class="origin">{{ $rank }}</span><span class="sep"></span>
        小组总战绩：<span class="origin">{{ $total }}</span>
    </p>
    
    <h2>组员
    <a href="{{ route('addUser') }}" style="position:absolute;margin-top:6px;font-size: 14px;margin-left: 10px;background-color: #ff7518;border:solid 1px #ee6407;padding: 2px 4px;color: #fff">+ 招兵</a>
    </h2>
    <p> 
        @foreach($users as $key => $user)
            <a href="{{ route('getUser', ['user_id' => $user->id]) }}">{{ $user->name }}</a>
        @endforeach
    </p>
    <h2>战绩
        <!-- <a href="{{ route('addRecord') }}" style="position:absolute;margin-top:6px;font-size: 14px;margin-left: 10px;background-color: #ff7518;border:solid 1px #ee6407;padding: 2px 4px;color: #fff">+ 记战功</a> -->
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
