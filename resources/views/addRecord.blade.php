@extends('layouts.master')

@section('content')
    
    <form style="color: #333" action="{{ route('postRecord') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <select name="user_id">
        @foreach($group_users as $group_user)
            <option value="{{ $group_user->id }}">{{ $group_user->name }}</option>
        @endforeach
        </select>
        <input type="text" name="recharge" placeholder="战绩">
        <button type="submit">记功</button>
        <a href="{{ route('groupAdmin') }}">返回</a>
    </form>
    
@endsection
