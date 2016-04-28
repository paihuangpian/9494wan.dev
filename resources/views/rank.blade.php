@extends('layouts.master')

@section('content')
<div style="width: 49%;float: left;">
    <div style="height: 50px;line-height: 50px;text-align: center;">英雄榜</div>
    <table>
        <tr><th>榜</th><th>军徽</th><th>英雄</th><th>总战功</th></tr>
        @foreach($persons as $key => $person)
        <tr>
            <td>@if(($key + 1) == 1) 冠军 @elseif(($key + 1) == 2) 亚军 @elseif(($key + 1) == 3) 季军 @endif</td>
            <td><img src="/images/sign/{{ \DB::table('levels')->find(\DB::table('user_levels')->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->first()->level_id)->sign }}" width="30"></td>
            <td>{{ $person->name }} </td>
            <td>{{ $person->experience }}</td>
        </tr>
        @endforeach
    </table>
</div>
<div style="width: 49%;float: right;">
    <div style="height: 50px;line-height: 50px;text-align: center;;">军团榜</div>
    <table>
        <tr><th>军团</th><th>总战功</th></tr>
        @foreach($groups as $group)
        <tr>
            <td>{{ \DB::table('groups')->find($group->group_id)->name }}</td>
            <td>{{ $group->total }}</td>
        </tr>
        @endforeach
    </table>
</div>
<div style="clear:both;"></div>
@endsection
