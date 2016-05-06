@extends('layouts.master')

@section('content')
<h2>概览</h2>
<p>
    <span class="origin">今日：</span>{{ \DB::table('records')->whereCreated_at(date('Y-m-d'))->sum('recharge') }}<span class="sep"></span>
    <span class="origin">昨日：</span>{{ \DB::table('records')->whereCreated_at(date('Y-m-d', (time() - 3600 * 24)))->sum('recharge') }} <span class="sep"></span>
    <span class="origin">本月：</span>{{ $current_month[0]->total or '暂无数据' }}<span class="sep"></span>
    <span class="origin">上月：</span>{{ $last_month[0]->total or '暂无数据' }}<span class="sep"></span>
</p>
<h2>榜单</h2>
<div style="width: 49%;float: left;">
    <div style="height: 50px;line-height: 50px;text-align: left">英雄榜</div>
    <table>
        <tr><th>榜</th><th>军徽</th><th>英雄</th><th>总战功</th></tr>
        @foreach($persons as $key => $person)
        <tr>
            <td>@if(($key + 1) == 1) 冠军 @elseif(($key + 1) == 2) 亚军 @elseif(($key + 1) == 3) 季军 @else  {{ $key + 1 }}  @endif</td>
            <td>@if($person->level_id)<img src="/images/sign/{{ \DB::table('levels')->find($person->level_id)->sign }}" width="30">@endif</td>
            <td>{{ $person->name }} </td>
            <td>{{ $person->experience }}</td>
        </tr>
        @endforeach
    </table>
</div>
<div style="width: 49%;float: right;">
    <div style="height: 50px;line-height: 50px;text-align: left;">军团榜</div>
    <table>
        <tr><th>军团</th><th>总战功</th></tr>
        @foreach($groups as $group)
        <tr>
            <td>@if($group->group_id) {{ \DB::table('groups')->find($group->group_id)->name }} @else 未知 @endif</td>
            <td>{{ $group->total }}</td>
        </tr>
        @endforeach
    </table>
</div>
<div style="clear:both;"></div>
@endsection
