@extends('layouts.master')

@section('content')
    <form action="{{ route('postBook') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <textarea name="content" placeholder="骚年，郁闷了，就来撸一发吧。" style="width: 100%;color: #333;height: 300px;background-color: #a5a5a5"></textarea>
        <button type="submit" style="float:right;width: 100px;height: 50px;background: #ff7518;color: #fff;border: solid 1px #dd5306;margin-top: 10px;">怒射</button>
        <div style="clear: both;"></div>
    </form>
@endsection
