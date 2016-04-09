@extends('admin.layouts.master')

@section('sidebar')
    <a href="" class="active">游戏</a>
@endsection

@section('content')
    <div class="title">
        <h2>所有游戏</h2> <a href="{{ route('addGame') }}" class="btn-info">新增</a>
    </div>
    <table>
        
    </table>
@endsection