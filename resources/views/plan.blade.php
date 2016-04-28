@extends('layouts.master')

@section('content')
    
<table>
    <tr>
        <th>序号</th>
        <th>等级名称</th>
        <th>等级标志</th>
        <th>等级经验</th>
        <th>等级衰减值</th>
        <th>等级工资</th>
        <th>消费奖金百分比</th>
        <th>带薪休假天数</th>
    </tr>
    @foreach($levels as $key => $level)
    <tr>
        <td>{{ $key+1 }}</td>
        <td>{{ $level->name }}</td>
        <td><img src="/images/sign/{{ $level->sign }}"></td>
        <td>{{ $level->experience }}</td>
        <td>{{ $level->attenuation }}</td>
        <td>{{ $level->wages }}</td>
        <td>{{ $level->commission }}</td>
        <td>{{ $level->vacation }}</td> 
    </tr>
    @endforeach
</table>
@endsection
