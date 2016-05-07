@extends('layouts.master')

@section('content')
    
    <form style="color: #333" action="{{ route('postAddUser') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <select name="user_id">
            <option></option>
        @foreach($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
        @endforeach
        </select>
        <button type="submit">中意他</button>
        <a href="{{ route('groupAdmin') }}">返回</a>
    </form>
    
@endsection
