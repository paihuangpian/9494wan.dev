@extends('admin.layouts.master')

@section('sidebar')
    <a href="{{ route('menus') }}">站点</a>
    <a href="{{ route('menus') }}">用户</a>
    <a href="{{ route('menus') }}" @if(Route::currentRouteName() == 'menus' || Route::currentRouteName() == 'addMenu') class="active" @endif>菜单</a>
    <a href="{{ route('menus') }}">数据</a>
@endsection

@section('title')

@endsection

@section('content')
    <div class="title">
        <h2>新增菜单</h2>
    </div>
    <form action="{{ route('postMenu') }}" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <table class="add">
            <tr>
                <td width="200">标题</td><td><input type="text" name="name" value=""></td>
            </tr>
            <tr>
                <td width="200">路由</td><td><input type="text" name="route" value=""></td>
            </tr>
            <tr>
                <td width="200">父级</td>
                <td>
                    <select class="" name="pid">
                        <option value="0">顶级</option>
                        @foreach($menus as $menu)
                            <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td width="200">状态</td>
                <td>
                    <input type="radio" name="status" value="1" checked="checked"> 开启
                    <input type="radio" name="status" value="0"> 关闭
                </td>
            </tr>
            <tr>
                <td width="200"></td>
                <td><button type="submit" class="btn-info">保存</button></td>
            </tr>
        </table>
    </form>
@endsection
